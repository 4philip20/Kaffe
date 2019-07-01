<?php

//Formular deklaration
$ausgabe ="
<html>
<head><title>Test</title></head>
<body>
<h1>Login Example<h1>
<form action=\"login.php\" method=\"post\">
Username <input type=\"text\" name=\"txtUsername\" /><br/>
Password <input type=\"text\" name=\"txtPassword\" /><br/>
<input type=\"submit\" name=\"btnSubmit\" value=\"login\"/>
</form>
</body>
</html>
";

	echo $ausgabe;

	if (! isset($_POST["Username"])) {$Username = '';} else {$Username = $_POST["Username"]; };
	if (! isset($_POST["Password"])) {$Password = '';} else {$Password = $_POST["Password"]; };
	
	//Serverdaten deklaration
    $servername = "localhost";
	$dbname = "esa_kaffee";
	$username = "root";
	$password = "";

	// Auf DB Verbinden
	// Create connection

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{       
	// SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen 
	//$strSQL = "Select name, Passwort FROM kaffee3 where name ='". $username . "' And password = '". $password . "'";
	$strSQL = "select guthaben from kaffee2 where Name=$Username";
	
	//echo "query Gelungen!<hr>";
    //echo "$strSQL<hr>";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	
	if($result){
		echo "Query ausgeführt<br>";
	}

			// Passwort Vergleichen
			echo "geschafft!!!";
			if ($row["Passwort"] == "abcde" ){				
				echo "geschafft!!!";
			}
		
	}
	
	//$conn->close();		// Verbindung wieder schliessen
?>