<?PHP
// SQL Server Anmeldungsvariablen
	$servername = "localhost";
	$dbname = "esa_kaffee";
// Prod oder TestSystem
	$ProdSystem = true;
	
	
if($ProdSystem == false){
// TestSystem
	$username = "root";
	$password = "";
	$gv_Hederlocation = "Location: http://localhost/kaffeeapp/index.php";
}	

if($ProdSystem == true){
// Produktive System 
	$username = "esa_kaffee";
	$password = "esa_kaffee";
	$gv_Hederlocation = "Location: http://intranet.esa.ch/kaffeeapp/index.php";
}	
	
// header Location Variable
// TestSystem
     //
	
// Produktive System 
	
	
// KaffePreis Variable
	$KaffePreis = '0.50';
	
//*******************************************************************************
function registrationBenutzer( $lv_benutzername, $lv_passwort, $lv_email, $servername, $username, $password, $dbname) 
{
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	
	$strSQL = "INSERT INTO `kaffee4` (`name`, `guthaben`, `Passwort`, `guthabenAlt`, `bezahlen`, `email`) VALUES ('". ucfirst($lv_benutzername) . "',0,'" . $lv_passwort . "',0,0,'" . $lv_email . "');";
    //ucfirst  macht 1 Buchstabe gross
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result) {
		$conn->close();		// Verbindung wieder schliessen
		return true;
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!";
		$conn->close();		// Verbindung wieder schliessen
		return false;
	}
	

}
//get ID`			
function get_UserId( $form_benutzername, $formPasswd, $servername, $username, $password, $dbname){
	//$lv_UserName = '';

 	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}
	$strSQL  = 'Select `id` from `kaffee4` WHERE `name`=\''.$form_benutzername.'\'and `Passwort`=\''.$formPasswd.'\'';
	//echo $strSQL."<br>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	if ($result->num_rows === 1) {
		// output data für erste Zeile
		$row = $result->fetch_assoc();
		$lv_UserId = $row["id"];

	} else {
		$lv_UserId = "";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserId;
	
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
		$lv_UserEmail = "Leider ist Ihre E-mail nicht abrufbar";
	}
	$conn->close();		// Verbindung wieder schliessen
	return $lv_UserEmail;
	
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