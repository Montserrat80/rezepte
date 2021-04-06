<?php
namespace php\classes;
use php\classes\pdo\Datenbank;

class Rezeptliste
{
	# Eigenschaften
	# Methoden
	public function alle_rezepte_laden()
	{
		$db = new Datenbank();
		return $db->lesen("SELECT rezepte_nr FROM rezepte");
	}
	public function alle_rezepte_laden_mit_suchfeld($userSuchfeld)
	{
		#ini - Suche vorbereitung ###########################################
		$suche_zeichenkette = ""; # Initialisierung (es steht nichts drin / bedingung fehlt
		$suche_zeichenkette2 = ""; # Initialisierung (es steht nichts drin / bedingung fehlt
		$sucheliste = array(); # Initialisierung (es steht nichts drin / bedingung fehlt
		$sucheliste2 = array(); # Initialisierung (es steht nichts drin / bedingung fehlt
		if(isset($userSuchfeld))
		{
			$woerterliste = explode(",", $userSuchfeld); # coma zeichen trennung = AND
			
			foreach($woerterliste as $wort)
			{
				$wort = trim($wort);
				$sucheliste[] = "(
							rezepte.bezeichnung LIKE '%$wort%'
							OR menue_arten.menueart_bz LIKE '%$wort%'
							OR schwierigkeitsstufen.schwstufe_bz LIKE '%$wort%'
							OR rezepte_zutaten.zutaten_bz LIKE '%$wort%'
							)";
				$sucheliste2[] = "(
							rezepte.bezeichnung LIKE '%$wort%'
							OR menue_arten.menueart_bz LIKE '%$wort%'
							OR schwierigkeitsstufen.schwstufe_bz LIKE '%$wort%'
							)";
			
			
			}
			$suche_zeichenkette = implode(" OR ", $sucheliste); # array in zeichenkette konvertieren
			$suche_zeichenkette2 = implode(" OR ", $sucheliste2); # array in zeichenkette konvertieren
		}
		if($suche_zeichenkette != "")
		{
			$suche_zeichenkette = " AND ($suche_zeichenkette) ";
		}
		if($suche_zeichenkette2 != "")
		{
			$suche_zeichenkette2 = " AND ($suche_zeichenkette2) ";
		}
		#fi - Suche vorbereitung#############################################	
		$sql_befehl = "SELECT DISTINCT rezepte.rezepte_nr,bezeichnung, bild
								  FROM rezepte, menue_arten, schwierigkeitsstufen, rezepte_zutaten
								 WHERE rezepte.menueart_nr = menue_arten.menueart_nr
								   AND rezepte.schwstufe_nr = schwierigkeitsstufen.schwstufe_nr	
								   AND rezepte.rezepte_nr = rezepte_zutaten.rezepte_nr
									   $suche_zeichenkette 
								 UNION		
			
						SELECT DISTINCT rezepte.rezepte_nr,bezeichnung, bild
								   FROM rezepte, menue_arten, schwierigkeitsstufen
							      WHERE rezepte.menueart_nr = menue_arten.menueart_nr
								    AND rezepte.schwstufe_nr = schwierigkeitsstufen.schwstufe_nr	
								    AND rezepte.rezepte_nr NOT IN ( SELECT rezepte_zutaten.rezepte_nr FROM rezepte_zutaten)
								    $suche_zeichenkette2  
							ORDER BY 1";		
		
		
		$db = new Datenbank();
		return $db->lesen($sql_befehl);
	}
}
?>