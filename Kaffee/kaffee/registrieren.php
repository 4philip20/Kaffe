<?php
	include "inc/global.php";
	include "inc/head.inc";
	
    if (! isset($_POST["form_benutzername"])) {$form_benutzername = "";} else {$form_benutzername = $_POST["form_benutzername"]; };
    if (! isset($_POST["farbe"])) {$farbe = "#2671a5";} else {$farbe = $_POST["farbe"]; };
	if (! isset($_POST["form_passwort"]))  {$form_passwort = '';}  else { $form_passwort = $_POST["form_passwort"]; };
	if (! isset($_POST["form_passwort2"])) {$form_passwort2 = '';} else {$form_passwort2 = $_POST["form_passwort2"]; };
	if (! isset($_POST["form_email"])) {$form_email = '';} else {$form_email = $_POST["form_email"]; };
	if (! isset($_GET["vt"])) {$paramVT = '';} else { $paramVT = $_GET["vt"]; };
	
	// Wenn Param = R - Registration anzeigen	
	if ($paramVT == "r") {

?>
		<h1 class="forueberschriftRegi">Kaffee - Registrieren</h1>
		<img src="Esa.jpg" width="230px">
		<!-- Registration Formular -->
		<p><a href="index.php" class="button">Zurück</a></p>


		<fieldset class="Buttonheadregi">
		<form id="formRegistration" action="<?php $lvPage = $_SERVER['SCRIPT_NAME']; echo "$lvPage?vt=v"; ?>" method="Post">
			
				<label class="formLabel1" form="formRegistration" >Benutzername:</label>
				<input type="text" name="form_benutzername" id="fuerlabel" placeholder="Vor- und Nachname" value="<?php echo $form_benutzername; ?>">
				<br>
				<label class="formLabel1" form="formRegistration" >E-mail-Adresse:</label>
				<input type="email" name="form_email" id="fuerlabel" required placeholder="E-mail-Adresse" value="<?php echo $form_email; ?>">
				<br>
				<label class="formLabel1" form="formRegistration" class="lafarbig ">Passwort:</label>
				<input type="password" name="form_passwort" id="fuerlabel" placeholder="Mind. 4 Zeichen" value="<?php echo $form_passwort; ?>"><br>
				<label class="formLabel1" form="formRegistration" class="lafarbig ">Passwort wiederhohlen:</label>
				<input type="password" name="form_passwort2" id="fuerlabel" placeholder="Mind. 4 Zeichen" value="<?php echo $form_passwort2; ?>"><br>
				<label class="formLabel1" form="formfarbe" class="lafarbig ">Ihre Farbe auswählen:</label><br>
				<!-- Farben auswählen start-->
				<script src="jscolor.js"></script>
		
				<button class="jscolor {valueElement:'chosen-value', onFineChange:'setTextColor(this)'}" id="farbewaehlenregi">
					Farbe wählen
				</button>

				<input id="chosen-value" name="farbe" value="#2671a5">
				<script>
					function setTextColor(picker) {
						document.getElementsByTagName('body')[0].style.color = '#' + picker.toString();
						var farbeunverarbeitet = document.getElementById('chosen-value').value = '#'+value;
						//var hashtag = "#";
						var farbe = '#'+farbeunverarbeitet;
						//alert (farbe);
						
					}
				</script>
				<!-- Farben auswählen fertig-->
				<br><br>
				<input type="submit" value="Registrieren" class="submitbutton">
			
		</form> 
		</fieldset>
		
 <?php
	}elseif ($paramVT == "v") {
	echo "<h1>Kaffee-Erfassung Esa Registrieren</h1>";
	// Wenn Param = V - Registration der Users auf der DB
		// Wenn Benutzername => vier Stellen (Vorgabe) sonst  Error Meldung.
		if (strlen($form_benutzername) >= 4 ){
			//Passwort überprüfen ob 1 verusch genau so ist wie verusch 2  sonst  Error Meldung.
			if ($form_passwort == $form_passwort2){
				// Wenn Passwort => vier Stellen (Vorgabe) sonst  Error Meldung.	
				if (strlen($form_passwort) >= 4 ){
					if ( registrationBenutzer( $form_benutzername, $form_passwort,$form_email,$farbe, $servername, $username, $password, $dbname) ) {
						echo " Der User $form_benutzername wurde auf der Datenbank Registriert<br>";
						echo '<a href="index.php" class="button" style="padding-top:15px;">Zurück</a>';
					} else {
					echo "<br>Der User $form_benutzername konnte <b>nicht</b> Registriert werden!<br>";
					zurueckRegistrieren($form_benutzername, $form_passwort, $form_passwort2);
					}
				} else {
					echo "Fehler beim Passwort Ihr Passwort \"$form_passwort\" ist zu kein und muss mindestends 5 Zeilen beinhalten ";	
					zurueckRegistrieren($form_benutzername, $form_passwort, $form_passwort2);
				}
			} else {
				echo "Fehler beim Passwort! Wiederhohlung ist ungleich... ";
				zurueckRegistrieren($form_benutzername, $form_passwort, $form_passwort2);
			}
		} else {
			echo "Fehler in Username \"$form_benutzername\"... ";
			zurueckRegistrieren($form_benutzername, $form_passwort, $form_passwort2);
		}
	}

?>
