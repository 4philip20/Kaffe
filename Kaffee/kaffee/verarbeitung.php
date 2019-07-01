<!-- erkennt den value wo id="textAnzKaffeRange"  und schreibt dort anzKaffee hin / Wenn Balken verÃ¤ndert wird wird die Funktion aufgerufen-->

<script>
    src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js";


    // Variable "clicks" deklariert die mit dem wert 1 anfÃ¤ngt.

    var clicks = 1;
    var totalAnzKaffee = 0;
    function updateTextInput(anzKaffee) {
        clicks += 1;
        anzKaffee = clicks;
        document.getElementById('textAnzKaffeRange').innerHTML = anzKaffee;
        document.getElementById('formAnzKaffee').value = anzKaffee;
    }
    function deupdateTextInput(anzKaffee) {
        clicks -= 1;
        if (clicks < 1) {
            clicks = 1
        }
        anzKaffee = clicks;
        document.getElementById('textAnzKaffeRange').innerHTML = anzKaffee;
        document.getElementById('formAnzKaffee').value = anzKaffee;
    }
    function zaehlen() {
        totalAnzKaffee = totalAnzKaffee + 1;
        document.getElementById('id01').style.display = 'block';
    }
    function chkFormular() {
        if (document.Formular.formEmail) {
            if (document.Formular.formEmail.value == "") {
                document.getElementById("formemailerror").style.visibility = "visible";
                document.Formular.formEmail.focus();
                return false;
            }
        }
    }
	function time() {
		if (i < 60) {
			i++;
			document.getElementById('spanId').innerHTML = i;
		} else {
			window.clearInterval(inverval);
		}
	}
	var i=0;
	var interval = window.setInterval('time()', 1000);


</script>


<?php
include "inc/global.php";
include "inc/head.inc";

if (!isset($_POST["formAnzKaffee"])) {
    $formAnzKaffee = '1';
} else {
    $formAnzKaffee = $_POST["formAnzKaffee"];
};

if (!isset($_POST["farbe"])) {
    $Farbe = '';
} else {
    $Farbe = $_POST["farbe"];
};

if (!isset($_POST["formUserId"])) {
    $formUserId = '';
} else {
    $formUserId = trim($_POST["formUserId"]);
};

if (!isset($_POST["formPasswd"])) {
    $formPasswd = '';
} else {
    $formPasswd = $_POST["formPasswd"];
};

if (!isset($_POST["formEmail"])) {
    $formEmail = '';
} else {
    $formEmail = $_POST["formEmail"];
};

if (!isset($_GET["vt"])) {
    $paramVT = '';
} else {
    $paramVT = $_GET["vt"];
};

if (!isset($_POST["form_benutzername"])) {
    $form_benutzername = "";
} else {
    $form_benutzername = $_POST["form_benutzername"];
};

if (!isset($_POST["totalAnzKaffee"])) {
    $totalAnzKaffee = "";
} else {
    $totalAnzKaffee = $_POST["totalAnzKaffee"];
};
$defaultAnzKaffee = 1;
$debug = false;

function KwErmitteln()
					{
						$kw = 0;
						$kw = date('W', time());
						return $kw;
					}

if ($paramVT == "b") {
	$lv_UserName = get_UserName($formUserId, $servername, $username, $password, $dbname);
	$lv_UserGuthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);
	$lv_UserEmail = get_UserEmail($formUserId, $servername, $username, $password, $dbname);
	$lv_UserFarbe = get_UserFarbe($formUserId, $servername, $username, $password, $dbname);
	$lv_Passwort2 = get_UserPw2($formUserId, $servername, $username, $password, $dbname);
	$lv_Passwort = get_UserPw($formUserId, $servername, $username, $password, $dbname);

	// Javascript fÃ¼r Passwort abgleichen und verstecken

	echo "
   <script type=\"text/javascript\">
		function dodeleteinputPW2(){
			var PasswortPhp = \"" . $lv_Passwort . "\";
			var Passwort = document.getElementById('formPasswd').value;

			// alert(Passwort);
			// alert(PasswortPhp);
				// if Eingabe == Passwort

				if (Passwort == PasswortPhp){

					// alert(\"Sind Gleich\");
					// remove Feld 'neues PW'
					// input feld

					document.getElementById('formPassword').style.visibility = 'hidden';

					// Andere meldung

					document.getElementById('passwort2').style.visibility = 'hidden';

					// Doch nicht vergessen meldung...

					document.getElementById('meldungpw').style.visibility = 'visible';
				}
					
		}
   </script>
 ";
?>
<div style="
    height: 110px;
">
	<div class="forueberschriftverarbeitung">
		<h1>Kaffee - Abbuchung</h1>
	</div>
		<br />
	<div class="ESAbild">
		<img src="Esa.jpg" width="230px">
		<br />
	</div>
</div>
<!-- ZurÃ¼ck Button -->



<p id="floatfarbe"><a href="index.php" class="button">Zurück</a></p>





<form action="<?php
	$lvPage = $_SERVER['SCRIPT_NAME'];
	echo "$lvPage?vt=email"; ?>" method="Post">
    <input type="hidden" name="form_benutzername" value="<?php
	echo $lv_UserName; ?>">
    <input class="emailerhalten" type="submit" value="Passwort vergessen">
</form>



<form action="<?php
	$lvPage = "anmelden.php";
	echo "$lvPage"; ?>" method="Post">
    <input type="hidden" name="form_benutzername" value="<?php
	echo $lv_UserName; ?>">
    <input class="emailerhalten2" type="submit" value="Benutzer Verwaltung">
</form>
<br />
<br />
<br />


<script src="jscolor.js"></script>
<!-- button+ fÃ¼r zÃ¤hler -->
<div class="center">
    <button class="anzKaffee" type="button" onClick="updateTextInput()">+ 1 Kaffee</button>
    <!-- button- fÃ¼r zÃ¤hler -->
    <button class="anzKaffee" type="button" onClick="deupdateTextInput()">- 1 Kaffee</button>
</div>
<!-- zÃ¤hler output-->
<div class="center"><p>Anzahl Kaffee: <span id="textAnzKaffeRange"><?php
	echo $defaultAnzKaffee; ?></span></p>
    <!--Output Text name,guthaben-->

    <?php
	if ($lv_UserGuthaben < 0) {
		echo "<h1> $lv_UserName, Ihr Guthaben: <a class=\"rot2\">$lv_UserGuthaben</a> Fr.</h1></div>";
	}
	else {
		echo "<h1> $lv_UserName, Ihr Guthaben: $lv_UserGuthaben Fr.</h1></div>";
	}

	if ($lv_UserGuthaben < 0) {
		echo "<p class=\"rot\">Bitte Kaffee Konto aufladen!</p>";
	}

	if ($lv_UserEmail == "") {
		echo "<p class=\"rot\">Bitte E-mail Adresse noch eingeben</p>";
	}

	if ($lv_Passwort2 != "0") {
		echo "<p class=\"rot\" id=\"passwort2\">Sie haben Ihr Passwort vergessen, Bitte Altes oder neues E-mail Passwort eingeben</p>";
		echo "<p style=\"visibility: hidden;\"class=\"rot\" id=\"meldungpw\">Sie kennen doch Ihr altes PW noch ?</p>";
	}

?>
    <!-- Passwortabfrage -->
    <form action="<?php
	$lvPage = $_SERVER['SCRIPT_NAME'];
	echo "$lvPage?vt=p"; ?>" name="Formular" onSubmit="return chkFormular()" method="Post">
        <!--<div id="farbecenter"><input type="color" size="40" name="farbe" value="<?php
	echo "$lv_UserFarbe"; ?>"></div>-->


        <input type="hidden" name="formUserId" value="<?php
	echo $formUserId; ?>">
        <input type="hidden" name="formAnzKaffee" id="formAnzKaffee" value="<?php
	echo $defaultAnzKaffee; ?>">
        <input type="hidden" name="totalAnzKaffee" id="totalAnzKaffee" value="<?php
	echo $totalAnzKaffee; ?>">
        <label for="passwd"></label><br />
        <input type="password" name="formPasswd" id="formPasswd" class="formimput" autofocus="autofocus" required="required" minlength="4"
               placeholder="Passwort eingeben" >
        <?php
	if ($lv_UserEmail == "") {
		echo '<input type="email" name="formEmail" id="formEmail" class="formimput" autofocus="autofocus" length="5" placeholder="Bitte E-mail eingeben" >';
		echo "<br /><label class=\"formerrorlabel\" name=\"formemailerror\" id=\"formemailerror\">  Bitte E-MAIL eingeben, sonst gibt es keinen Kaffe!</label>";
	}

	if ($lv_Passwort2 != "0") {
		echo '<input onclick="dodeleteinputPW2()" type="password" name="formPassword" id="formPassword" class="formimput" autofocus="autofocus" length="4" placeholder="Bitte neues Passwort eingeben" >';
		echo "<br /><label class=\"formerrorlabel\" name=\"formemailerror\" id=\"formemailerror\">  Bitte neues Passwort eingeben, sonst gibt es keinen Kaffe!</label>";
	}

	if ($debug) {
		echo $lv_Passwort2;
	}

?>

        <div class="center"><input id="verarbeitungButton" class="submitbutton" type="submit" value="Abbuchen"
                                   onClick="zaehlen();"><br /></div>
    </form>
    <?php
}
elseif ($paramVT == "p") {

	// Passwort1

	if (!isset($_POST["formPasswd"])) {
		$formPassword = "0";
	}
	else {
		$formPassword = $_POST["formPasswd"];
	};

	// Passwort2

	if (!isset($_POST["formPassword"])) {
		$formPassword2 = "0";
	}
	else {
		$formPassword2 = $_POST["formPassword"];
	};
	echo "<body>
		";

	// Ãœberschrift
	// kommt vom  Passwort zur Verarbeitung Abbuchen 1 Stk.
	// Auf DB Verbinden

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$strSQL = "select Passwort, Passwort2, name, guthaben, email from kaffee4 where ID = '" . $formUserId . "' ORDER BY `name` ASC;";
	$result = $conn->query($strSQL);

	// SQL auswerten und ausgeben

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$altesGuthaben = $row["guthaben"];
			$Benutzername = $row["name"];
			$email = $row["email"];
			// Passwort Vergleichen
			// echo "Row guthaben: <br />";
			// var_dump($row["guthaben"]);
			mysql_query($strSQL);
			// Falls user E-mail Passwort eingibt
			if ($row["Passwort2"] == $formPasswd) {
				// Daten beschaffen
				$EntgueltigKaffePreis = $formAnzKaffee * $KaffePreis;
				$altesGuthaben = $row["guthaben"];
				$username = $row["name"];
				$email = $row["email"];
				$neuesGuthaben = $altesGuthaben - $EntgueltigKaffePreis;
				//ausgabe
				$altesguthaben2 = number_format($altesGuthaben, 2);
				$kaffeepreis = number_format($EntgueltigKaffePreis, 2);
				$Guthaben = number_format($neuesGuthaben, 2);
				//											, Passwort ='$formPassword'
				$strSQL = "update kaffee4 set Passwort2 ='0', Passwort ='$formPassword2',guthaben=" . $neuesGuthaben . " where name='" . $row["name"] . "';";
				$result = $conn->query($strSQL);
				mysql_query($strSQL);
				if($debug){
					var_dump($strSQL);
				}


				//--------------------------------------------------------------------------------------------------------------------------------------------------
				//IF Userguthaben > 10 --> Sende Mail
			if ($altesGuthaben <= "-9.50"){
				// $mailtext = "Guten Tag $form_benutzername Ihr Neues Passwort :'$Passwort' Bitte ändern Sie dies so schnell wie mÃ¶glich unter der Benutzer Verwaltung.";
				$Name = explode (" ", $Benutzername);
				$Vorname = $Name[0];
				$Nachname = $Name[1];
				$link = "intranet.esa.ch/kaffee/anmelden.php?Vorname=$Vorname&Nachname=$Nachname";

				$absender = "Kaffee@esa.ch";
				$betreff = "Kaffee Guthaben aufladen";
				$antwortan = "Kaffee@esa.ch";
				$header = "MIME-Version: 1.0\r\n";
				$header.= "Content-type: text/html; charset=utf-8\r\n";
				$header.= "From: $absender\r\n";
				$header.= "Reply-To: $antwortan\r\n";
				// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------
				$mailtext2 ="
				<html xmlns=\"http://www.w3.org/1999/xhtml\" style=\"width: 100%;\"><head><!-- Marketo Variable Definitions --><!-- Other Meta Tags -->
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> 
				<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1\"> 
				<meta name=\"robots\" content=\"noindex,nofollow\"> 
				<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> 
				<link href=\"https://fonts.googleapis.com/css?family=OpenSans:300,400,700\" rel=\"stylesheet\" type=\"text/css\"> 
				</head> 
				<body style=\"margin-bottom: 0; -webkit-text-size-adjust: 100%; padding-bottom: 0; min-width: 100%; margin-top: 0; margin-right: 0; -ms-text-size-adjust: 100%; margin-left: 0; padding-top: 0; padding-right: 0; padding-left: 0; width: 100%;\"><style type=\"text/css\">div#emailPreHeader{ display: none !important; }</style><div id=\"emailPreHeader\" style=\"mso-hide:all; visibility:hidden; opacity:0; color:transparent; mso-line-height-rule:exactly; line-height:0; font-size:0px; overflow:hidden; border-width:0; display:none !important;\">Kennst du den aktuellen Saldo von deinem Kaffee-Konto in der ESA? Hier kommt er!</div> 
				<div style=\"display:none; white-space:nowrap; font:15px courier; line-height:0;\">
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
				</div> 
				<!-- Outer table START --> 
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\"> 
				<tbody> 
				<tr> 
				<td class=\"outer\" valign=\"top\" style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;min-width: 600px;border-collapse: collapse;background-color:#f3f3f3;\"> 
				<table width=\"640\" align=\"center\" id=\"boxing\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" class=\"m_boxing\"> 
				<tbody> 
				<tr> 
				<td class=\"mktoContainer boxedbackground\" id=\"template-wrapper\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\">
				<table id=\"header\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_header\"> 
				<tbody> 
				<tr> 
				<td class=\"bordered\" style=\"-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #f0eff4;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"220\"> 
				<tbody> 
				<tr> 
				<td class=\"center-tablet\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; text-align: left; border-collapse: collapse;\"> 
				<div style=\"display:inline-block\" class=\"mktoImg logo\" id=\"logo\" mktolockimgsize=\"true\"> 
				<a><img class=\"logo\" src=\"http://pages.esa.ch/rs/523-SZO-068/images/logo_esa_4f_transparent_de.png\" alt=\"Logo\" style=\"-ms-interpolation-mode: bicubic; outline: none; border-right-width: 0; border-bottom-width: 0; border-left-width: 0; text-decoration: none; border-top-width: 0; display: block; max-width: 100%; line-height: 100%; height: 48px; 
				width: auto;\" height=\"48\" width=\"auto\"></a> 
				</div> </td> 
				</tr> 
				<tr class=\"stack-tablet\" style=\"max-height:0px;overflow:hidden;padding-left: 0; overflow: hidden; margin-left: 0; padding-top: 0; padding-right: 0; padding-bottom: 0; float: left; margin-top: 0; margin-right: 0; margin-bottom: 0; mso-hide: all; display: none;\"> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"titlebfb8fb21-b482-4573-bf69-d8071aff322c\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_title\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font title\" style=\"-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;-ms-text-size-adjust: 100%;margin-bottom: 10px;font-family:'OpenSans', Arial, sans-serif;font-weight: bold;margin-left: 0;font-size: 24px;text-align: center;padding-top: 10px;padding-right: 0;padding-bottom: 
				10px;padding-left: 0;margin-top: 10px;margin-right: 0;color: #000000;border-collapse: collapse;border-top-color:#f3f3f3;border-top-width:1px;\"> 
				<div class=\"mktoText\" id=\"title2bfb8fb21-b482-4573-bf69-d8071aff322c\">
				<p>Grüezi $Benutzername, schmeckte dein letzter Nespresso-Kaffee leicht bitter?<br></p> 
				</div> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:5px;font-size:5px;\" height=\"5px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100\"> 
				<tbody> 
				<tr> 
				<td class=\"separator\" style=\"-webkit-hyphens: none;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-moz-hyphens: none;hyphens: none;border-top-color:#f3f3f3;border-top-style: solid;border-top-width:1px;line-height: 10px;font-size: 20px;border-collapse: 
				collapse;border-left-color:#f3f3f3;border-bottom-color:#f3f3f3;border-right-color:#f3f3f3;border-left-width:1px;border-bottom-width:1px;border-right-width:1px;\" height=\"10\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"free-image93b3f8d2-b3f5-4f8e-83c1-0f591d6ee593\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_free-image\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<center> 
				<div style=\"display:inline-block\" class=\"mktoImg\" id=\"photo93b3f8d2-b3f5-4f8e-83c1-0f591d6ee593\" mktolockimgsize=\"true\"> 
				<a href=\"http://mkto-lon040166.com/NZ00ZSxc000gDhO0M400z2A\" target=\"_blank\"><img src=\"http://pages.esa.ch/rs/523-SZO-068/images/kaffee-app_01.png\" style=\"-ms-interpolation-mode: bicubic; outline: none; border-right-width: 0; border-bottom-width: 0; border-left-width: 0; text-decoration: none; border-top-width: 0; width: auto; height: auto; max-width: 100%; display: block; line-height: 100%;\" width=\"600\"></a> 
				</div> 
				</center> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"blankSpace\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_blankSpace\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#f3f3f3;\" bgcolor=\"#f3f3f3\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"title\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_title\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font title\" style=\"-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;-ms-text-size-adjust: 100%;margin-bottom: 10px;font-family:'OpenSans', Arial, sans-serif;font-weight: bold;margin-left: 0;font-size: 24px;text-align: center;padding-top: 10px;padding-right: 0;padding-bottom: 
				10px;padding-left: 0;margin-top: 10px;margin-right: 0;color: #000000;border-collapse: collapse;border-top-color:#f3f3f3;border-top-width:1px;\"> 
				<div class=\"mktoText\" id=\"title2\">
				<p><span style=\"font-size: 20px; color: #ff0000;\">Aktuelles Guthaben von $Benutzername: CHF $neuesGuthaben<br></span></p> 
				</div> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:5px;font-size:5px;\" height=\"5px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100\"> 
				<tbody> 
				<tr> 
				<td class=\"separator\" style=\"-webkit-hyphens: none;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-moz-hyphens: none;hyphens: none;border-top-color:#f3f3f3;border-top-style: solid;border-top-width:1px;line-height: 10px;font-size: 20px;border-collapse: 
				collapse;border-left-color:#f3f3f3;border-bottom-color:#f3f3f3;border-right-color:#f3f3f3;border-left-width:1px;border-bottom-width:1px;border-right-width:1px;\" height=\"10\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"free-text\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_free-text\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font text\" style=\"hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;-ms-text-size-adjust: 100%;font-family:'OpenSans', Arial, sans-serif;color: #000000;font-size: 14px;line-height: 20px;text-align: center;border-collapse: collapse;\"> 
				<div class=\"mktoText\" id=\"text\">
				<p><strong><span style=\"font-size: 16px;\">Dein Konto weist einen negativen Saldo auf – das kann passieren $Benutzername!</span></strong></p>
				<p><span style=\"font-size: 16px;\">Begleiche das kleine Defizit einfach noch heute bei Marcel Schiffmann (ESA-Mitarbeitende) bzw. Heinz Rolli (externe Berater). Dann kannst du deinen nächsten Ristretto, Espresso oder Lungo bestimmt wieder in gewohnter Manier geniessen.</span></p>
				<p><span style=\"font-size: 16px;\">Vielen Dank im Voraus.</span></p>
				<p><span style=\"font-size: 16px;\">Auf Wiedersehen</span></p> 
				</div> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:40px;font-size:40px;\" height=\"40px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"callToAction\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_callToAction\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td class=\"cta\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\" align=\"center\" bgcolor=\"#1fa12e\"> <a href=\"http://mkto-lon040166.com/NZ00ZSxc000gDhO0M400z2A\" target=\"_blank\" class=\"button\" style=\"-webkit-text-size-adjust: 
				100%;-ms-text-size-adjust: 100%;border-left-color:#1fa12e;font-weight: bold;font-size: 14px;font-family: 'OpenSans', Arial, sans-serif;color: #FFF;padding-top: 12px;padding-right: 18px;padding-bottom: 12px;padding-left: 18px;border-top-width:1px;display: 
				inline-block;border-bottom-width:1px;border-left-width:1px;border-top-style: 
				solid;border-right-style: solid;border-bottom-style: solid;border-left-style: solid;border-top-color:#1fa12e;border-right-color:#1fa12e;border-bottom-color:#1fa12e;border-right-width:1px;text-decoration: none;background-color:#1fa12e;\">ZUR DEINER KAFFEE-ÜBERSICHT</a> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"blankSpace2\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_blankSpace\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#f3f3f3;\" bgcolor=\"#f3f3f3\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table></td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				<!-- Outer Table END -->   
				<img src=\"http://mkto-lon040166.com/trk?t=1&amp;mid=NTIzLVNaTy0wNjg6MzQwMTowOjA6MDozMDg1OjA6MTI5MDYxLTE4OTpwaGlsaXAucmlwcHN0ZWluQGVzYS5jaA%3D%3D\" width=\"1\" height=\"1\" style=\"display:none !important;\" alt=\"\">
				</body>
				</html>
				";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------

					$header.= "X-Mailer: PHP " . phpversion();
					mail($email, $betreff, $mailtext2, $header);
				}
				
				//****Last Kaffee ausgabe*****
				//KW ermitteln
				$KW = KwErmitteln();
				$wochentage = array("so", "mo", "di", "mi", "do", "fr", "sa");
				$zeit = time();
				$WT = $wochentage[date("w", $zeit)];
				//Last Kaffe Wert holen
				$strSQL = "SELECT a.date FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
					$conn->query("SET NAMES 'utf8'");
					$result = $conn->query($strSQL);
					if ($result->num_rows > 0) {
						//while über werte loopt
						while($row = $result->fetch_assoc()) {
							
							$gv_lastcoffee = $row["date"];
							//Time now daten holen
							$lv_timenow = date("Y-m-d H:i:s");	
							//Formatieren
							$date1 = date_create_from_format('Y-m-d H:i:s', $gv_lastcoffee);
							$date2 = date_create_from_format('Y-m-d H:i:s', $lv_timenow);
							//Differnez = Interval
							$interval = $date2->diff($date1);
							//Formatieren
							$lv_differenz = $interval->format('%D %H:%I');
							echo"
							<h5 style=\"text-align: center;\">letztes Kaffee vor:</h6>
							<h1 style=\"text-align: center;\">$lv_differenz <span id=\"spanId\">0</span></h1>";
						}
					}else{
					echo"
							<h5 style=\"text-align: center;\">letztes Kaffee vor:</h6>
							<h1 style=\"text-align: center;\">00 00:00 <span id=\"spanId\">0</span></h1>";
					
					}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
					if ($formEmail != "") {
						$strSQL = "UPDATE `kaffee4` SET `email`='" . $formEmail . "' WHERE ID='" . $formUserId . "' ";
						$result = $conn->query($strSQL);
					}

					// in jedem Fall, wenn das Passwort OK ist muss die Quittung angezeigt werden.

					if ($altesGuthaben < 0) {
						echo "
				<div style=\"margin-top: 100px; Width: 40%; margin-left: auto; margin-right: auto;\" align=\"center\">
				<h3 class=\"rot\">Bitte Kaffee Konto aufladen!</h3>";
					}
					else {
						echo "
				<div style=\"margin-top: 100px; Width: 40%; margin-left: auto; margin-right: auto;\" align=\"center\">";
					}

					echo "
								<table align=\"center\" style=\"font-size: xx-large;\">
									<tr>
										<td style=\"width: 242px;\" class=\"vertest1\">Altes Guthaben</td>
										<td class=\"vertest2\" style=\"text-align: right;\">$altesguthaben2 .-</td>
									</tr>
									<tr>
										<td class=\"vertest1\">Kaffee Preis</td>
										<td class=\"vertest2\" style=\"text-align: right;\"><p style=\"border-bottom: 1px double;\">-&nbsp;&nbsp;$kaffeepreis .-</p></td>
									</tr>
									<tr>
										<td class=\"vertest1\">Neues Guthaben</td> ";
					if ($altesGuthaben < 0) {
						echo "<td class=\"vertest2\" style=\"text-align: right; \"><p style=\"border-bottom: 3px double; color:red;\">$Guthaben .-</p></td>";
					}
					else {
						echo "<td class=\"vertest2\" style=\"text-align: right;\"><p style=\"border-bottom: 3px double;\">$Guthaben .-</p></td>";
					}

					echo "
										
									</tr>
								</table>
					</div> <br>";

					//**********************************************************************************************************************************************************************
				function KwErmitteln()
					{
						$kw = 0;
						$kw = date('W', time());
						return $kw;
					}
					$KW = KwErmitteln();

					$wochentage = array("so", "mo", "di", "mi", "do", "fr", "sa");
					$zeit = time();
					$WT = $wochentage[date("w", $zeit)];

					$username = "esa_kaffee";
					$password = "esa_kaffee";
				// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}
					$strSQL = "SELECT a.mo,a.di,a.mi,a.do,a.fr FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
					$conn->query("SET NAMES 'utf8'");
					$strSQL2 = "UPDATE anzahl set `".$WT."` = `".$WT."` + ".$formAnzKaffee." where kid =".$formUserId." and `kw` = ".$KW.";";
					$result2 = $conn->query($strSQL2);
					$result = $conn->query($strSQL);
					//if result true
					if ($result){
						if ($debug){
							var_dump($strSQL);
						}
					}
					//if result false
					else{
						if ($debug){
							var_dump($strSQL);
						}
					}//If einträge mehr als 0
					if ($result->num_rows > 0) {
						//while über werte loopt
						while($row = $result->fetch_assoc()) {

									$lv_mo = $row["mo"];
									$lv_di = $row["di"];
									$lv_mi = $row["mi"];
									$lv_do = $row["do"];
									$lv_fr = $row["fr"];
									//Balken
									$lv_mob = $row["mo"] * 20;
									$lv_dib = $row["di"] * 20;
									$lv_mib = $row["mi"] * 20;
									$lv_dob = $row["do"] * 20;
									$lv_frb = $row["fr"] * 20;
									//Montag
									if ($lv_mob >= 100){
										$lv_mob = "100";
									}
									//Dienstag
									if ($lv_dib >= 100){
										$lv_dib = "100";
									}
									//Mittwoch
									if ($lv_mib >= 100){
										$lv_mib = "100";
									}
									//Donnerstag
									if ($lv_dob >= 100){
										$lv_dob = "100";
									}
									//Freitag
									if ($lv_frb >= 100){
										$lv_frb = "100";
									}
						}
					}
					//if einträge 0
					else {
							$strSQL2 = "INSERT INTO `anzahl` SET `kid`= ".$formUserId.",`kw`= ".$KW." ;";
							$result2 = $conn->query($strSQL2);
							$strSQL = "UPDATE anzahl set `".$WT."` = `".$WT."` + ".$formAnzKaffee." where kid =".$formUserId." and `kw` = ".$KW.";";
							$result = $conn->query($strSQL);
							if ($result){
								if ($debug){
									var_dump($strSQL);
									var_dump($strSQL2);
								}
							}
							//query
							$strSQL = "SELECT a.mo,a.di,a.mi,a.do,a.fr FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
							$conn->query("SET NAMES 'utf8'");
							$result = $conn->query($strSQL);
						//if result true
						if ($result){
							if ($debug){
								var_dump($strSQL);
							}
							}
						//if result false
						else{
							
								if ($debug){
									var_dump($strSQL);
								}
							
						}//If einträge mehr als 0
						if ($result->num_rows > 0) {
							//while über werte loopt
							while($row = $result->fetch_assoc()) {

										$lv_mo = $row["mo"];
										$lv_di = $row["di"];
										$lv_mi = $row["mi"];
										$lv_do = $row["do"];
										$lv_fr = $row["fr"];
										//Balken
										$lv_mob = $row["mo"] * 20;
										$lv_dib = $row["di"] * 20;
										$lv_mib = $row["mi"] * 20;
										$lv_dob = $row["do"] * 20;
										$lv_frb = $row["fr"] * 20;
										//Montag
										if ($lv_mob >= 100){
											$lv_mob = "100";
										}
										//Dienstag
										if ($lv_dib >= 100){
											$lv_dib = "100";
										}
										//Mittwoch
										if ($lv_mib >= 100){
											$lv_mib = "100";
										}
										//Donnerstag
										if ($lv_dob >= 100){
											$lv_dob = "100";
										}
										//Freitag
										if ($lv_frb >= 100){
											$lv_frb = "100";
										}
							}
						}

					}

					//Montag Farbe geben
						if ($lv_mob <= 60){
							$montagfarbe = "background-color: green;";
						}elseif($lv_mob == 80){
							$montagfarbe = "background-color: yellow;";
						}elseif($lv_mob >= 80){
							$montagfarbe = "background-color: red;";
						}
						//Dienstag Farbe geben
						if ($lv_dib <= 60){
							$dienstagfarbe = "background-color: green;";
						}elseif($lv_dib == 80){
							$dienstagfarbe = "background-color: yellow;";
						}elseif($lv_dib >= 80){
							$dienstagfarbe = "background-color: red;";
						}
						//Mittwoch Farbe geben
						if ($lv_mib <= 60){
							$mittwochfarbe = "background-color: green;";
						}elseif($lv_mib == 80){
							$mittwochfarbe = "background-color: yellow;";
						}elseif($lv_mib >= 80){
							$mittwochfarbe = "background-color: red;";
						}
						//Donnerstag Farbe geben
						if ($lv_dob <= 60){
							$donnerstagfarbe = "background-color: green;";
						}elseif($lv_dob == 80){
							$donnerstagfarbe = "background-color: yellow;";
						}elseif($lv_dob >= 80){
							$donnerstagfarbe = "background-color: red;";
						}
						//Freitag Farbe geben
						if ($lv_frb <= 60){
							$freitagfarbe = "background-color: green;";
						}elseif($lv_frb == 80){
							$freitagfarbe = "background-color: yellow;";
						}elseif($lv_frb >= 80){
							$freitagfarbe = "background-color: red;";
						}

							$ausgabe ="
								<table style=\"width: 50%; margin-left: auto; margin-right: auto;\">
									<tr>
										<td style=\"text-align: center;\">$lv_mo</td>
										<td style=\"text-align: center;\">$lv_di</td>
										<td style=\"text-align: center;\">$lv_mi</td>
										<td style=\"text-align: center;\">$lv_do</td>
										<td style=\"text-align: center;\">$lv_fr</td>
									</tr>
									<tr>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_mob; width: 27px;margin: auto; $montagfarbe \"></div></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_dib; width: 27px;margin: auto; $dienstagfarbe	\"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_mib; width: 27px;margin: auto; $mittwochfarbe \"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_dob; width: 27px;margin: auto; $donnerstagfarbe \"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_frb; width: 27px;margin: auto; $freitagfarbe \"></td>
									</tr>
									<tr>
										<td style=\"text-align: center;\">>Montag</td>
										<td style=\"text-align: center;\">>Dienstag</td>
										<td style=\"text-align: center;\">>Mittwoch</td>
										<td style=\"text-align: center;\">>Donnerstag</td>
										<td style=\"text-align: center;\">>Freitag</td>
									</tr>
								</table>
							";
							//Output
							echo $ausgabe;



						$conn->close();
//**********************************************************************************************************************************************************************
						?>
						<script>
							function newpage() {
								//window.open("//localhost/kaffee", "_self")
								window.open("//intranet.esa.ch/kaffee", "_self")
								//window.open("//testintranet.esa.ch/kaffee", "_self")
							}
							setTimeout(newpage, 5000); // 4 Sekunden


							// Input Feld 'neues PW' lÃ¶schen

						</script>
				<?php
			}//if Passwort2 == eingabe

			elseif ($row["Passwort"] == $formPasswd) {

				// $Farbe = $row["farbe"];
				// Anzahl Kaffe kleiner 1 ?

				$EntgueltigKaffePreis = $formAnzKaffee * $KaffePreis;
				$altesGuthaben = $row["guthaben"];
				$username = $row["name"];
				$email = $row["email"];
				$neuesGuthaben = $altesGuthaben - $EntgueltigKaffePreis;
				$strSQL = "update kaffee4 set guthaben=" . $neuesGuthaben . ",Passwort2='0', Passwort ='$formPassword' where ID='" . $formUserId . "'";
				//ausgabe
				$altesguthaben2 = number_format($altesGuthaben, 2);
				$kaffeepreis = number_format($EntgueltigKaffePreis, 2);
				$Guthaben = number_format($neuesGuthaben, 2);
				// var_dump($Farbe);
				// var_dump($strSQL);
				// echo "$strSQL<hr>";
				// echo ">$formUserId<<hr>";
				// echo "<hr>$EntgueltigKaffePreis = $formAnzKaffee * $KaffePreis;<hr>$strSQL<hr>";

				$result = $conn->query($strSQL);


				// Passwort muss gÃ¼ltig sein und EMAIL muss auch bekannt sein, um E-mail zu speichern
				//IF Userguthaben > 10 --> Sende Mail
				if ($altesGuthaben <= "-9.50"){
				// $mailtext = "Guten Tag $form_benutzername Ihr Neues Passwort :'$Passwort' Bitte ändern Sie dies so schnell wie mÃ¶glich unter der Benutzer Verwaltung.";
				$Name = explode (" ", $Benutzername);
				$Vorname = $Name[0];
				$Nachname = $Name[1];
				$link = "intranet.esa.ch/kaffee/anmelden.php?Vorname=$Vorname&Nachname=$Nachname";

				$absender = "Kaffee@esa.ch";
				$betreff = "Kaffee Guthaben aufladen";
				$antwortan = "Kaffee@esa.ch";
				$header = "MIME-Version: 1.0\r\n";
				$header.= "Content-type: text/html; charset=utf-8\r\n";
				$header.= "From: $absender\r\n";
				$header.= "Reply-To: $antwortan\r\n";
				// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------
				$mailtext2 ="
				<html xmlns=\"http://www.w3.org/1999/xhtml\" style=\"width: 100%;\"><head><!-- Marketo Variable Definitions --><!-- Other Meta Tags -->
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> 
				<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1\"> 
				<meta name=\"robots\" content=\"noindex,nofollow\"> 
				<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> 
				<link href=\"https://fonts.googleapis.com/css?family=OpenSans:300,400,700\" rel=\"stylesheet\" type=\"text/css\"> 
				</head> 
				<body style=\"margin-bottom: 0; -webkit-text-size-adjust: 100%; padding-bottom: 0; min-width: 100%; margin-top: 0; margin-right: 0; -ms-text-size-adjust: 100%; margin-left: 0; padding-top: 0; padding-right: 0; padding-left: 0; width: 100%;\"><style type=\"text/css\">div#emailPreHeader{ display: none !important; }</style><div id=\"emailPreHeader\" style=\"mso-hide:all; visibility:hidden; opacity:0; color:transparent; mso-line-height-rule:exactly; line-height:0; font-size:0px; overflow:hidden; border-width:0; display:none !important;\">Kennst du den aktuellen Saldo von deinem Kaffee-Konto in der ESA? Hier kommt er!</div> 
				<div style=\"display:none; white-space:nowrap; font:15px courier; line-height:0;\">
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
				</div> 
				<!-- Outer table START --> 
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\"> 
				<tbody> 
				<tr> 
				<td class=\"outer\" valign=\"top\" style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;min-width: 600px;border-collapse: collapse;background-color:#f3f3f3;\"> 
				<table width=\"640\" align=\"center\" id=\"boxing\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" class=\"m_boxing\"> 
				<tbody> 
				<tr> 
				<td class=\"mktoContainer boxedbackground\" id=\"template-wrapper\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\">
				<table id=\"header\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_header\"> 
				<tbody> 
				<tr> 
				<td class=\"bordered\" style=\"-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #f0eff4;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"220\"> 
				<tbody> 
				<tr> 
				<td class=\"center-tablet\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; text-align: left; border-collapse: collapse;\"> 
				<div style=\"display:inline-block\" class=\"mktoImg logo\" id=\"logo\" mktolockimgsize=\"true\"> 
				<a><img class=\"logo\" src=\"http://pages.esa.ch/rs/523-SZO-068/images/logo_esa_4f_transparent_de.png\" alt=\"Logo\" style=\"-ms-interpolation-mode: bicubic; outline: none; border-right-width: 0; border-bottom-width: 0; border-left-width: 0; text-decoration: none; border-top-width: 0; display: block; max-width: 100%; line-height: 100%; height: 48px; 
				width: auto;\" height=\"48\" width=\"auto\"></a> 
				</div> </td> 
				</tr> 
				<tr class=\"stack-tablet\" style=\"max-height:0px;overflow:hidden;padding-left: 0; overflow: hidden; margin-left: 0; padding-top: 0; padding-right: 0; padding-bottom: 0; float: left; margin-top: 0; margin-right: 0; margin-bottom: 0; mso-hide: all; display: none;\"> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"titlebfb8fb21-b482-4573-bf69-d8071aff322c\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_title\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font title\" style=\"-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;-ms-text-size-adjust: 100%;margin-bottom: 10px;font-family:'OpenSans', Arial, sans-serif;font-weight: bold;margin-left: 0;font-size: 24px;text-align: center;padding-top: 10px;padding-right: 0;padding-bottom: 
				10px;padding-left: 0;margin-top: 10px;margin-right: 0;color: #000000;border-collapse: collapse;border-top-color:#f3f3f3;border-top-width:1px;\"> 
				<div class=\"mktoText\" id=\"title2bfb8fb21-b482-4573-bf69-d8071aff322c\">
				<p>Grüezi $Benutzername, schmeckte dein letzter Nespresso-Kaffee leicht bitter?<br></p> 
				</div> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:5px;font-size:5px;\" height=\"5px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100\"> 
				<tbody> 
				<tr> 
				<td class=\"separator\" style=\"-webkit-hyphens: none;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-moz-hyphens: none;hyphens: none;border-top-color:#f3f3f3;border-top-style: solid;border-top-width:1px;line-height: 10px;font-size: 20px;border-collapse: 
				collapse;border-left-color:#f3f3f3;border-bottom-color:#f3f3f3;border-right-color:#f3f3f3;border-left-width:1px;border-bottom-width:1px;border-right-width:1px;\" height=\"10\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"free-image93b3f8d2-b3f5-4f8e-83c1-0f591d6ee593\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_free-image\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<center> 
				<div style=\"display:inline-block\" class=\"mktoImg\" id=\"photo93b3f8d2-b3f5-4f8e-83c1-0f591d6ee593\" mktolockimgsize=\"true\"> 
				<a href=\"http://mkto-lon040166.com/NZ00ZSxc000gDhO0M400z2A\" target=\"_blank\"><img src=\"http://pages.esa.ch/rs/523-SZO-068/images/kaffee-app_01.png\" style=\"-ms-interpolation-mode: bicubic; outline: none; border-right-width: 0; border-bottom-width: 0; border-left-width: 0; text-decoration: none; border-top-width: 0; width: auto; height: auto; max-width: 100%; display: block; line-height: 100%;\" width=\"600\"></a> 
				</div> 
				</center> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"blankSpace\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_blankSpace\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#f3f3f3;\" bgcolor=\"#f3f3f3\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"title\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_title\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table class=\"table3-3\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font title\" style=\"-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;-ms-text-size-adjust: 100%;margin-bottom: 10px;font-family:'OpenSans', Arial, sans-serif;font-weight: bold;margin-left: 0;font-size: 24px;text-align: center;padding-top: 10px;padding-right: 0;padding-bottom: 
				10px;padding-left: 0;margin-top: 10px;margin-right: 0;color: #000000;border-collapse: collapse;border-top-color:#f3f3f3;border-top-width:1px;\"> 
				<div class=\"mktoText\" id=\"title2\">
				<p><span style=\"font-size: 20px; color: #ff0000;\">Aktuelles Guthaben von $Benutzername: CHF $neuesGuthaben<br></span></p> 
				</div> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:5px;font-size:5px;\" height=\"5px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100\"> 
				<tbody> 
				<tr> 
				<td class=\"separator\" style=\"-webkit-hyphens: none;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-moz-hyphens: none;hyphens: none;border-top-color:#f3f3f3;border-top-style: solid;border-top-width:1px;line-height: 10px;font-size: 20px;border-collapse: 
				collapse;border-left-color:#f3f3f3;border-bottom-color:#f3f3f3;border-right-color:#f3f3f3;border-left-width:1px;border-bottom-width:1px;border-right-width:1px;\" height=\"10\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"free-text\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_free-text\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<center> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td class=\"primary-font text\" style=\"hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;-ms-text-size-adjust: 100%;font-family:'OpenSans', Arial, sans-serif;color: #000000;font-size: 14px;line-height: 20px;text-align: center;border-collapse: collapse;\"> 
				<div class=\"mktoText\" id=\"text\">
				<p><strong><span style=\"font-size: 16px;\">Dein Konto weist einen negativen Saldo auf – das kann passieren $Benutzername!</span></strong></p>
				<p><span style=\"font-size: 16px;\">Begleiche das kleine Defizit einfach noch heute bei Marcel Schiffmann (ESA-Mitarbeitende) bzw. Heinz Rolli (externe Berater). Dann kannst du deinen nächsten Ristretto, Espresso oder Lungo bestimmt wieder in gewohnter Manier geniessen.</span></p>
				<p><span style=\"font-size: 16px;\">Vielen Dank im Voraus.</span></p>
				<p><span style=\"font-size: 16px;\">Auf Wiedersehen</span></p> 
				</div> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:40px;font-size:40px;\" height=\"40px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> 
				</center> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"callToAction\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_callToAction\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#ffffff;\" bgcolor=\"#ffffff\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				<tr> 
				<td class=\"cta\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\"> 
				<table style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; -webkit-hyphens: none; -moz-hyphens: none; hyphens: none; border-collapse: collapse;\" align=\"center\" bgcolor=\"#1fa12e\"> <a href=\"http://mkto-lon040166.com/NZ00ZSxc000gDhO0M400z2A\" target=\"_blank\" class=\"button\" style=\"-webkit-text-size-adjust: 
				100%;-ms-text-size-adjust: 100%;border-left-color:#1fa12e;font-weight: bold;font-size: 14px;font-family: 'OpenSans', Arial, sans-serif;color: #FFF;padding-top: 12px;padding-right: 18px;padding-bottom: 12px;padding-left: 18px;border-top-width:1px;display: 
				inline-block;border-bottom-width:1px;border-left-width:1px;border-top-style: 
				solid;border-right-style: solid;border-bottom-style: solid;border-left-style: solid;border-top-color:#1fa12e;border-right-color:#1fa12e;border-bottom-color:#1fa12e;border-right-width:1px;text-decoration: none;background-color:#1fa12e;\">ZUR DEINER KAFFEE-ÜBERSICHT</a> </td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:20px;font-size:20px;\" height=\"20px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table>
				<table id=\"blankSpace2\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mktoModule m_blankSpace\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;background-color:#f3f3f3;\" bgcolor=\"#f3f3f3\" valign=\"top\"> 
				<table class=\"table600\" style=\"-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0; border-collapse: collapse; margin-top: 0; margin-right: auto; margin-bottom: 0; margin-left: auto;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\"> 
				<tbody> 
				<tr> 
				<td style=\"-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-moz-hyphens: none;hyphens: none;border-collapse: collapse;line-height:10px;font-size:10px;\" height=\"10px\">&nbsp;</td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table></td> 
				</tr> 
				</tbody> 
				</table> </td> 
				</tr> 
				</tbody> 
				</table> 
				<!-- Outer Table END -->   
				<img src=\"http://mkto-lon040166.com/trk?t=1&amp;mid=NTIzLVNaTy0wNjg6MzQwMTowOjA6MDozMDg1OjA6MTI5MDYxLTE4OTpwaGlsaXAucmlwcHN0ZWluQGVzYS5jaA%3D%3D\" width=\"1\" height=\"1\" style=\"display:none !important;\" alt=\"\">
				</body>
				</html>
				";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------

				$header.= "X-Mailer: PHP " . phpversion();
				mail($email, $betreff, $mailtext2, $header);
			}//guthaben kleiner 9.50
			
			
			
			
			
			
			//****Last Kaffee ausgabe*****
				//KW ermitteln
				$KW = KwErmitteln();
				$wochentage = array("so", "mo", "di", "mi", "do", "fr", "sa");
				$zeit = time();
				$WT = $wochentage[date("w", $zeit)];
				//Last Kaffe Wert holen
				$strSQL = "SELECT a.date FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
					$conn->query("SET NAMES 'utf8'");
					$result = $conn->query($strSQL);
					if ($result->num_rows > 0) {
						//while über werte loopt
						while($row = $result->fetch_assoc()) {
							
							$gv_lastcoffee = $row["date"];
							//Time now daten holen
							$lv_timenow = date("Y-m-d H:i:s");	
							//Formatieren
							$date1 = date_create_from_format('Y-m-d H:i:s', $gv_lastcoffee);
							$date2 = date_create_from_format('Y-m-d H:i:s', $lv_timenow);
							//Differnez = Interval
							$interval = $date2->diff($date1);
							//Formatieren
							$lv_differenz = $interval->format('%D %H:%I');
							echo"
							<h5 style=\"text-align: center;\">letztes Kaffee vor:</h6>
							<h1 style=\"text-align: center;\">$lv_differenz <span id=\"spanId\">0</span></h1>";
						}
					}else{
					echo"
							<h5 style=\"text-align: center;\">letztes Kaffee vor:</h6>
							<h1 style=\"text-align: center;\">00 00:00 <span id=\"spanId\">0</span></h1>";
					
					}

				if ($formEmail != "") {
					$strSQL = "UPDATE `kaffee4` SET `email`='" . $formEmail . "' WHERE ID='" . $formUserId . "' ";
					$result = $conn->query($strSQL);
				}

				// in jedem Fall, wenn das Passwort OK ist muss die Quittung angezeigt werden.

				if ($altesGuthaben < 0) {
					echo "
			<div style=\"margin-top: 100px; Width: 40%; margin-left: auto; margin-right: auto;\" align=\"center\">
			<h3 class=\"rot\">Bitte Kaffee Konto aufladen!</h3>";
				}
				else {
					echo "
			<div style=\"margin-top: 100px; Width: 40%; margin-left: auto; margin-right: auto;\" align=\"center\">";
				}

				echo "
							<table align=\"center\" style=\"font-size: xx-large;\">
								<tr>
									<td style=\"width: 242px;\" class=\"vertest1\">Altes Guthaben</td>
									<td class=\"vertest2\" style=\"text-align: right;\">$altesguthaben2 .-</td>
								</tr>
								<tr>
									<td class=\"vertest1\">Kaffee Preis</td>
									<td class=\"vertest2\" style=\"text-align: right;\"><p style=\"border-bottom: 1px double;\">-&nbsp;&nbsp;$kaffeepreis .-</p></td>
								</tr>
								<tr>
									<td class=\"vertest1\">Neues Guthaben</td> ";
				if ($altesGuthaben < 0) {
					echo "<td class=\"vertest2\" style=\"text-align: right; \"><p style=\"border-bottom: 3px double; color:red;\">$Guthaben .-</p></td>";
				}
				else {
					echo "<td class=\"vertest2\" style=\"text-align: right;\"><p style=\"border-bottom: 3px double;\">$Guthaben .-</p></td>";
				}

				echo "
									
								</tr>
							</table>
				</div><br> ";

					//**********************************************************************************************************************************************************************
				
					$KW = KwErmitteln();

					$wochentage = array("so", "mo", "di", "mi", "do", "fr", "sa");
					$zeit = time();
					$WT = $wochentage[date("w", $zeit)];

					$username = "esa_kaffee";
					$password = "esa_kaffee";
				// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}
					$strSQL = "SELECT a.mo,a.di,a.mi,a.do,a.fr FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
					$conn->query("SET NAMES 'utf8'");
					$strSQL2 = "UPDATE anzahl set `".$WT."` = `".$WT."` + ".$formAnzKaffee." where kid =".$formUserId." and `kw` = ".$KW.";";
					$result2 = $conn->query($strSQL2);
					$result = $conn->query($strSQL);
					//if result true
					if ($result){
						if ($debug){
							var_dump($strSQL);
						}
					}
					//if result false
					else{
						if ($debug){
							var_dump($strSQL);
						}
					}//If einträge mehr als 0
					if ($result->num_rows > 0) {
						//while über werte loopt
						while($row = $result->fetch_assoc()) {

									$lv_mo = $row["mo"];
									$lv_di = $row["di"];
									$lv_mi = $row["mi"];
									$lv_do = $row["do"];
									$lv_fr = $row["fr"];
									//Balken
									$lv_mob = $row["mo"] * 20;
									$lv_dib = $row["di"] * 20;
									$lv_mib = $row["mi"] * 20;
									$lv_dob = $row["do"] * 20;
									$lv_frb = $row["fr"] * 20;
									//Montag
									if ($lv_mob >= 100){
										$lv_mob = "100";
									}
									//Dienstag
									if ($lv_dib >= 100){
										$lv_dib = "100";
									}
									//Mittwoch
									if ($lv_mib >= 100){
										$lv_mib = "100";
									}
									//Donnerstag
									if ($lv_dob >= 100){
										$lv_dob = "100";
									}
									//Freitag
									if ($lv_frb >= 100){
										$lv_frb = "100";
									}
						}
					}
					//if einträge 0
					else {
							$strSQL2 = "INSERT INTO `anzahl` SET `kid`= ".$formUserId.",`kw`= ".$KW." ;";
							$result2 = $conn->query($strSQL2);
							$strSQL = "UPDATE anzahl set `".$WT."` = `".$WT."` + ".$formAnzKaffee." where kid =".$formUserId." and `kw` = ".$KW.";";
							$result = $conn->query($strSQL);
							if ($debug){
							var_dump($strSQL);
							var_dump($strSQL2);
							}
							//query
							$strSQL = "SELECT a.mo,a.di,a.mi,a.do,a.fr FROM `anzahl` AS a JOIN `kaffee4` AS k On a.kid = k.ID WHERE a.kid = ".$formUserId." and `kw` = ".$KW.";";
							$conn->query("SET NAMES 'utf8'");
							$result = $conn->query($strSQL);
						//if result true
						if ($result){
								if ($debug){
								var_dump($strSQL);
								}
							}
						//if result false
						else{
							if ($debug){
								var_dump($strSQL);
							}
						}//If einträge mehr als 0
						if ($result->num_rows > 0) {
							//while über werte loopt
							while($row = $result->fetch_assoc()) {

										$lv_mo = $row["mo"];
										$lv_di = $row["di"];
										$lv_mi = $row["mi"];
										$lv_do = $row["do"];
										$lv_fr = $row["fr"];
										//Balken
										$lv_mob = $row["mo"] * 20;
										$lv_dib = $row["di"] * 20;
										$lv_mib = $row["mi"] * 20;
										$lv_dob = $row["do"] * 20;
										$lv_frb = $row["fr"] * 20;
										//Montag
										if ($lv_mob >= 100){
											$lv_mob = "100";
										}
										//Dienstag
										if ($lv_dib >= 100){
											$lv_dib = "100";
										}
										//Mittwoch
										if ($lv_mib >= 100){
											$lv_mib = "100";
										}
										//Donnerstag
										if ($lv_dob >= 100){
											$lv_dob = "100";
										}
										//Freitag
										if ($lv_frb >= 100){
											$lv_frb = "100";
										}
							}
						}

					}

					//Montag Farbe geben
						if ($lv_mob <= 60){
							$montagfarbe = "background-color: green;";
						}elseif($lv_mob == 80){
							$montagfarbe = "background-color: yellow;";
						}elseif($lv_mob >= 80){
							$montagfarbe = "background-color: red;";
						}
						//Dienstag Farbe geben
						if ($lv_dib <= 60){
							$dienstagfarbe = "background-color: green;";
						}elseif($lv_dib == 80){
							$dienstagfarbe = "background-color: yellow;";
						}elseif($lv_dib >= 80){
							$dienstagfarbe = "background-color: red;";
						}
						//Mittwoch Farbe geben
						if ($lv_mib <= 60){
							$mittwochfarbe = "background-color: green;";
						}elseif($lv_mib == 80){
							$mittwochfarbe = "background-color: yellow;";
						}elseif($lv_mib >= 80){
							$mittwochfarbe = "background-color: red;";
						}
						//Donnerstag Farbe geben
						if ($lv_dob <= 60){
							$donnerstagfarbe = "background-color: green;";
						}elseif($lv_dob == 80){
							$donnerstagfarbe = "background-color: yellow;";
						}elseif($lv_dob >= 80){
							$donnerstagfarbe = "background-color: red;";
						}
						//Freitag Farbe geben
						if ($lv_frb <= 60){
							$freitagfarbe = "background-color: green;";
						}elseif($lv_frb == 80){
							$freitagfarbe = "background-color: yellow;";
						}elseif($lv_frb >= 80){
							$freitagfarbe = "background-color: red;";
						}

							$ausgabe ="
								<table style=\"width: 50%; margin-left: auto; margin-right: auto;\">
									<tr>
										<td style=\"text-align: center;\">$lv_mo</td>
										<td style=\"text-align: center;\">$lv_di</td>
										<td style=\"text-align: center;\">$lv_mi</td>
										<td style=\"text-align: center;\">$lv_do</td>
										<td style=\"text-align: center;\">$lv_fr</td>
									</tr>
									<tr>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_mob; width: 27px;margin: auto; $montagfarbe \"></div></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_dib; width: 27px;margin: auto; $dienstagfarbe	\"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_mib; width: 27px;margin: auto; $mittwochfarbe \"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_dob; width: 27px;margin: auto; $donnerstagfarbe \"></td>
										<td style=\"vertical-align: bottom;\"><div style=\"border:1px solid black; height: $lv_frb; width: 27px;margin: auto; $freitagfarbe \"></td>
									</tr>
									<tr>
										<td style=\"text-align: center;\">Montag</td>
										<td style=\"text-align: center;\">Dienstag</td>
										<td style=\"text-align: center;\">Mittwoch</td>
										<td style=\"text-align: center;\">Donnerstag</td>
										<td style=\"text-align: center;\">Freitag</td>
									</tr>
								</table>
							";
							//Output
							echo $ausgabe;



						$conn->close();
//**********************************************************************************************************************************************************************
			?>

			<script>
				function newpage() {
					//window.open("//localhost/kaffee", "_self")
					window.open("//intranet.esa.ch/kaffee", "_self")
					//window.open("//testintranet.esa.ch/kaffee", "_self")
				}
				setTimeout(newpage, 5000); // 4 Sekunden


				// Input Feld 'neues PW' lÃ¶schen


			</script>
			<?php

				// header location
				// header($gv_Hederlocation);
				// else passwort nicht ok

			}//Passwort1 == eingabe
			else {
				/*echo "Result: <br />";
				var_dump($result);
				echo "SQL Query: <br />";
				var_dump($strSQL);
				echo "Row Passwort: <br />";
				var_dump($row["Passwort"]);
				echo "Eingabe Passwort: <br />";
				var_dump($formPasswd);
				*/
				// Wenn das PWD Falsch ist, nicht zur Startseite zurÃ¼ck, sondern eine Meldung ausgeben.
				echo '<br /><a href="index.php" class="button">Zurück</a><br /><br />';
				echo "Das Passwort ist leider nicht korrekt. Die Abbuchung konnte somit nicht abgeschlossen werden.";
			}
		}//while fetch assoc
	}
	else {
		/*echo "Result: <br />";
		var_dump($result);
		echo "SQL Query: <br />";
		var_dump($strSQL);
		echo "Row Passwort: <br />";
		var_dump($row["Passwort"]);
		echo "Eingabe Passwort: <br />";
		var_dump($formPasswd);
		*/
		echo '<br /><a href="index.php" class="button">Zurück</a><br /><br />';
		echo "Bitte melden Sie sich beim Administrator !!!";
	}

?>
        <script>
            var tbl = document.getElementById('tabel');
            alert(tbl.innerHTML);
        </script>

        <?php

	// Verbindung wieder schliessen


} //---------------------------------------------------------------------------------------------

elseif ($paramVT == "email") {
	if (!isset($_POST["form_benutzername"])) {
		$form_benutzername = "";
	}
	else {
		$form_benutzername = $_POST["form_benutzername"];
	};
	$formUserId = get_UserID($form_benutzername, $servername, $username, $password, $dbname);
	$lv_UserEmail = get_UserEmail($formUserId, $servername, $username, $password, $dbname);
	$Guthaben = get_UserGuthaben($formUserId, $servername, $username, $password, $dbname);

	// Random Zahl erzeugen

	$str = 'abcd123';
	$Passwort = str_shuffle($str);

	// var_dump($Passwort);

	if ($lv_UserEmail != '') {

		// Auf DB Verbinden

		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Random Zahl speichern

		$strSQL = "update kaffee4 set Passwort2='" . $Passwort . "' where name='" . $form_benutzername . "'";
		$result = $conn->query($strSQL);
		if ($result) {

			// gelungen

			echo "<p><a href=\"index.php\" class=\"button\">Zurück</a></p>";
			echo "E-mail wurde gesendet";

			// $mailtext = "Guten Tag $form_benutzername Ihr Neues Passwort :'$Passwort' Bitte ändern Sie dies so schnell wie mÃ¶glich unter der Benutzer Verwaltung.";
			$Name = explode (" ", $form_benutzername);
			$Vorname = $Name[0];
			$Nachname = $Name[1];
			$link = "intranet.esa.ch/kaffee/anmelden.php?Vorname=$Vorname&Nachname=$Nachname&pwd=$Passwort";
			$mailtext = "
				<html>
					<head>
						<title>Kaffee Benutzerdaten</title>
					</head>
					
					<body>
					
					<h1>Kaffee Benutzerdaten</h1>
					
					<p>Bitte ändern Sie Ihr Passwort unter der <b>Benutzer Verwaltung</b>.<br> <a href=\".$link\">Passwort ändern</a></p>
					
					
					<table border=\"1\">
					<tr>
						<td>Beschreibung</td>
						<td>Daten</td>
					</tr>
					<tr>
						<td>Benutzername</td>
						<td>$Vorname $Nachname</td>
					</tr>
					<tr>
						<td>Guthaben</td>
						<td>$Guthaben .-</td>
					</tr>
					<tr>
						<td>E-Mail</td>
						<td>$lv_UserEmail</td>
					</tr>
					<tr>
						<td>Neues Passwort&nbsp;&nbsp;</td>
						<td>$Passwort</td>
					</tr>
					</table> 
					<br>
					<br />
					<a>Bei weiteren Fragen oder Unklarheiten melden Sie sich bitte unter: </a><br />
					<p>Philip.Rippstein@esa.ch</p>
					
					
					<a>oder</a><br />
					<p>Marcel.Schiffmann@esa.ch</p><br />
					
					</body>
					</html>
								
								";
			$absender = "Kaffee@esa.ch";
			$betreff = "Kaffee Passwort";
			$antwortan = "Kaffee@esa.ch";
			$header = "MIME-Version: 1.0\r\n";
			$header.= "Content-type: text/html; charset=utf-8\r\n";
			$header.= "From: $absender\r\n";
			$header.= "Reply-To: $antwortan\r\n";

			// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll

			$header.= "X-Mailer: PHP " . phpversion();
			mail($lv_UserEmail, $betreff, $mailtext, $header);

			// result flase

		}
		else {
			echo "Fehler beim Senden";
		}
	}
	else {
		echo "<p id=\"floatfarbe\"><a href=\"index.php\" class=\"button\">Zurück</a></p>";
		echo "<br /><br />";
		echo "<h2>Sie haben noch keine E-Mail Adresse angegeben um Ihr Passwort zurückzusetzen.</h2>";
	}

	// Verbindung wieder schliessen

	$conn->close();
} //paramVT == email

?>