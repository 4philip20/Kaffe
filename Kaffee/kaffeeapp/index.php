<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA Kaffee-Verarbeitung</title>
	<link href="css/main.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" sizes="96x96" href="Esa.jpg">
	<!-- JavaScript einbinden -->
	<script language="javascript" type="text/javascript" src="inc/func.js"></script>
  </head>
  <body>
  <!--<body onload="load()">-->
  <!-- Login Formular beim Absenden auf Verarbeitung -->
  <form method="post" id="anfang" action="verarbeitung.php?vt=b" onsubmit="buttonclick();">
  <input type="text" placeholder="Benutzername eingeben" class="formimputanmelden" value=""   id ="use" name="form_benutzername" />
  <input type="password" placeholder="Passwort eingeben" class="formimputanmelden" value="" id ="pwd" name="formPasswd" />
  <input type="submit"  value="Login"/>
</form>

<script>
//Hauptprogramm
//Cookie lesen IMMER beim starten der Seite
var BenutzerNamenCookie = readCookie("BenutzerNamenCookie");
var BenutzerPasswordCookie = readCookie("BenutzerPasswordCookie");
// Namen des Cookie ausgeben beim start der Applikation
//alert(BenutzerNamenCookie);
//alert(BenutzerPasswordCookie);
</script>  

<!-- Code Start---------------------------------------------------------------------------- -->
<?php
//Debug Variable True or false
$debug = false;

$strURL = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
if($debug == true){
	echo "$strURL <br>";
}
if($strURL == "intranet.esa.ch/kaffeeapp/index.phpvt=error"){
	echo "<p class=\"rot\">Bitte Benutzerdaten korrekt angeben.<p><br>";
}
if($strURL == "intranet.esa.ch/kaffeeapp/index.php"){
	echo "Ok <br>";
	echo "<script>
		document.getElementById('anfang').submit();
		</script>";
}
//Include Global.php weil alle funktionalitäten dort sind
include "inc/global.php";
//Variablen setzten mit Cookie Wert.
if (! isset($_COOKIE["BenutzerNamenCookie"])) {$benutzerName = '';}  else {$benutzerName = $_COOKIE["BenutzerNamenCookie"]; };
if (! isset($_COOKIE["BenutzerPasswordCookie"])) {$benutzerPassword = '';}  else {$benutzerPassword = $_COOKIE["BenutzerPasswordCookie"]; };
//Debug Variable
if($debug == true){
	echo "$benutzerName <br>";
	echo "$benutzerPassword <br>";
}
//if cookie gesetzt denn melde an
//if ($benutzerName =! "" && $benutzerPassword =! ""){
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
// SQL Abfrage vorbereiten und ausführen 
$strSQL = "select id,name, Passwort,guthaben from kaffee4 where `name`='".$benutzerName."' and `Passwort`='".$benutzerPassword."'";
$conn->query("SET NAMES 'utf8'");
$result = $conn->query($strSQL);
// SQL auswerten und ausgeben
if ($result->num_rows > 0) {
	// output data für jede Zeile
	while($row = $result->fetch_assoc()) {
		if ($row["Passwort"] == $benutzerPassword ){
		
			if($debug == true){
				echo "erfolgreich <br>";
			}
			//TODO: href link hier gehts zum abbuchen
			
			
		}else{
			echo "Passwort ist falsch! <br>";
			var_dump($row["Passwort"]);
			var_dump($benutzerPassword);
		}			
	}
 
}else {
	
}
// Verbindung wieder schliessen

$conn->close();
//}
?>
<!-- Code Ende---------------------------------------------------------------------------- -->
<!-- <fieldset class="footer"><legend class="laklein">Powerd by Philip Rippstein</legend></fieldset>	 -->
</body>
</html>