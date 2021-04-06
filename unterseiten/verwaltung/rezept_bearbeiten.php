<?php
namespace php\classes;
$this->seiteninhalt = "Bearbeiten";

$this->seiteninhalt  = "";
if(isset($_POST["rezepte_nr"]) && is_numeric($_POST["rezepte_nr"]) )
{
	#echo $_POST["rezepte_nr"];
	
	$rezept = new Rezept($_POST["rezepte_nr"]);
	
	if($rezept->bezeichnung != "")
	{
		$this->seiteninhalt = "<div id='infoContainer'>
						<h2 class='zentrieren'>Rezept bearbeiten</h2>
							<p class='zentrieren'>
								<a class='linkButton' href='/".BASIS_PFAD."/adminbereich'>Zurück</a>
							</p><br /><br />";
		$this->seiteninhalt .= $rezept->bearbeiten();	
		$this->seiteninhalt .= "<br />
					   <p class='zentrieren'>
						<a class='linkButton' href='/".BASIS_PFAD."/adminbereich'>Zurück</a>
					   </p><br /><br />
					</div>";
	}
	else
	{
		$this->seiteninhalt =  "<p class='meldung2'>Rezept nicht gefunden</p>";
	}
}
else
{
	$this->seiteninhalt =  "<p class='meldung2'>Kein gültiges Rezept ID</p>";
}

?>