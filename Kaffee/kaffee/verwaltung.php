<?php
session_start();

include "inc/global.php";
include "inc/head.inc";
    if (! isset($_POST["formAdminName"])) {$formAdminName = '';} else {$formAdminName = $_POST["formAdminName"]; };
	if (! isset($_POST["formPasswd"]))    {$formPasswd = '';}    else { $formPasswd = $_POST["formPasswd"]; };
	if (! isset($_POST["formBezahlen"]))  {$formBezahlen = '0';} else { $formBezahlen = $_POST["formBezahlen"]; };
	if (! isset($_POST["formUserId"]))    {$formUserId = '';}    else { $formUserId = $_POST["formUserId"]; };
	if (! isset($_POST["formUsername"]))  {$formUsername = '';}  else { $formUsername = $_POST["formUsername"]; };
	if (! isset($_POST["formfarbe"]))     {$formfarbe = '';}     else { $formfarbe    = $_POST["formfarbe"]; };
	if (! isset($_GET["vt"])) {$paramVT = '';}                   else { $paramVT = $_GET["vt"]; };
	
	
$lv_AdmSet  = False;	
if(!isset($_SESSION['AdmSet'])) {
   //die("Bitte erst einloggen"); //Mit die beenden wir den weiteren Scriptablauf   
	// Passwort Prüfen ***************************************************************************************
	// Auf DB Verbinden
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	$strSQL = "select Passwort from kaffee4 where Name='". $formAdminName . "' and Passwort='". $formPasswd . "'  and Admin='1' ";
	$result = $conn->query($strSQL);
	$conn->close();
	// SQL auswerten und ausgeben
	if ($result->num_rows) {
		$lv_AdmSet  = $_SESSION['AdmSet'] = true;
		
	}	
   
} else {
		$lv_AdmSet  = $_SESSION['AdmSet'];
	
}
	
	
echo "<h1 class=\"forueberschriftverw\" >Kaffee - <b1 class=\"VerwaltungRot\">Administration</b1></h1>";
echo "<p><img src='Esa.jpg' / width='230px'></p>"; 	 
echo "<p><a href=\"index.php\" class=\"button\">Zurück</a></p>";

if ($paramVT == "a" and $lv_AdmSet == true) {
		// Anzeigen der User..
		echo "<table><thead><tr><th>Name</th><th>Saldo</th><th>E-mail</th><th>Bezahlen</th><th>Löschen</th><th>PW</th><th>Farbe</th><th>Buchen</th></tr></thead><tbody>";
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// SQL Abfrage vorbereiten und ausführen 
		$strSQL = "select id, name, guthaben, passwort, email,farbe from kaffee4 where Admin=0 and aktive=true ORDER BY `guthaben` DESC";
		$conn->query("SET NAMES 'utf8'");
		$result = $conn->query($strSQL);
	
		// SQL auswerten und ausgeben
		if ($result->num_rows > 0) {
			// output data für jede Zeile
			while($row = $result->fetch_assoc()) {
				echo '<tr>
						<td class="sp1"> 
						<form  action="verwaltung.php?vt=b" method="post" autocomplete="off">
						<input type="hidden" name="formUserId" value="'. $row["id"].'">
						<input type="input" minlength="3" name="formUsername"  value="'. $row["name"].'" >
						</td>
						<td>'. $row["guthaben"].'</td>
						<td>'. $row["email"].'</td>
						<td>
						<input type="hidden" name="formUserId" value="'. $row["id"].'">
						<input type="input" name="formBezahlen"  value="0.00" pattern="[0-9.-]+">
						</td>
						<td><input type="checkbox" name="formDel" value="1"></td>
						<td><input type="checkbox" name="formpwerneuern" value="1"></td>
						<td><input type="input" name="formfarbe" value="'. $row["farbe"].'"></td>
						<td><input class="submitbutton" type="submit" name="formSubmit" value="Buchen"></td>
					</form>
					
				'; // name ist= + ein kaffee
				$name = $row["name"];
			}
			echo "</table>";
			
		}else {
			echo "</table>";
			echo "<p>Leider wurde nichts gefunden...</p>";
		}
		
		
		$name = $row["name"];
		// Verbindung wieder schliessen
		$conn->close();


} elseif ($paramVT == "b"  and $lv_AdmSet == true) {	 
	
	//Verbuchen von Zahlung des Users...
	if (isset($_POST['formBezahlen']) and $formBezahlen != 0 ) {
		// echo "Verbuchen..$formBezahlen<br>";	
		if ( DoSQL("UPDATE `kaffee4` SET guthaben = guthaben + $formBezahlen where ID=$formUserId;", $servername, $username, $password, $dbname) ) {
			echo "<p>ok Daten wurden Verarbeitet ...</p>";
		} else {
			echo "<p>Error beim Verbuchen des USERS $formUserId ....</p>";
		}
	}
	//User löschen (entgültig...)
	if (isset($_POST['formDel'])) {
		// checkbox has been checked
		if ( DoSQL("UPDATE `kaffee4` SET aktive = false WHERE `ID`=$formUserId;", $servername, $username, $password, $dbname) ) {
			echo "<p>Verarbeitung Löschen OK...</p>";
		} else {
			echo "<p>Error beim löschen des USERS $formUserId ....</p>";
		}
	} 
	echo "<p><a href=\"verwaltung.php?vt=a\" class=\"button\">Zurück zum Bearbeiten</a></p>";

	
	//Password vergessen
	if (isset($_POST['formpwerneuern'])) {
		// checkbox has been checked
		if ( DoSQL("UPDATE `kaffee4` SET passwort = '1234', passwort2 = '0' WHERE `ID`=$formUserId;", $servername, $username, $password, $dbname) ) {
			echo "<p>Passwot wurde zurückgesetzt ...</p>";
		} else {
			echo "<p>Error beim Passwort setzen des USERS $formUserId ....</p>";
		}
	} 
	
	
	//Username ändern
	if (isset($_POST['formUsername'])) {
		if ( DoSQL("UPDATE `kaffee4` SET name = '$formUsername' WHERE `ID`=$formUserId;", $servername, $username, $password, $dbname) ) {
			echo "<p>Username wurde von '$formUsername' auf '$formUsername' geändert ...</p>";
			//var_dump($_POST['formUsername']);
			//var_dump($name);
		} else {
			echo "<p>Fehler beim ändern des Usernames '$formUserId' ....</p>";
		}
	} 
	
	if (isset($_POST['formfarbe'])) {
		if ( DoSQL("UPDATE `kaffee4` SET farbe = '$formfarbe' WHERE `ID`=$formUserId;", $servername, $username, $password, $dbname) ) {
			echo "<p>Farbe von $formUsername wurde auf $formfarbe geändert ...</p>";
		} else {
			echo "<p>Fehler beim ändern der Farbe '$formfarbe' ....</p>";
		}
	} 
		
} else 
{
		echo "Falsches Passwort bitte erneut versuchen";
}	

	// Verbindung wieder schliessen

?>	
