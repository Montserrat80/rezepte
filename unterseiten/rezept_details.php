<?php
namespace php\classes;

#$this->seiteninhalt = "<h1>Details</h1>";
$this->seiteninhalt = "";

if(isset($_POST["rezepte_nr"]) && is_numeric($_POST["rezepte_nr"]) )
{
	#echo $_POST["rezepte_nr"];
	
	$rezept = new Rezept($_POST["rezepte_nr"]);
	
	#print_r($produkt);
	if($rezept->bezeichnung != "")
	{
		$this->seiteninhalt .= $rezept->details_anzeigen();	
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