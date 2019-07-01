<?php
include "inc/global.php";
include "inc/head.inc";
?>
<h1 class="forueberschriftbewertung">Kaffee - Bewertung</h1>
		<img src="Esa.jpg" width="230px">
		<!-- Registration Formular -->
		<p><a href="index.php" class="button">Zurück</a></p>
<head>
<title>test</title>
<!--
<script src="/rating/jquery.js" type="text/javascript" language="javascript"></script>
<script src='/rating/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
<script src="/rating/jquery.rating.js" type="text/javascript" language="javascript"></script>
<script src="/rating/rating.js" type="text/javascript" language="javascript"></script>
<link href="/rating/jquery.rating.css" type="text/css" rel="stylesheet"/>
-->
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

</script>

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


</head>

<form name="star1" method="Post" action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=v"; ?>">
<table>
<tbody>

        <div>Ihre Bewertung</div>
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
		Verbesserungsvorschläge:<div><textarea type="text" rows="4" name="kommentar" cols="60" placeholder="Ihre Verbesserungsvorschläge..." pattern="[A-Za-z0-9]{1,20}"> </textarea></div>

</tbody>
</table>
<input type="submit" value="Absenden">
</form>





<?php
if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
if (! isset($_POST["star1"])) {$star = '';} else {$star = $_POST["star1"]; };
if (! isset($_POST["kommentar"])) {$kommentar = '';} else {$kommentar = $_POST["kommentar"]; };
if ($paramVT == "v"){

$gv_Hederlocation = "Location: http://intranet.esa.ch/kaffee/index.php";
header($gv_Hederlocation);

echo "<br>Vielen Dank für Ihre Bewertung";

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
	
	
}
?>
