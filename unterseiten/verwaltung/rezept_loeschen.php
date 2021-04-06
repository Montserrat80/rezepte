<?php
namespace php\classes;

$this->seiteninhalt  = "";
if(isset($_POST["rezepte_nr"]) && is_numeric($_POST["rezepte_nr"]) )
{
	#echo $_POST["rezepte_nr"];
	
	$rezept = new Rezept($_POST["rezepte_nr"]);
	
	if($rezept->bezeichnung != "")
	{
		$this->seiteninhalt .= $rezept->loeschen_besteatingen();	
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