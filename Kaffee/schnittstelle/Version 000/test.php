<?php
$lv_TestSystem = false;
if ( $lv_TestSystem) {
//*** Testumgebung Parameter ***************************
    $servername = "localhost";
	$dbname = "esa_kaffee";
	$username = "root";
	$password = "";
	$Username = 'Phil';
	$Password = '1234bb';
	$lv_Tab = "kaffee2";
}else {
//*** Produmgebung Parameter ***************************
    $servername = "localhost";
	$dbname = "esa_kaffee";
	$username = "esa_kaffee";
	$password = "esa_kaffee";
	$Username = 'philip';
	$Password = 'abcde';
	$lv_Tab = "kaffee3";
}
// *** Auswertung Input-Parameter **********************	
//  if (! isset($_POST["Usernameapp"])) {$Username = 'leer';} else {$Username = $_POST["Usernameapp"]; };
//	if (! isset($_POST["Passwordapp"])) {$Password = 'leer';} else {$Password = $_POST["Passwordapp"]; };
//	if (! isset($_POST["Password2app"])) {$Password2 = 'leer';} else {$Password2 = $_POST["Password2app"]; };

//Die Variablen sollten nur Ihre Wertzuweisen bekommen wenn die App verwendet wird.
	$Username = $_POST["Usernameapp"]; 
	$Password = $_POST["Passwordapp"]; 
	$Password2 = $_POST["Password2app"]; 
	
// Auf DB Verbinden
// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{       
		// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
		$strSQL = "SELECT Name FROM `". $lv_Tab ."` where `name` = '".ucfirst($Username) . "' and `Passwort` = '" . $Password . "'";
		//echo "$strSQL<hr>";
		$result = $conn->query($strSQL);
		//echo var_dump($result);
		if($result->num_rows <> 0){
			echo json_encode($result->fetch_assoc());
		} else {
			echo "0";	
		} //$result
	} //connect_error
	$conn->close();		// Verbindung wieder schliessen
?>