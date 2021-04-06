<?php
$this->seiteninhalt ="
<div id='infoContainer' class='zentrieren'>
<h2>Anmelden</h2>
<p class='meldung'>$meldung</p>
<form method='post'>
<input class='cFeld' type='text' name= 'benutzer' placeholder='Benutzername'/>
<br />
<input class='cFeld' type='password' name='pwd' placeholder='Passwort'/>
<br />
<input type='submit' name='anmelden' value='Anmelden' />
<p> Noch nicht registriert? <a href='registrieren'>Hier registrieren</a></p>
</form>
</div>";
?>					

<!--
if (isset($_GET['meldung']))
{
	if( $_GET['meldung'] == 1)
	{
		 echo '<p class='meldung'>bitte füllen Sie das Feld Benutzername | Passwort aus</p>';
	}
	if( $_GET['meldung'] == 2)
	{
		 echo '<p class='meldung'>Benutzarname / Passwort ist falsch</p>';
	}
}-->