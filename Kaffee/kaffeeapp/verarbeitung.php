<?php
include "inc/global.php";
include "inc/head.inc";
//include "test03.php";
	//Parameters deklarieren und abfüllen
	if (! isset($_POST["formAnzKaffee"])) {$formAnzKaffee = '0';}  else {$formAnzKaffee = $_POST["formAnzKaffee"]; };
    if (! isset($_POST["formUserId"]))    {$formUserId = '';}      else {$formUserId    = $_POST["formUserId"]; };
	if (! isset($_POST["formPasswd"]))    {$formPasswd = '';}      else {$formPasswd    = $_POST["formPasswd"]; };
	if (! isset($_POST["formEmail"]))     {$formEmail = '';}       else {$formEmail     = $_POST["formEmail"]; };
	if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
	if (! isset($_POST["form_benutzername"])) {$form_benutzername = "";} else {$form_benutzername = $_POST["form_benutzername"]; };
	if (! isset($_POST["totalAnzKaffee"])) {$totalAnzKaffee = "";} else {$totalAnzKaffee = $_POST["totalAnzKaffee"]; };
	//Default anzahl Kaffee ist 1Stk.
	$defaultAnzKaffee = 1;
if ($paramVT == "b") {
	//Debug Variable True or false
	$debug = false;
	//Cookies lesen
	if (! isset($_COOKIE["BenutzerNamenCookie"])) {$form_benutzername = '';}  else {$form_benutzername = $_COOKIE["BenutzerNamenCookie"]; };
	if (! isset($_COOKIE["BenutzerPasswordCookie"])) {$formPasswd = '';}  else {$formPasswd = $_COOKIE["BenutzerPasswordCookie"]; };
		//brauche user ID für spätere abhandlungen
	$formUserId = get_UserId($form_benutzername, $formPasswd, $servername, $username, $password, $dbname);
	//holt das Guthaben des Benutzers und speichert diese.
	$lv_UserGuthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);
	//holt das E-mail des Benutzers und wird später für Anweisungen benötigt
	$lv_UserEmail = get_UserEmail ($formUserId, $servername, $username, $password, $dbname);
	
	//Debug Modus
	if($debug == true){
	var_dump($formUserId);
	}
	
	//Falls Id Leer von funktion get_UserID // bedeutet: Login nicht erfolgreich
	if($formUserId != ""){
		//er darf Abbuchen
		//echo "<script>
		//		alert('Hallo if ID nicht leer');
		//	  </script>";
		if($debug == true){
			echo "Erfolg <br>";
		}	
	}else{
		//echo "<script>
		//alert('Hallo else id leer');
		//</script>";
		//zurück schicken auf Login
		//TODO: Variabeln Test und Prod.
		header('Location: http://intranet.esa.ch/kaffeeapp/index.php?vt=error');
		//header('Location: http://intranet.esa.ch/kaffeetest/test03.php');
	}
	?>
	<!-- Zurück Button Verarbeitung -->
	<p><a href="" onclick="eraseAllCookie()" class="button">Zurück zum Anmelden</a></p>
	
	
	<!-- erkennt den value wo id="textAnzKaffeRange"  und schreibt dort anzKaffee hin / Wenn Balken verändert wird wird die Funktion aufgerufen-->
	<script>	
	function eraseAllCookie(){
		eraseCookie("BenutzerNamenCookie");
		eraseCookie("BenutzerPasswordCookie");
	}
		//Variable "clicks" deklariert die mit dem wert 1 anfängt.
		var clicks = 1;
		var totalAnzKaffee = 0;
		function updateTextInput(anzKaffee) {
			clicks += 1;		
			anzKaffee = clicks;
			document.getElementById('textAnzKaffeRange').innerHTML=anzKaffee;
			document.getElementById('formAnzKaffee').value=anzKaffee;
		}
		function deupdateTextInput(anzKaffee) {
			clicks -= 1;
			if (clicks < 1){
				clicks = 1
			}
			anzKaffee = clicks;
			document.getElementById('textAnzKaffeRange').innerHTML=anzKaffee;
			document.getElementById('formAnzKaffee').value=anzKaffee;
		}
		function zaehlen() {
			   totalAnzKaffee = totalAnzKaffee + 1;
		}
		function chkFormular(){
			if(document.Formular.formEmail) {
				if(document.Formular.formEmail.value == "")  {
					document.getElementById("formemailerror").style.visibility = "visible";
					document.Formular.formEmail.focus();
					return false;
				}
			}
		}
		// Create cookie
		function createCookie(name, value, days) {
			var expires;
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				expires = "; expires="+date.toGMTString();
			}
			else {
				expires = "";
			}
			document.cookie = name+"="+value+expires+"; path=/";
		}
		// Erase cookie
		function eraseCookie(name) {
			createCookie(name,"",-1);
		}
		
	</script>	
	<!--Output Text name,guthaben-->
	<h1> <center><?php echo $form_benutzername; ?> </center></h1>
	<!--Guthaben Rot ausgeben-->
	<?php
		//Falls User Guthaben kleiner 0 ist zeige es rot an.
		if ($lv_UserGuthaben <= 0){
			echo"<h1> <center class=\"abstand\"><span class=\"rot\"> $lv_UserGuthaben </span>Fr.</center></h1>";
		}
		else {
			echo"<h1> <center class=\"abstand\"> $lv_UserGuthaben Fr.</center></h1>";
		}
	?>
	
	
	<center>
	<!-- button+ für zähler -->
    <button class ="anzKaffee" type="button" onClick="updateTextInput()">+ 1 Kaffee</button>
		<!-- button- für zähler -->
    <button class ="anzKaffee" type="button" onClick="deupdateTextInput()">- 1 Kaffee</button>
	</center>
	<!-- zähler output-->
    <div><center><p>Anzahl Kaffee: <span id="textAnzKaffeRange"><?php echo $defaultAnzKaffee;?></span></p></center></div>

	
	<?php
		//Falls User Guthaben kleiner 0 ist zeige es rot an.
		if ($lv_UserGuthaben <= 0){
			echo"<center><p class=\"rot\">BITTE KAFFEE-KONTO AUFLADEN!</p></center>";
		}
		if ($lv_UserEmail == ""){
			echo"<center><p class=\"rot\">Bitte E-mail Adresse noch eingeben</p></center>";
		}
	?>
	<!-- Abbuchen / mit E-Mail -->
	<form action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=p"; ?>"name="Formular" onSubmit="return chkFormular()" method="Post">
	    <input type="hidden" name="formUserId" value="<?php echo $formUserId; ?>">
		<input type="hidden" name="formAnzKaffee" id="formAnzKaffee" value="<?php echo $defaultAnzKaffee;?>">
		<input type="hidden" name="totalAnzKaffee" id="totalAnzKaffee" value="<?php echo $totalAnzKaffee;?>">
		<label for="passwd"></label><br>
		
		<?php 
		//Falls Email leer auf DB dann bitte jetzt eintragen.
		if ($lv_UserEmail == ""){
			echo '<input type="email" name="formEmail" id="formEmail" class="formimput" autofocus="autofocus" length="5" placeholder="Bitte E-mail eingeben" >';
			echo "<br><center><label class=\"formerrorlabel\" name=\"formemailerror\" id=\"formemailerror\">Bitte E-mail eingeben</label><center>";
		}
		?>
		<!-- Abbuchen Button -->
		<div><center><input id="verarbeitungButton" type="submit" value="Abbuchen" onClick="zaehlen()"><br></center></div>
	</form>

<?php
	}
//If im Link am ende ein "p"
elseif ($paramVT == "p") {
  echo "<body>
        <h1>Kaffee-Erfassung Esa Verarbeitung (Verbuchung)</h1>";
	// Auf DB Verbinden
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	$strSQL = "select guthaben from kaffee4 where ID='". $formUserId . "' ";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result->num_rows > 0) {
		//var_dump($result);	
		while($row = $result->fetch_assoc()) {	
				//var_dump($result);		
				//var_dump($row);		
				//unset($_COOKIE['BenutzerNamenCookie']);
				//unset($_COOKIE['BenutzerPasswordCookie']);
				//setcookie ("BenutzerNamenCookie2", "", time() - 3600);
				//setcookie ("BenutzerPasswordCookie2", "", time() - 1);
				//Anzahl Kaffe kleiner 1 ?
				$EntgueltigKaffePreis = $formAnzKaffee * $KaffePreis;
				$altesGuthaben = $row["guthaben"];
				$neuesGuthaben =  $altesGuthaben - $EntgueltigKaffePreis;
				$strSQL = "update kaffee4 set guthaben=".$neuesGuthaben." where ID='". $formUserId . "' ";
				//echo "<hr>$EntgueltigKaffePreis = $formAnzKaffee * $KaffePreis;<hr>$strSQL<hr>";
				$result = $conn->query($strSQL);
				// Passwort muss gültig sein und EMAIL muss auch bekannt sein, um E-mail zu speichern
				if($formEmail != ""){
					$strSQL = "UPDATE `kaffee4` SET `email`='". $formEmail."' WHERE ID='". $formUserId . "' ";
					$result = $conn->query($strSQL);
				}
				// in jedem Fall, wenn das Passwort OK ist muss zur Startseite zurückgekehrt werden.
				//header($gv_Hederlocation);
				//var_dump($row);
				// ************************************************************************************						
				
				//echo" <button onclick=\"history.go(-1);\">Back </button>";
				header('Location: http://intranet.esa.ch/kaffeeapp/verarbeitung.php?vt=b');
		}
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!";
		echo '<a href="index.php" class="button">Zurück</a>';
	}	
	
	// Verbindung wieder schliessen
	$conn->close();
	//header("Refresh:0");
	
}

?>	
