<?php
namespace php\classes;


$this->seiteninhalt = "<div id='infoContainer'>
						<h2 class='zentrieren'>Neues Rezept</h2>
							<p class='zentrieren'>
								<a class='linkButton' href='/".BASIS_PFAD."/adminbereich'>Zurück</a>
							</p><br /><br />";

$rezept = new Rezept();
$this->seiteninhalt .= $rezept->hinzufuegen();
$this->seiteninhalt .= "<br />
					   <p class='zentrieren'>
						<a class='linkButton' href='/".BASIS_PFAD."/adminbereich'>Zurück</a>
					   </p><br /><br />
					</div>";
?>