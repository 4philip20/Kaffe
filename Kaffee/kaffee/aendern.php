<?php
include "inc/global.php";
include "inc/head.inc";
// Formular Variablen in Locale Veriablen übernehmen...
if (! isset($_POST["form_benutzername"])) {$form_benutzername = "";} else {$form_benutzername = $_POST["form_benutzername"]; };
if (! isset($_POST["form_passwort"])) {$form_passwort = '';} else { $form_passwort = $_POST["form_passwort"]; };
if (! isset($_POST["form_passwortn1"])) {$form_passwortn1 = '';} else {$form_passwortn1 = $_POST["form_passwortn1"]; };
if (! isset($_POST["form_passwortn2"])) {$form_passwortn2 = '';} else {$form_passwortn2 = $_POST["form_passwortn2"]; };
if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };

if ($paramVT == "v"){
	
	if ($form_passwortn1 == $form_passwortn2){
	if (strlen($form_passwortn1) >= 4 ){
		// ermitteln ob USER und PWD passen...
		// Auf DB Verbinden
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
		$form_benutzername = ucfirst  ($form_benutzername);
		$strSQL = "select * from kaffee4 WHERE `name`='".$form_benutzername."' and `Passwort`='".$form_passwort."'"; 
		//echo "$strSQL<hr>";
		$conn->query("SET NAMES 'utf8'");
		$result = $conn->query($strSQL);
		$conn->close();
		// SQL auswerten und ausgeben
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			if ($row["Passwort"] <> $form_passwortn1 ) {
				$strSQL = "UPDATE `kaffee4` SET `Passwort`='". $form_passwortn1."' WHERE `ID`='".$row["ID"]."'"; 
				//echo "$strSQL<hr>";
				$lv_res = DoSQL($strSQL, $servername, $username, $password, $dbname);
				
				if ( $lv_res ){
					echo "ok Passwort geändert...";
				} else {
					echo "Passwort nicht geändert";
				}
			} else {
				echo "fehler 003 PWD ändern! new-PWD = PWD.<br>";
			}
			
		} else {
			echo "fehler 002 PWD ändern! User oder PWD nicht OK.<br>";
		}
	} else { //if ($form_passwortn1 < 4){
		echo "fehler 004 PWD ändern! new PWD1 zu kurz<br>";
	} //if ($form_passwortn1 == $form_passwortn2){
		
} else { //if ($form_passwortn1 == $form_passwortn2){
		echo "fehler 001 PWD ändern! new PWD1 ungleich new PWD2<br>";
	} //if ($form_passwortn1 == $form_passwortn2)
}
?>
	<h1 class="forueberschriftaedern">Kaffee - Passwort ändern</h1>
		<img src="Esa.jpg" width="230px">
		<!-- Registration Formular -->
		<p><a href="index.php" class="button">Zurück</a></p>


<fieldset>
		<form id="formPasswort" action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=v"; ?>" method="Post">
			<fieldset><legend class="labold">Login-Daten</legend>
				<label class="formLabel1" form="formRegistration" >Benutzername:</label>
				<input type="text" name="form_benutzername" id="fuerlabel" placeholder="Vor- und Nachname" value="<?php echo $form_benutzername; ?>"><br>
				<label class="formLabel1" form="formRegistration" class="lafarbig ">Passwort:</label>
				<input type="password" name="form_passwort" id="fuerlabel" placeholder="mind. 4 Zeichen" value="<?php echo $form_passwort; ?>"><br>
				<label class="formLabel1" form="formRegistration" class="lafarbig ">Neues Passwort:</label>
				<input type="password" name="form_passwortn1" id="fuerlabel" placeholder="Neues Passwort eingeben" value="<?php echo $form_passwortn1; ?>"><br>
				<label class="formLabel1" form="formRegistration" class="lafarbig ">Neues Passwort wiederholen:</label>
				<input type="password" name="form_passwortn2" id="fuerlabel" placeholder="Neues Passwort wiederholen" value="<?php echo $form_passwortn2; ?>"><br>
				<div id="div01"><input type="submit" value="Ändern"></div>
			</fieldset>
		</form> 
</fieldset>
		
	
<?php	
?>