<?php
include "inc/global.php";
include "inc/head.inc";

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

//Login prüfung
if ($paramVT == "login"){
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$strSQL = "select name, passwort ,passwort2 from kaffee4 where name = '". $form_benutzername . "' and aktive=true";
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {			
			// Passwort Vergleichen, ein Passwort muss mindestends richtig sein.
				if ($row["passwort"] != $form_passwort and $row["passwort2"] != $form_passwort){
					echo "<h2 id=\"error\">Nicht OK ist ungleich</h2><br>";
					header($gv_HederlocationLogin);
				}
				/*
				if ($row["passwort"] == $form_passwort){
					//Delete Passwort 2
					$strSQL = "update kaffee4 set Passwort2='0' where name='" . $form_benutzername . "'";
					$result = $conn->query($strSQL);
					echo '<a href="index.php" class="button">Zurück</a><br>';
					echo"<h2 id=\"error\">Sie haben Ihr Standardpasswort eingegeben, welches wieder aktiviert wurde.</h2><br>";
				}
				*/
		}
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!";
		echo '<a href="index.php" class="button">Zurück</a>';
		header($gv_HederlocationLogin);
	}	
	
	// Verbindung wieder schliessen
	$conn->close();

}//param vt = login
$formUserId = get_UserID($form_benutzername, $servername, $username, $password, $dbname);
$formUserPw = get_UserPw($form_benutzername, $servername, $username, $password, $dbname);
$lv_UserGuthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);
$lv_UserEmail = get_UserEmail($formUserId, $servername, $username, $password, $dbname);
$lv_UserFarbe = get_UserFarbe($formUserId, $servername, $username, $password, $dbname);
$form_benutzername = ucfirst($form_benutzername);
?>
<!-- Script für Farbe -->
<script src="jscolor.js"></script>
<script>
    function setTextColor(picker) {
        document.getElementsByTagName('farbewaehlen')[0].style.color = '#' + picker.toString();
        var farbeunverarbeitet = document.getElementById('chosen-value').value = '#' + value;
        //var hashtag = "#";
        var farbe = '#' + farbeunverarbeitet;
        //alert (farbe);
    }
</script>
<!-- Script für Farbe ENDE-->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="http://getbootstrap.com/assets/js/jquery.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
label > input{ /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
}
</style>

<body>
<div class="container">
    <div class="row profile">
        <div class="col-md-3" style="margin-top: 11px;">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="kaffee.png" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $form_benutzername ?>
                    </div>
                    <div class="profile-usertitle-job">
                        <?php echo $lv_UserGuthaben ?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
				<!--
                    <button onClick="parent.location='bewertung.php'" type="button" class="btn btn-success">
                        <span class="glyphicon glyphicon-star"></span> Bewerten
                    </button>
				-->
                    <button onClick="parent.location='index.php'" type="button" class="btn btn-danger">
                        <span href="index.php" class="glyphicon glyphicon-log-out"></span> Abmelden
                    </button>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu" data-parent="#accordion" data-toggle="collapse">
                    <ul class="nav">
                        <li>
                            <a href="#1" data-parent="#accordion" data-toggle="collapse" onclick="myFunction1()">
                                <i class="glyphicon glyphicon-lock"></i>
                                Passwort ändern </a>
                        </li>
                        <li>
                            <a href="#2" data-parent="#accordion" data-toggle="collapse" onclick="myFunction2()">
                                <i class="glyphicon glyphicon-pencil"></i>
                                Farbe ändern </a>
                        </li>
						<li>
                            <a href="#3" data-parent="#accordion" data-toggle="collapse" onclick="myFunction3()">
                                <i id="star" class="glyphicon glyphicon-star"></i>
                                Bewerten </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
				<script>
					function overstar1()
					{
					//geklickt = dünklere farbe
					document.getElementById('star1').src='star2.png'
					document.getElementById('star2').src='star.png'
					document.getElementById('star3').src='star.png'
					document.getElementById('star4').src='star.png'
					document.getElementById('star5').src='star.png'
					}
					
					function overstar2()
					{
					document.getElementById('star1').src='star2.png'
					document.getElementById('star2').src='star2.png'
					
					
					document.getElementById('star3').src='star.png'
					document.getElementById('star4').src='star.png'
					document.getElementById('star5').src='star.png'
					}
					
					function overstar3()
					{
					document.getElementById('star1').src='star2.png'
					document.getElementById('star2').src='star2.png'
					document.getElementById('star3').src='star2.png'
					
					document.getElementById('star4').src='star.png'
					document.getElementById('star5').src='star.png'
					}
					
					function overstar4()
					{
					document.getElementById('star1').src='star2.png'
					document.getElementById('star2').src='star2.png'
					document.getElementById('star3').src='star2.png'
					document.getElementById('star4').src='star2.png'
					
					document.getElementById('star5').src='star.png'
					}
					
					function overstar5()
					{
					document.getElementById('star1').src='star2.png'
					document.getElementById('star2').src='star2.png'
					document.getElementById('star3').src='star2.png'
					document.getElementById('star4').src='star2.png'
					document.getElementById('star5').src='star2.png'
					}
					
					function myFunction1() {
						var x = document.getElementById("2");
						x.style.display = "hidden";
						var y = document.getElementById("3");
						y.style.display = "hidden";
						var z = document.getElementById("1");
						z.style.display = "visibility";
					}
					function myFunction2() {
						var x = document.getElementById("1");
						x.style.display = "hidden";
						var y = document.getElementById("3");
						y.style.display = "hidden";
						var z = document.getElementById("2");
						z.style.display = "visibility";
					}
					function myFunction3() {
						var x = document.getElementById("1");
						x.style.display = "hidden";
						var y = document.getElementById("2");
						y.style.display = "hidden";
						var z = document.getElementById("3");
						z.style.display = "visibility";
					}
										
					function showIt2() {
						//alert("Test");
						setTimeout("showIt2()", 5000);
						document.getElementById("error").style.visibility = "hidden";
						//document.getElementById('error').style.color = 'red';
					}
						
					function star(){
						//alert("test");
						var x = document.getElementsByClassName("glyphicon-star");
						x.style.color = "#eae500";
						
					}
					
					 // Aktuelles Tab merken
				    $("ul.nav-tabs2 > li > a").on("shown.bs.tab", function (e) {
				        var id = $(e.target).attr("href").substr(1);
				        window.location.hash = id;
				    });
					
					
				</script>
            </div>
        </div>
        <div style="visibility: hidden;" class="panel-group" id="accordion">
            <div  class="panel panel-default">
                <!-- Ausgabe Passwort -->
                <div id="1" class="panel-collapse collapse" >
                    <div class="panel-body" id="grauefarbe">
                        <fieldset id="1">
                            <form id="formPasswort" action="<?php $lvPage = $_SERVER['SCRIPT_NAME'];
                            echo "$lvPage?vt=passwort"; ?>" method="Post">
                                <fieldset>
                                    <legend class="labold">Passwort ändern</legend>
                                    <label class="formLabel1" form="formRegistration">Benutzername:</label><br>
                                    <input type="text" name="form_benutzername" id="fuerlabel2"
                                           placeholder="Vor- und Nachname"
                                           value="<?php echo $form_benutzername; ?>"><br>
                                    <label class="formLabel1" form="formRegistration"
                                           class="lafarbig ">Passwort:</label><br>
                                    <input type="password" name="form_passwort" id="fuerlabel2"
                                           placeholder="mind. 4 Zeichen" value="<?php echo $form_passwort; ?>"><br>
                                    <label class="formLabel1" form="formRegistration" class="lafarbig ">Neues
                                        Passwort:</label><br>
                                    <input type="password" name="form_passwortn1" id="fuerlabel2"
                                           placeholder="Neues Passwort eingeben"><br>
                                    <label class="formLabel1" form="formRegistration" class="lafarbig ">Neues Passwort
                                        wiederholen:</label><br>
                                    <input type="password" name="form_passwortn2" id="fuerlabel2"
                                           placeholder="Neues Passwort wiederholen"><br>
                                    <div id="div01"><input type="submit" value="Ändern" onclick="showIt2()" class="submitbutton"></div>
                                </fieldset>
                            </form>
                        </fieldset>
                    </div>
                </div>
                <!-- Ausgabe Passwort ENDE-->
            </div>
            <div  class="panel panel-default">
                <!-- Ausgabe Farbe -->
                <div id="2" class="panel-collapse collapse" >
                    <div class="panel-body" id="grauefarbe">
                        <form id="formPasswort" action="<?php $lvPage = $_SERVER['SCRIPT_NAME'];
							echo "$lvPage?vt=farbe"; ?>" method="Post">
                            <fieldset>
                                <legend class="labold">Farbe ändern</legend>
                                <div>
                                    <button class="jscolor {valueElement:'chosen-value', onFineChange:'setTextColor(this)'}"
                                            id="farbewaehlen">
											<?php echo $form_benutzername; ?>
                                    </button>
																		
										<div class="input-group">
											<div id="farbeschieben"><i class="glyphicon glyphicon-pencil"></i>
											<input id="chosen-value" name="farbe" type="visibility" value="<?php echo $lv_UserFarbe ?>"  class="forinput">
											<input type="hidden" name="form_benutzername" value="<?php echo $form_benutzername; ?>"></div>
										</div>
                                </div>
                                
                            </fieldset>
							<input class="div02 submitbutton" type="submit" value="Ändern" style="float:left; margin-top: 100px; margin-left: 13px; " onclick="showIt2()">
							
                        </form>
						
							<!--<input style="margin-top: 100px; margin-left: 40px; width: 131px;" type="submit" value="Default Farbe"
							onclick="window.location.href='localhost/kaffee/index.php'">-->
							<form id="formPasswort" action="<?php $lvPage = $_SERVER['SCRIPT_NAME'];
								echo "$lvPage?vt=defaultfarbe"; ?>" method="Post">
								<input class="div02 submitbutton" class="submitbutton" type="submit" value="Default Farbe" style="float:left; margin-top: 100px; margin-left: 13px; " value="#2671a5" name="farbe" onclick="showIt2()">
								<input type="hidden" name="form_benutzername" value="<?php echo $form_benutzername; ?>">
							</form>						
                    </div>
                </div>
                <!-- Ausgabe Farbe ENDE-->
            </div>
			
			<div class="panel panel-default">
				<div id="3" class="panel-collapse collapse" >
					<div class="panel-body" id="grauefarbe">
						<form name="star1" method="Post" action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=v"; ?>">
							<table>
							<fieldset>
							<legend class="labold">Ihre Bewertung</legend>
							<!-- value 1 -->
							<label>
								<input name="star1" type="radio" value="1" class="autosubmit-hover-star" title="v&ouml;llig unn&uuml;tz"/>
								<img id="star1" src="star.png" style="height: 50px;" onmouseover="overstar1()" >
							</label>
							
							<!-- value 2 -->
							<label>
								<input name="star1" type="radio" value="2" class="autosubmit-hover-star" title="wenig brauchbar"/>
								<img id="star2" src="star.png" style="height: 50px;" onMouseOver="overstar2()">
							</label>
							
							<!-- value 3 -->
							<label>
								<input name="star1" type="radio" value="3" class="autosubmit-hover-star" title="ok">
								<img id="star3" src="star.png" style="height: 50px;" onMouseOver="overstar3()">
							</label>
							
							<!-- value 4 -->
							<label>
								<input name="star1" type="radio" value="4" class="autosubmit-hover-star" title="n&uuml;tzlich"/>
								<img id="star4" src="star.png" style="height: 50px;" onMouseOver="overstar4()">
							</label>
							
							<!-- value 5 -->
							<label>
								<input name="star1" type="radio" value="5" class="autosubmit-hover-star" title="sehr n&uuml;tzlich"/>
								<img id="star5" src="star.png" style="height: 50px;" onMouseOver="overstar5()">
							</label>

							<div id="star1tip" style="font-size:0.5em">&nbsp;</div>
							<label class="formLabel1" form="formRegistration">Verbesserungsvorschläge:</label>
							<div><textarea type="text" rows="4" name="kommentar" cols="40" placeholder="Ihre Verbesserungsvorschläge..." pattern="[A-Za-z0-9]{1,20}"> </textarea></div>
							<input type="hidden" name="form_benutzername" value="<?php echo $form_benutzername; ?>">
							<input class="submitbutton" id="schieben" type="submit" value="Absenden" onclick="star()">
							</fieldset>
							</table>
						
					</form>
				 </div>
				</div>
			</div>
			
			
        </div>

        <?php
        include "inc/head.inc";
		$formUserId = get_UserID($form_benutzername, $servername, $username, $password, $dbname);
		$formUserPw = get_UserPw($form_benutzername, $servername, $username, $password, $dbname);
		$lv_UserGuthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);
		$lv_UserEmail = get_UserEmail($formUserId, $servername, $username, $password, $dbname);
		$lv_UserFarbe = get_UserFarbe($formUserId, $servername, $username, $password, $dbname);
		$form_benutzername = ucfirst($form_benutzername);

        // Formular Variablen in Locale Veriablen übernehmen...
        if (!isset($_POST["form_benutzername"])) {
            $form_benutzername = "";
        } else {
            $form_benutzername = $_POST["form_benutzername"];
        };
        if (!isset($_POST["formRegistration"])) {
            $form_passwort = '';
        } else {
            $form_passwort = $_POST["formRegistration"];
        };
        if (!isset($_POST["form_passwortn1"])) {
            $form_passwortn1 = '';
        } else {
            $form_passwortn1 = $_POST["form_passwortn1"];
        };
        if (!isset($_POST["form_passwortn2"])) {
            $form_passwortn2 = '';
        } else {
            $form_passwortn2 = $_POST["form_passwortn2"];
        };
        if (!isset($_GET["vt"])) {
            $paramVT = '';
        } else {
            $paramVT = $_GET["vt"];
        };

		if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
		if (! isset($_POST["star1"])) {$star = '';} else {$star = $_POST["star1"]; };
		if (! isset($_POST["kommentar"])) {$kommentar = '';} else {$kommentar = $_POST["kommentar"]; };
		if ($paramVT == "v"){
		if (!isset($_POST["form_benutzername"])) {
			$form_benutzername = '';
		} else {
			$form_benutzername = $_POST["form_benutzername"];
		};	
		$lv_UserGuthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);
		//$gv_Hederlocation = "Location: http://intranet.esa.ch/kaffee/index.php";
		//header($gv_Hederlocation);
		
		
		
		// Auf DB Verbinden
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			//echo "<div> connected ";
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			// SQL Formulareingabe in Datenbank speichern 
			$strSQL = "INSERT INTO `rating`
					(`bewertung`,`kommentar`)
			VALUES ('".$star . "','".$kommentar . "');";
			//echo "<div> $strSQL";
			$conn->query("SET NAMES 'utf8'");
			$result = $conn->query($strSQL);
			$conn->close();
			echo "<h2>Vielen Dank für Ihre Bewertung";
			
		}
//--------------------------------------------------------------------------------------------------------------------------------
        if ($paramVT == "passwort") {
            if ($form_passwortn1 == $form_passwortn2) {
                if (strlen($form_passwortn1) >= 4) {
                    // ermitteln ob USER und PWD passen...
                    // Auf DB Verbinden
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // SQL Abfrage Passwort abfragen und Vergleichen vorbereiten und ausführen
                    $strSQL = "select * from kaffee4 WHERE `ID`='" . $formUserId . "'";
                    //echo "$strSQL<hr>";
                    $conn->query("SET NAMES 'utf8'");
                    $result = $conn->query($strSQL);
                    $conn->close();
                    // SQL auswerten und ausgeben
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        if ($row["Passwort"] <> $form_passwortn1) {
							//$strSQL = "update kaffee4 set Passwort2='0' where name='" . $form_benutzername . "'";
					
                            $strSQL = "UPDATE `kaffee4` SET Passwort='" . $form_passwortn1 . "', Passwort2='0' WHERE `ID`='" . $row["ID"] . "'";
                            //echo "$strSQL<hr>";
                            $lv_res = DoSQL($strSQL, $servername, $username, $password, $dbname);

                            if ($lv_res) {
                                echo "<h2 id=\"error\">Das Passwort wurde geändert...</h2>";
                            } else {
                                echo "<h2 id=\"error\">Das Passwort wurdne nicht geändert</h2>";
                            }
                        } else {
                            echo "<h2 id=\"error\">Sie verwenden das Passwort bereits.</h2><br>";
							$strSQL = "UPDATE `kaffee4` SET Passwort2='0' WHERE `ID`='" . $row["ID"] . "'";
                            //echo "$strSQL<hr>";
                            DoSQL($strSQL, $servername, $username, $password, $dbname);
                        }
                    } else {
                        echo "<h2 id=\"error\">Username oder Passwort nicht korrekt</h2><br>";
                    }
                } else { //if ($form_passwortn1 < 4){
                    echo "<h2 id=\"error\">Neues Passwort ist zu kurz</h2><br>";
                } //if ($form_passwortn1 == $form_passwortn2){

            } else { //if ($form_passwortn1 == $form_passwortn2){
                echo "<h2 id=\"error\">Passwort Wiederholung ist falsch</h2><br>";
            } //if ($form_passwortn1 == $form_passwortn2)
        }
	
//---------------------------------------------------------------------------------------------------------------------------------------------
		elseif ($paramVT == "farbe") {
		if (!isset($_POST["farbe"])) {
            $Farbe = '';
        } else {
            $Farbe = $_POST["farbe"];
        };
		if (!isset($_POST["form_benutzername"])) {
            $form_benutzername = "";
        } else {
            $form_benutzername = $_POST["form_benutzername"];
        };
		if (!isset($_POST["lv_UserFarbe"])) {
            $lv_UserFarbe = "";
        } else {
            $lv_UserFarbe = $_POST["lv_UserFarbe"];
        };
	// Auf DB Verbinden
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$strSQL = "select 'farbe','guthaben' from kaffee4 where name = '".$form_benutzername."';";
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {			
			// Passwort Vergleichen
				mysql_query($strSQL);
				if ($lv_UserGuthaben >= 0.00){
					$strSQL = "update kaffee4 set farbe='".$Farbe."' where name='". $form_benutzername ."'";
					$result = $conn->query($strSQL);
					echo "<h2 id=\"error\">Die Farbe wurde gespeichert</h2><br>";
					
				}else{
					echo "<h2 id=\"error\">Bitte Laden Sie zuerst Ihr Guthaben auf</h2><br>";
					
				}
		}
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!";
		echo '<a href="index.php" class="button">Zurück</a>';
	}	
	
	// Verbindung wieder schliessen
	$conn->close();
}
//----------------------------------------------------------------------------------------------------------------------------
		elseif ($paramVT == "defaultfarbe") {
		if (!isset($_POST["farbe"])) {
            $Farbe = '';
        } else {
            $Farbe = $_POST["farbe"];
        };
		if (!isset($_POST["form_benutzername"])) {
            $form_benutzername = "";
        } else {
            $form_benutzername = $_POST["form_benutzername"];
        };
// kommt vom  Passwort zur Verarbeitung Abbuchen 1 Stk.
	// Auf DB Verbinden
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$strSQL = "select 'farbe','guthaben' from kaffee4 where name = '".$form_benutzername."';";
	$result = $conn->query($strSQL);
	// SQL auswerten und ausgeben
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {			
			// Passwort Vergleichen
				mysql_query($strSQL);
				if ($lv_UserGuthaben >= 0.00){
						$strSQL = "update kaffee4 set farbe='#2671a5' where name='". $form_benutzername ."'";
						$result = $conn->query($strSQL);
						echo "<h2 id=\"error\">Die Default Farbe wurde gespeichert</h2><br>";
						
				}else{
						echo "<h2 id=\"error\">Bitte Laden Sie zuerst Ihr Guthaben auf</h2><br>";
						
				}
		}
	} else {
		echo "Leider ist da etwas ganz falsch gelaufen auf der DB !!!";
		echo '<a href="index.php" class="button">Zurück</a>';
	}

	// Verbindung wieder schliessen
	$conn->close();
	}
	
	
	//----------------------------------------------------------------------------------------------------------------------
		//if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
		
	else{
		
	}		
        ?>
    </div><!-- row profile -->
</div>
</body>