<?PHP
// SQL Server Anmeldungsvariablen
	$servername = "localhost";
	$dbname = "esa_kaffee";
// TestSystem
	//$username = "root";
	//$password = "";

	
// Produktive System 
	$username = "esa_kaffee";
	$password = "esa_kaffee";
	
	
// header Location Variable
// TestSystem
    // $gv_Hederlocation = "Location: http://localhost/kaffee/index.php";
    // $gv_HederlocationLogin = "Location: http://localhost/kaffee/anmelden.php?vt=error";
    // $gv_HederlocationLogin2 = "http://localhost/kaffee/anmelden.php";
    
	
// Produktive System 
	$gv_Hederlocation = "Location: http://intranet.esa.ch/kaffee/index.php";
	$gv_HederlocationLogin = "Location: http://intranet.esa.ch/kaffee/anmelden.php?vt=error";
	$gv_HederlocationLogin2 = "http://intranet.esa.ch/kaffee/anmelden.php";
	
// KaffePreis Variable
	$KaffePreis = '0.50';
	
//*******************************************************************************
function registrationBenutzer( $lv_benutzername, $lv_passwort, $lv_email, $farbe, $servername, $username, $password, $dbname) 
{
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	
	$strSQL = "INSERT INTO `kaffee4` (`name`, `guthaben`, `Passwort`, `Passwort2`, `farbe`, `email`) VALUES ('". ucfirst($lv_benutzername) . "',0,'" . $lv_passwort . "',0,'".$farbe."','" . $lv_email . "');";
    //ucfirst  macht 1 Buchstabe gross
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result) {
		$conn->close();		// Verbindung wieder schliessen
		return true;
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!! '$farbe'<br> '$lv_email'";
		$conn->close();		// Verbindung wieder schliessen
		return false;
	}
	

}
function get_UserName($lvID, $servername, $username, $password, $dbname){
	$lv_UserName = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `name` from `kaffee4` WHERE `ID`=\''.$lvID.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserName = $row["name"];

	} else {
		$lv_UserName = "???";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserName;
	
}

function get_UserGuthaben($lvID, $servername, $username, $password, $dbname){
	$lv_UserGuthaben = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `Guthaben` from `kaffee4` WHERE `ID`=\''.$lvID.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserGuthaben = $row["Guthaben"];

	} else {
		$lv_UserGuthaben = "Leider ist Ihr Guthaben nicht abrufbar";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserGuthaben;
	
}

function get_UserEmail($lvID, $servername, $username, $password, $dbname){
	$lv_UserEmail = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `email` from `kaffee4` WHERE `ID`=\''.$lvID.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserEmail = $row["email"];

	} else {
		$lv_UserEmail = "Leider ist Ihr Guthaben nicht abrufbar";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserEmail;
	
}

function get_UserFarbe($lvID, $servername, $username, $password, $dbname){
	$lv_UserFarbe = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `farbe` from `kaffee4` WHERE `ID`=\''.$lvID.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserFarbe = $row["farbe"];

	} else {
		$lv_UserFarbe = "Leider ist Ihre Farbe nicht abrufbar";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserFarbe;
	
}

function get_UserID($form_benutzername, $servername, $username, $password, $dbname){
	$lv_UserID = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `ID` from `kaffee4` WHERE `name`=\''.$form_benutzername.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserID = $row["ID"];

	} else {
		$lv_UserID = $strSQL;
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserID;
	
}

function get_UserPw($lv_benutzername, $servername, $username, $password, $dbname){
	$lv_UserPw = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `Passwort` from `kaffee4` WHERE `id`=\''.$lv_benutzername.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserPw = $row["Passwort"];

	} else {
		$lv_UserPw = "NIX";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserPw;
	
}
function get_UserPw2($lv_benutzername, $servername, $username, $password, $dbname){
	$lv_UserPw = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `Passwort2` from `kaffee4` WHERE `id`=\''.$lv_benutzername.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserPw = $row["Passwort2"];
		

	} else {
		$lv_UserPw = "0";
		
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserPw;
	
}



function DoSQL($lvSQL, $servername, $username, $password, $dbname){
//	echo "$lvSQL<hr>";
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	// SQL auswerten und ausgeben
	if ($conn->query($lvSQL) === TRUE) {
		$conn->close();		// Verbindung wieder schliessen
		return true;
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!". $conn->error;
		$conn->close();		// Verbindung wieder schliessen
		return false;
	}
}



function zurueckRegistrieren ($form_benutzername, $form_passwort, $form_passwort2) {
?>
<fieldset class="footer">
<form id="formZurueck" action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=r"; ?>" method="Post">
	<input type="hidden" name="form_benutzername" value="<?php echo $form_benutzername; ?>">
	<input type="hidden" name="form_passwort"     value="<?php echo $form_passwort; ?>">
	<input type="hidden" name="form_passwort2"    value="<?php echo $form_passwort2; ?>">  
	<div id="div01" class="button"><input type="submit" VALUE="Zurück"></div>
</form>
</fieldset>	
<?PHP	
}
	
?>