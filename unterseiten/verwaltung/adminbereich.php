<?php
namespace php\classes;

$this->seiteninhalt = "";

if(isset($_POST["userSuchfeld"]))
{
	if(!empty($_POST["userSuchfeld"])) 
	{
		$_SESSION["userSuchfeld"] = $_POST["userSuchfeld"];
	}
	else{
		unset($_SESSION["userSuchfeld"]);
	}
}

$this->seiteninhalt .= "	<div class='zentrieren'><form method='post'>
						<input class='cFeld' type='text' name='userSuchfeld' value='".@$_SESSION["userSuchfeld"]."' />
						<input type='submit' value='Suchen'/>
						</form></div><br />";

$this->seiteninhalt .= "<p class='zentrieren'><a class='linkButton2' href='/".BASIS_PFAD."/adminbereich/rezept_hinzufuegen'>Neues Rezept</a></p><br /><br />";


$this->seiteninhalt .= "<div id='rezeptWrapper'>";
$rezeptliste = new Rezeptliste();
if(isset($_SESSION["userSuchfeld"]))
{
	$liste = $rezeptliste->alle_rezepte_laden_mit_suchfeld($_SESSION["userSuchfeld"]);
}
else
{
	$liste = $rezeptliste->alle_rezepte_laden();
}

foreach($liste as $arrayRezepte)
{
	$rezept = new Rezept($arrayRezepte["rezepte_nr"]);
	$this->seiteninhalt .= $rezept->vorschau_admin();
}
$this->seiteninhalt .= "</div>";
?>

