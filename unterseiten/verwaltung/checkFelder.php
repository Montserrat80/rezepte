<?php
require_once("php/functions/myFunctions.php");
#control de camps
#1.-Si hi ha camps buits en la rezepte no podem fer els inserts
$fehler = false;
$string = "";
if(empty(trim($this->temp_daten["bezeichnung"])) || empty($this->temp_daten["menueart_nr"]) || empty($this->temp_daten["schwstufe_nr"]) || 
   empty($this->temp_daten["arbeitzeit"]) || empty($this->temp_daten["portionen"]) ||
   empty(trim($this->temp_daten["zubereitung"])) || empty($this->temp_daten["kcal"]) || empty(trim($this->temp_daten["eiweiss"])) || 
   empty(trim($this->temp_daten["fett"])) || empty(trim($this->temp_daten["kohlenhydrate"])))
{
	$fehler=true;
}

#2.- Si error --> donar avis de camps obligatoris buits, si no passem a controlar el format de camps: eiweiss, fett, kohlenhydrate
if($fehler)
{
	$string .= "<p class='meldung'>Die Felder markiert mit * sind pflicht.</p>";
}

if(!empty(trim($this->temp_daten["eiweiss"])))
{
	$this->temp_daten["eiweiss"] = str_replace(",",".",$this->temp_daten["eiweiss"]); #per defecte canvio la , pel .
	$checkFormat = check_fomat_decimal($this->temp_daten["eiweiss"]);

	if (!$checkFormat) 
	{
		$string .= "<p class='meldung'>Eiweiss (".$this->temp_daten['eiweiss']."): Die eingegebene Menge ist nicht korrekt. Der maximal erlaubte Wert ist 99.99</p> ";
		$fehler=true;
	}
}

if(!empty(trim($this->temp_daten["fett"])))
{
	$this->temp_daten["fett"] = str_replace(",",".",$this->temp_daten["fett"]); #per defecte canvio la , pel .
	$checkFormat = check_fomat_decimal($this->temp_daten["fett"]);

	if (!$checkFormat) 
	{
		$string .= "<p class='meldung'>Fett (".$this->temp_daten['fett']."): Die eingegebene Menge ist nicht korrekt. Der maximal erlaubte Wert ist 99.99</p> ";
		$fehler=true;
	}
}

if(!empty(trim($this->temp_daten["kohlenhydrate"])))
{
	$this->temp_daten["kohlenhydrate"] = str_replace(",",".",$this->temp_daten["kohlenhydrate"]); #per defecte canvio la , pel .
	$checkFormat = check_fomat_decimal($this->temp_daten["kohlenhydrate"]);

	if (!$checkFormat) 
	{
		$string .= "<p class='meldung'>Kohlenhydrate (".$this->temp_daten['kohlenhydrate']."): Die eingegebene Menge ist nicht korrekt. Der maximal erlaubte Wert ist 99.99</p>";
		$fehler=true;
	}
}
return $string;
?>