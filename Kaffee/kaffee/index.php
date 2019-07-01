<?php
session_start();
session_destroy();

include "inc/global.php";
include "inc/head.inc";

?>
<script>
var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return ((isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()));
    }
};

function detectDevice() {
    var result = 'No';
    if (isMobile.any()) {
        result = 'Yes';
    }
    //alert(result);
	return result
};

var smartphone = detectDevice();
//alert(smartphone);

if(smartphone == 'Yes'){
	//alert("If")
	window.location.replace("http://intranet.esa.ch/kaffeeapp", '_self');
	location.href="http://intranet.esa.ch/kaffeeapp";
}else{
	//alert("Else")
	//window.location.replace("http://intranet.esa.ch/kaffeeapp", '_self');
	//location.href="http://intranet.esa.ch/kaffeeapp";
}
</script>

	<div class="forueberschriftIndex">
		<h1>Kaffee - Übersicht</h1>
	</div>
	<br>
	<div class="ESAbild">
		<img src="Esa.jpg" width="230px">
	</div>

  
  
  <!-- Tabelle für User -->
	<table >
		<thead>
		<!-- registrier Button-->
		<p class="ButtonHead">
		<a href="<?php $lvPage = 'registrieren.php'; echo "$lvPage?vt=r"; ?>" class="button">Registrieren</a>
		
		<!-- Passwort ändern Button-->	
		<a href="anmelden.php" class="button">Benutzer Verwaltung</a>
		
		<!-- Admin Anmeldung Button-->
		<a href="LoginAdm.php" class="button" >Admin Anmeldung</a>		
		
		<!-- Menu Button-->
		<a href="menu.php" class="buttonmenu" >Menu Plan</a>		
		
		<!-- Bewertung -->
		<!--<a href="bewertung.php" class="buttonmenu2" >Bewertung</a>	-->
		
		<!-- E-mail Text-->
		<!-- <p style="color: #da0000; margin-bottom: 0px;"> Bei * Bitte E-mail Adresse noch eingeben Danke</p>-->
			
		</thead>
		
		<tbody>
				
<?php
	// Auf DB Verbinden

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	// SQL Abfrage vorbereiten und ausführen 
	$strSQL = "select id, name, guthaben, email,farbe from kaffee4 where Admin=0 and aktive=true ORDER BY `name` ASC;";
	$conn->query("SET NAMES 'utf8'");
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result->num_rows > 0) {
		// output data für jede Zeile
		while($row = $result->fetch_assoc()) {
			$lvMail = "";
			if ($row["email"] == ""){
				$lvMail = "* ";
			}
			if ($row["guthaben"] >= 0.00){
				$strOutput = "    <div id=\"buttonWindows\">
								<form action=\"verarbeitung.php?vt=b\" method=\"post\" autocomplete=\"off\">\n\r"
						."      	<input type=\"hidden\" name=\"formUserId\" value=\"". $row["id"]." \">\n\r"
						."      	<button class=\"buttonAktion\" type=\"submit\" name=\"formSubmit\" style=\"background: #0083db;
																												height:95%;
																												width:90%;
																												background-image: linear-gradient(to bottom, #ffffff, ". $row["farbe"]." , ". $row["farbe"].", #5c5c5c);
																												-webkit-border-radius: 17;
																												-moz-border-radius: 17;
																												border-radius: 17px;
																												text-shadow: 0px 0px 0px #666666;
																												-webkit-box-shadow: 7px 7px 4px #666666;
																												-moz-box-shadow: 7px 7px 4px #666666;
																												box-shadow: 7px 7px 4px #666666;
																												font-family: Arial;
																												color: #FFFFFF;
																												font-size: 16px;
																												padding: 10px 20px 10px 20px;
																												text-decoration: none;
																												/* für abstand Funktionsbuttons*/
																												margin-top:30px;\"
						>" .$lvMail. $row["name"] ."<br />". $row["guthaben"]."</button>\n\r" 
						."    	</form></div>\n\r";
			}
			else{
			$strOutput = "    <div id=\"buttonWindows\">
								<form action=\"verarbeitung.php?vt=b\" method=\"post\" autocomplete=\"off\">\n\r"
						."      	<input type=\"hidden\" name=\"formUserId\" value=\"". $row["id"]." \">\n\r"
						."      	<button class=\"buttonAktion\" type=\"submit\" name=\"formSubmit\" style=\"background: #0083db;
																												height:95%;
																												width:90%;
																												background-image: linear-gradient(to bottom, #ffffff, #da4747 , #da4747, #5c5c5c);
																												-webkit-border-radius: 17;
																												-moz-border-radius: 17;
																												border-radius: 17px;
																												text-shadow: 0px 0px 0px #666666;
																												-webkit-box-shadow: 7px 7px 4px #666666;
																												-moz-box-shadow: 7px 7px 4px #666666;
																												box-shadow: 7px 7px 4px #666666;
																												font-family: Arial;
																												color: #FFFFFF;
																												font-size: 16px;
																												padding: 10px 20px 10px 20px;
																												text-decoration: none;
																												/* für abstand Funktionsbuttons*/
																												margin-top:30px;\"
						>" .$lvMail. $row["name"] ."<br />". $row["guthaben"]."</button>\n\r" 
						."    	</form></div>\n\r";
			
						
				}
			echo $strOutput;
			

	}
	} else {
		echo "Leider wurde nichts gefunden...DB Fehler";
	}
	// Verbindung wieder schliessen
	$conn->close();
	
	
?>		
		</tbody>
	</table>

