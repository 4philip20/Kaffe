<?php
include "inc/global.php";
include "inc/head.inc";

echo "<h1 class=\"forueberschriftverw\" >Kaffee - <b1 class=\"VerwaltungRot\">Administration</b1></h1>";
echo "<p><img src='Esa.jpg' / width='230px'></p>"; 	 
echo "<p><a href=\"index.php\" class=\"button\">Zurück</a></p>";

// Anmelden Formular für Admin
?>
<!-- Passwortabfrage -->
	<fieldset id="formPasswort" >

	<form action="<?php echo "verwaltung.php?vt=a"; ?>" method="Post">
	    <label class="formLabel1" for="passwd">Adm. User</label>
		<input pattern="[A-Za-z]{5}" type="input" id="fuerlabel" name="formAdminName" value=""><br>
		<label class="formLabel1" for="passwd">Adm. Passwort</label>
		<input type="password" id="fuerlabel" name="formPasswd" length="30">
		<div id="div01"><input class="submitbutton" id="A2" type="submit" value="Anmelden"><br></div>
	</form>
	
	</fieldset>
<?php
include "inc/fooder.inc";
?>