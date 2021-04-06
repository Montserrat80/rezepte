<?php
namespace php\classes;
use php\classes\pdo\Datenbank;

class Rezepte_zutaten
{
    // Eigenschaften
    protected $rezepte_nr = "";            
    protected $zutaten_nr = "";            
    protected $menge = "";            
    protected $zutaten_bz = "";            
    protected $einheit_bz = ""; 
	
	protected $rezept_zutaten_array = [];
	#Traits
	use \php\traits\WerkFunktionen;
	
	#Methoden
	public function datenFormularFormat_checken($daten,&$meldung_einheit)
	{
		#anem a buscar les Einheiten a la BD
		$db = new Datenbank();
		$einheit_liste = $db->lesen("SELECT einheit_bz as einheit FROM zutaten_einheiten");
		$einheit_array = [];
		foreach($einheit_liste as $einheit)
		{
			$einheit_array[] .= $einheit["einheit"];
		}
		
		$einheiten_gescheitert = "";	
		
		$array_temp = explode(",",$daten);
		foreach($array_temp as $zutat_daten)
		{
			$zutat_daten = trim($zutat_daten);
			
			$zutat_daten_array_temp = explode(" ",$zutat_daten);
			
			//treiem els elements de l´array que contenen un espai en blanc, ja que pot ser que l usuari entre dada i dada hi posi mes d un espai
			$count = count($zutat_daten_array_temp);
			for($i = 0; $i < $count; $i ++)
			{
				if(empty($zutat_daten_array_temp[$i]))
				{
					unset($zutat_daten_array_temp[$i]);
				}
			}
			$this->rezept_zutaten_array[] = $zutat_daten_array_temp;
		}
		
		#cal controlar casos que no acceptem: menys de 3 elements, que el primer no sigui una quantitat
		$index = 0;
		$fehler = 0;
		#si hem entrat ingredients cal fer la comprovacio. Si no hi ha ingredients l array esta buit
		/*Array
			(
			[0] => Array
			( 
			)
		)*/
		if(!(count($this->rezept_zutaten_array) == 1 && count($this->rezept_zutaten_array[0]) == 0))
		{
			foreach($this->rezept_zutaten_array as $index => $zutat_daten)
			{
				#menys de 3 elements
				if(count($this->rezept_zutaten_array[$index])< 3)
				{
					$fehler = -1;
				}
				
				else
				{
					#el primer element [0] ha de ser una quantitat (Menge)
					if(!$this->testNumber($zutat_daten[0]))
					{
						$fehler = -1;
					}
					#el segon element ha de ser una einheit valida
					
					#el punter de l array sempre apunta al primer element i nosaltres volem sempre el segon, com que no sempre podem assegurar que l index de la posicio es 1, ja que podria ser que l usuari hagi entrat espais en blanc entre mig de la quantit i unitat
					$einheit = next($zutat_daten);
					
					$einheit_bd = $this->testEinheit($einheit,$einheit_array);
					if(empty($einheit_bd))
					{
						$einheiten_gescheitert .= $einheit.", ";
					}
					else
					{
						$this->rezept_zutaten_array[$index][key($zutat_daten)] = $einheit_bd;
					}
				}
			}
			
			if(!empty($einheiten_gescheitert))
			{
				#treiem l ultima coma
				$einheiten_gescheitert = substr($einheiten_gescheitert,0,strlen($einheiten_gescheitert)-2);
				$fehler = $fehler +(-2);
				$meldung_einheit .= "<p class='meldung'>Die Einheit/en: ". $einheiten_gescheitert ." ist/sind nicht rihtig.<br /></p>";
			
				$meldung_einheit .= "<p>Einheiten:<br /> ".implode(", ",$einheit_array)."</p><br />";
			}
		}
		return $fehler;
	}
	
	public function speichern($rezepte_nr, $modus, $zutatenInitialCount = 0)
	{
		$this->rezepte_nr = $rezepte_nr;
		$string = "";
		$loeschen_numrows = 0;
		$hinzufuegen_numrows = 0;
		
		#per guardar els ingredients hauriem de saber si son nous, els ha modificat, esborrat ??? com ho puc saber? com que es complicat val mes la pena que esborrem tots els ingredients de la recepta i inserim els que tenim en el formulari.
		#si la recepta es nova tampoc i haurea ingredients a la bd per tan esborrem els ingredients nomes en el cas que vinguem de modificar la recepta, encara que tb es podria donar el cas que no hi haguessin ingredients a la bd, pero tampoc dona cap problema
		if($modus == "bearbeiten" && $zutatenInitialCount > 0)
		{
			$loeschen_numrows = $this->loeschen();
		}
		
		#nomes anem a gravar si hi ha dades, si es buit segurament hauem hagut nomes d esborrar els ingredients de la recepta
		if(count($this->rezept_zutaten_array) > 0)
		{
			foreach($this->rezept_zutaten_array as $zutat_daten)
			{
				
				$this->menge = "";            
				$this->zutaten_bz = "";            
				$this->einheit_bz = "";
				$num_element = 0;
				foreach($zutat_daten as $zutat_daten_value)
				{
					$num_element ++;
					if($num_element == 1) $this->menge = htmlspecialchars($zutat_daten_value);
					if($num_element == 2) $this->einheit_bz = htmlspecialchars($zutat_daten_value);
					
					#si entren n paraules el que faig es ajuntar el contingut de les posicions de l´array > 3 a la darrera posicio
					if($num_element > 2)  $this->zutaten_bz .= htmlspecialchars($zutat_daten_value)." ";  
				}
				#treiem l ultim espai en blanc
				$this->zutaten_bz = trim($this->zutaten_bz);
				
				$hinzufuegen_numrows += $this->hinzufuegen();
				
			}
		}	
		if($loeschen_numrows > 0 || $hinzufuegen_numrows > 0)
		{
			$string = "<p class='meldung'>Die Zutaten Daten sind erfolgreich gespeichert <br /></p>";
		}
		if($loeschen_numrows < 0 || $hinzufuegen_numrows < 0)
		{
			$string = -1;
		}
		return $string;
	}
	
	protected function loeschen()
	{
		#1 .- esborro els ingredients de la recepta
		$db = new Datenbank();
		return $db->loeschen(" DELETE FROM rezepte_zutaten WHERE rezepte_nr = '$this->rezepte_nr'");
	}
	
	protected function hinzufuegen()
	{
		$db = new Datenbank();
		$zutaten_nr = $db->einfuegen( "INSERT INTO rezepte_zutaten 
									   (rezepte_nr, menge, zutaten_bz, einheit_bz)
								 VALUES('$this->rezepte_nr', '$this->menge', '$this->zutaten_bz','$this->einheit_bz')");	
		return $zutaten_nr;
	}
	
	public function zutaten_liste_laden( $rezepte_nr)
	{
		$db = new Datenbank();
		$liste =  $db->lesen("SELECT zutaten_nr, menge, einheit_bz, zutaten_bz
			                    FROM rezepte_zutaten
		                       WHERE rezepte_nr =  $rezepte_nr");
							   
		return $liste;
	}
}
?>