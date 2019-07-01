<?php
//******************************************************
// Autor: Philip Ripstein, ESA
// Datum: 15.01.2018
// Programm/Funktion: registrieren
// File: regi.php
// Beschreibung:
// - Ermöglicht das Logon für die Kaffe-App
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
	
	$lv_username = 'Philip';
	$lv_password1 = '1234';
	$lv_password2 = '1234';
	
	
}else {
//*** Produmgebung Parameter ***************************
    $db_servername = "localhost";
	$db_name = "esa_kaffee";
	$db_username = "esa_kaffee";
	$db_password = "esa_kaffee";
	$db_tab_kaffee = "kaffee3";
	$lv_username = '';
	$lv_password1 = '';
	$lv_password2 = '';
	
//  Auswertung POST Input-Parameter *****************	
    if (! isset($_POST["Un"] ))  {$lv_username  = '';} else {$lv_username  = $_POST["Un"]; };
	if (! isset($_POST["Pw"] ))  {$lv_password1  = '';} else {$lv_password1  = $_POST["Pw"]; };
	if (! isset($_POST["Pw2"] )) {$lv_password2  = '';} else {$lv_password2  = $_POST["Pw2"]; };
	if (! isset($_POST["Email"] )) {$lv_email  = '';} else {$lv_email  = $_POST["Email"]; };
}

//*** Variablen initialisieren
$strSQL = '';
$lv_json = '';

//*** Array für die JSON Rückgabe erstellen.
$la_Status = array( "S" => false );
$la_Nummer = array( "ENr" => 0 );

// Verarbeitung der Eingabe...
//*** UN und PW früfen - Wenn leer ist Rückgabe = false
	if (  $lv_username <> '' and $lv_password1 <> ''  and $lv_password1 == $lv_password2 and $lv_email <> '') {
	// *** Auf DB Verbinden und prüfen ob username und password vorhanden sind
		//	Create connection / Fehler prüfen 
		$db_conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
		if ($db_conn->connect_error) {
			die("Connection failed: " . $db_conn->connect_error);
		}else{
			// kein Fehler / Prüfen ob User/Passwort existiert
			// SQL Abfrage String erstellen 
			$strSQL = "INSERT INTO `". $db_tab_kaffee ."` (`name`, `guthaben`, `Passwort`, `guthabenAlt`, `bezahlen`, `email`) VALUES ('". ucfirst($lv_username) . "',0,'" . $lv_password1 . "',0,0,'" . $lv_email . "');";
			if ($lv_debug) {echo "strSQL:$strSQL<hr>";}
			
			// SQL Abfrage ausführen
			$db_result = $db_conn->query($strSQL);
			if ($lv_debug){echo "db_result = "; echo print_r($db_result); echo "<hr>";};
			
			// $db_result kann leer (nicht gefunden) oder hat eine Zeile (Gefunden)
			//if($db_result->num_rows <> 0){
			if ($db_result) {
				$la_Status["S"] = true;
				$la_Nummer["ENr"] = 0;
			} else {
				$la_Status["S"] = false;
				$la_Nummer["ENr"] = 200;
			} //$db_result ende
			// db Verbindung wieder schliessen
			$db_conn->close();		
		} //db_conn ende
	}else {
		// Wenn Un oder Pw oder PW1 <> PW2 nicht korrekt sind 
		$la_Status["S"] = false;
		$la_Nummer["ENr"] = 100;
		if ($lv_debug) {echo "Un oder Pw leer oder PW1 <> PW2<hr>";}
	} //Kontrolle Un Pw ende

// Ausgabe des Resultates der Verarbeitung...	
	$la_Back   = array("R" => $la_Status );
	
	// JSON erstellen und zurück geben
    $lv_json = json_encode($la_Back);
	if ($lv_debug){
		echo var_dump($lv_json); echo "<hr>";
	} else{
		// Rückgabe des JSON 
		echo $lv_json;
	}
?>