<?php

if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
if (! isset($_POST["form_benutzername"])) {$benutzerName = '';} else { $benutzerName = $_POST["form_benutzername"]; };
if (! isset($_POST["formPasswd"])) {$benutzerPassword = '';} else { $benutzerPassword = $_POST["formPasswd"]; };
//für E-mail
if (! isset($_GET["Vorname"])) {$Vorname = '';} else { $Vorname = $_GET["Vorname"]; };
if (! isset($_GET["Nachname"])) {$Nachname = '';} else { $Nachname = $_GET["Nachname"]; };
if (! isset($_GET["pwd"])) {$password = '';} else { $password = $_GET["pwd"]; };
$space = " ";
$benutzerName2 = $Vorname . $space . $Nachname;



?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA Kaffee-Verwaltung</title>
	<link href="css/main.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" sizes="96x96" href="Esa.jpg">
	<!-- JavaScript einbinden -->
	<script language="javascript" type="text/javascript" src="inc/func.js"></script>
  </head>
  <body>
  <h1 class="forueberschriftbenutzerverwaltung">Kaffee - Anmelden</h1>
		<img src="Esa.jpg" width="230px">
		<!-- Registration Formular -->
		<p><a href="index.php" class="button">Zurück</a></p>
  <!--<body onload="load()">-->
  <!-- Login Formular beim Absenden auf Verarbeitung -->
	<fieldset id="formPasswort">

<form method="post" id="anfang" action="benutzerverwaltung.php?vt=login" onsubmit="buttonclick();">
	<label class="formLabel1" for="passwd">Benutzername</label>
  <input type="text" placeholder="Benutzername eingeben" class="formimputanmelden" 
  <?php 
  //Entweder von Link oder von Benutzerverwaltung und muss immer benutzernamen ausgaben
  if ($benutzerName == ""){
		echo" value=\"$benutzerName2\""; 
  }else{
		echo" value=\"$benutzerName\""; 
  }
  ?>  
	id="fuerlabel" name="form_benutzername" /><br>
  <label class="formLabel1" for="passwd">Passwort</label>
  <input type="password" placeholder="Passwort eingeben" class="formimputanmelden" <?php echo" value=\"$password\""; ?> id="fuerlabel" name="formPasswd" pattern="{4,20}" required="required" minlength="4"/><br>
  <input type="submit"  value="Login" class="submitbutton"/>
</form>

</fieldset>

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

if (!isset($_POST["form_benutzername"])) {
    $form_benutzername = '';
} else {
    $form_benutzername = $_POST["form_benutzername"];
};
if (!isset($_POST["formPasswd"])) {
    $form_passwort = '';
} else {
    $form_passwort = $_POST["formPasswd"];
};
 if (!isset($_GET["vt"])) {
    $paramVT = '';
} else {
    $paramVT = $_GET["vt"];
};

if ($paramVT == "error"){
	echo "<h2 id=\"error\">Falsches Passwort</h2><br>";
}

//Include Global.php weil alle funktionalitäten dort sind
include "inc/global.php";

//Debug Variable
if($debug == true){
	echo "$benutzerName <br>";
	echo "$benutzerPassword <br>";
}





?>
<!-- Code Ende---------------------------------------------------------------------------- -->
<!-- <fieldset class="footer"><legend class="laklein">Powerd by Philip Rippstein</legend></fieldset>	 -->
</body>
</html>