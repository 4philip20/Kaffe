<?php
//******************************************************
// Autor: Philip Ripstein, ESA
// Datum: 15.01.2018
// Programm/Funktion: getguthaben
// File: getguthaben.php
// Beschreibung:
// - Ermöglicht die Abfrage des Guthabens 
// - Die Parameter sind mit der Methode POST zu empfangen
// - JSON wird als Seite zurückgegeben
// - Aus Sicherheitsgründen soll nur true oder fales zurückgegeben werden.
//
// POST wird nur im Produktiven Modus ausgewertet.
///
// Parameter IN: UserName = "Un", Password = "Pw"
// Parameter OUT: JSON L (für Login) S (für Status)
//                S kann den Wert true oder false haben.
//
// Datum Änderungen:
// 15.01.18 Initial
// 31.01.18 Komentare und JSON Anpassung
//******************************************************

// *** Variable für die Umstelllung TEST oder Produktive
$lv_TestSystem = false;
$lv_debug = false;
if ( $lv_TestSystem) {
//*** Testumgebung Parameter ***************************
    $db_servername = "localhost";
	$db_name = "esa_kaffee";
	$db_username = "root";
	$db_password = "";
	$db_tab_kaffee = "kaffee2";
	
	$lv_username = 'Phil';
	$lv_password = '1234';
	
}else {
//*** Produmgebung Parameter ***************************
    $db_servername = "localhost";
	$db_name = "esa_kaffee";
	$db_username = "esa_kaffee";
	$db_password = "esa_kaffee";
	$db_tab_kaffee = "android";
	$lv_username = '';
	$lv_password = '';
//  Auswertung POST Input-Parameter *****************	
    if (! isset($_POST["Un"] )) {$lv_username  = '';} else {$lv_username  = $_POST["Un"]; };
	if (! isset($_POST["Pw"] )) {$lv_password  = '';} else {$lv_password  = $_POST["Pw"]; };
}

//*** Variablen initialisieren
$strSQL = '';
$lv_json = '';
$lv_Guthaben = Null;
$lv_row = NULL;

//*** Array für die JSON Rückgabe erstellen.
$la_Status = array( "S" => false,
					"GH" => null);

// Verarbeitung der Eingabe...
//*** UN und PW früfen - Wenn leer ist Rückgabe = false
	if ( $lv_username <> '' and $lv_password <> '') {
	// *** Auf DB Verbinden und prüfen ob username und password vorhanden sind
		//	Create connection / Fehler prüfen 
		$db_conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
		if ($db_conn->connect_error) {
			die("Connection failed: " . $db_conn->connect_error);
		}else{
			// kein Fehler / Prüfen ob User/Passwort existiert
			// SQL Abfrage String erstellen 
			$strSQL = "SELECT Guthaben FROM `". $db_tab_kaffee ."` where `name` = '".ucfirst($lv_username) . "' and `Passwort` = '" . $lv_password . "'";
			if ($lv_debug) {echo "strSQL:$strSQL<hr>";}
			
			// SQL Abfrage ausführen
			$db_result = $db_conn->query($strSQL);
			if ($lv_debug){echo print_r($db_result); echo "<hr>";};
			
			// $db_result kann leer (nicht gefunden) oder hat eine Zeile (Gefunden)
			if($db_result->num_rows <> 0){
				$la_Status["S"] = true;
				// Guthaben Wert aus db_result lesen
				$lv_row = $db_result->fetch_array(MYSQLI_NUM);
				$la_Status["GH"] =  $lv_row[0];
			} else {
				$la_Status["S"] = false;
			} //$db_result ende
			// db Verbindung wieder schliessen
			$db_conn->close();		
		} //db_conn ende
	}else {
		$la_Status["S"] = false;
		if ($lv_debug) {echo "Un oder Pw leer<hr>";}
	} //Kontrolle Un Pw ende

// Ausgabe des Resultates der Verarbeitung...	
	$la_Back   = array("getGH" => $la_Status);
	// JSON erstellen und zurück geben
    $lv_json = json_encode($la_Back);
	if ($lv_debug){
		echo var_dump($lv_json); echo "<hr>";
	} else{
		// Rückgabe des JSON 
		echo $lv_json;
	}
?>