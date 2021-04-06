<?php
namespace php\classes;
use php\classes\pdo\Datenbank;

class Rezept
{
    // Eigenschaften
    protected $rezepte_nr = "";            
    public $bezeichnung = "";               
    protected $menueart_nr = "";            // Vorspeisen, Hauptspeisen, Suppen, Kuchen, Smoothies, Tapas ...
	protected $portionen = 4;       	    // rezeptangabe für anzahl personen
	protected $zubereitung = "";    		// Zubereitungsschritte
	protected $tipp = "";      				// Zubereitungsschritte
    protected $schwstufe_nr = 0;  		    // 1 = Einfach, 2 = Mittel, 3 = Schwierig
    protected $arbeitzeit = 5;		        // in min
    protected $kcal;		        
    protected $eiweiss;		        
    protected $fett;		        
    protected $kohlenhydrate;		        
    protected $bild = "";          
    protected $zutaten = "";          
    protected $zutatenListe = [];  			// 1-n Zutat zum Rezept*/
	protected $zutatenVereandert = "";
	protected $zutatenInitialCount = 0;
    protected $temp_daten;					#conté les dades que recollim: de la bd i del formulari quan fem new/bearbeiten, 
											#el formulari per donar d´alta / actualitzar una recepta l´omplim amb les dades que tenim en
											#aquesta variable, son dades temporals fins que les gravem a la bd
	
   # Constructor
    public function __construct($rezepte_nr = null)
    {
		if(!IS_NULL($rezepte_nr))
		{
			$this->rezepte_nr  = $rezepte_nr;
			$this->daten_laden();
		}
    }
	
	#Magische Function
	public function __toString()
	{
		return "test return toString class: Rezept";
	}	
	
	// Methoden
	protected function daten_laden()
	{
		$db = new Datenbank();
		$antwort = $db->lesen("SELECT * FROM rezepte WHERE rezepte_nr ='".$this->rezepte_nr."'");
		#print_r($antwort);
		#die("stop");
		
		if(count($antwort) == 1) # wenn genau eine Antwort
		{
			$this->bezeichnung   = $antwort[0]["bezeichnung"]; 
			$this->menueart_nr   = $antwort[0]["menueart_nr"];
			$this->portionen     = $antwort[0]["portionen"];
			$this->zubereitung   = $antwort[0]["zubereitung"];
			$this->tipp 	     = $antwort[0]["tipp"];
			$this->schwstufe_nr  = $antwort[0]["schwstufe_nr"];
			$this->arbeitzeit    = $antwort[0]["arbeitzeit"];
			$this->kcal          = $antwort[0]["kcal"];   
			$this->eiweiss       = $antwort[0]["eiweiss"];   
			$this->fett        	 = $antwort[0]["fett"];   
			$this->kohlenhydrate = $antwort[0]["kohlenhydrate"];	        
			$this->bild    	   	 = $antwort[0]["bild"];
			$this->zutaten     	 = "";
			$this->zutatenListe = [];
			$this->zutatenVereandert = "";
			
			$this->temp_daten = $antwort[0];
			
			$rezepte_zutaten = new Rezepte_zutaten();
			$this->zutatenListe = $rezepte_zutaten->zutaten_liste_laden($this->rezepte_nr);
			$this->zutatenInitialCount = count($this->zutatenListe);
			
			foreach($this->zutatenListe as $arrayZutaten)
			{
				$this->zutaten .= "$arrayZutaten[menge] $arrayZutaten[einheit_bz] $arrayZutaten[zutaten_bz], ";
			}
			#treiem l ultima coma i espai
			$this->zutaten = substr(trim($this->zutaten),0,-1);
		}
	}
	public function vorschau_user()
	{
		# Wenn im Bild etwas steht und der Ordner mit dem Bild existiert
		if($this->bild != "" && file_exists("img/".$this->bild))
		{
			# aktuelles Bild
			$zeigBild = $this->bild;
		}
		else
		{
			$zeigBild = "dummy.jpg";
		}	

		return "<div id='rezeptContainer'>
					<a href='/".BASIS_PFAD."/rezepteansicht/details/$this->rezepte_nr'>
						<img class='imgRezept' src='".PFAD_KORREKTUR."img/$zeigBild'>
						<p class='infoRezept'>$this->bezeichnung</p>
					</a>
				</div>";
	}
	
	public function vorschau_admin()
	{
		# Wenn im Bild etwas steht und der Ordner mit dem Bild existiert
		if($this->bild != "" && file_exists("img/".$this->bild))
		{
			# aktuelles Bild
			$zeigBild = $this->bild;
		}
		else
		{
			$zeigBild = "dummy.jpg";
		}	

				
		return "<div id='rezeptContainerAdmin'>
					<img class='imgRezeptAdmin' src='".PFAD_KORREKTUR."img/$zeigBild'>
					<p class='zentrieren infoRezept'>$this->bezeichnung</p><br />
					<p class='zentrieren'>
						<span class='simbol'>
							<a href='/".BASIS_PFAD."/adminbereich/rezept_loeschen/$this->rezepte_nr'><i class='fas fa-trash-alt'></i>
							</a>
						</span>
						<span class='simbol'>
							<a href='/".BASIS_PFAD."/adminbereich/rezept_bearbeiten/$this->rezepte_nr'><i class='fas fa-pencil-alt'></i>
							</a>
						</span>
						<a href='/".BASIS_PFAD."/adminbereich/details/$this->rezepte_nr'></i> <i class='fas fa-eye'></i>
						</a>
					</p>
					<br />
				</div>";
	}
	protected function vorlageDetails_fuellen($string, $pfad)
	{
		$db = new Datenbank();
		$menueart = $db->lesen("select * from menue_arten where menueart_nr ='".$this->menueart_nr."'");
		$schwstufe = $db->lesen("select * from schwierigkeitsstufen where schwstufe_nr ='".$this->schwstufe_nr."'");
	
		$string = str_replace("#ZURUECK#", $pfad, $string);
		$string = str_replace("#REZEPTE_NR#", $this->rezepte_nr, $string);
		$string = str_replace("#BEZEICHNUNG#", $this->bezeichnung, $string);
		$string = str_replace("#MENUEART_BZ#", $menueart[0]["menueart_bz"], $string);
		$string = str_replace("#KCAL#", $this->kcal, $string);
		$string = str_replace("#EIWEISS#", $this->eiweiss, $string);
		$string = str_replace("#FETT#", $this->fett, $string);
		$string = str_replace("#KOHLENHYDRATE#", $this->kohlenhydrate, $string);
		$string = str_replace("#ARBEITZEIT#", $this->arbeitzeit, $string);
		$string = str_replace("#SCHWSTUFE_BZ#", $schwstufe[0]["schwstufe_bz"], $string);
		$string = str_replace("#PORTIONEN#", $this->portionen, $string);
		$string = str_replace("#ZUBEREITUNG#", nl2br($this->zubereitung), $string);
		
		# Wenn im Bild etwas steht und der Ordner mit dem Bild existiert
		if($this->bild != "" && file_exists("img/".$this->bild))
		{
			# aktuelles Bild
			$bildWert = $this->bild;
		}
		else
		{
			$bildWert = "dummy.jpg";
		}
		$string = str_replace("#BILD_PFAD#", PFAD_KORREKTUR."img/".$bildWert, $string);
		
		return $string;
	}
	
	public function details_anzeigen()
	{
		$vorlage = file_get_contents("html/rezept_details.html");
		
		#quan mostrem els detalls de les receptes cal saber on hem de tornar, si a la visualitzacio del user o del admin
		$seitenauswahl = SEITENAUSWAHL;
		$liste = explode("/", $seitenauswahl);
		$pfad_zurueck = "";
		if($liste[1] == "rezepteansicht") $pfad_zurueck = "/".BASIS_PFAD."/rezepteansicht";
		if($liste[1] == "adminbereich") $pfad_zurueck = "/".BASIS_PFAD."/adminbereich";
		
		//omplim la plantilla amb les dades de la recepta
		$string = $this->vorlageDetails_fuellen($vorlage, $pfad_zurueck);
		
		//els ingredients ho fem apart pq tenen un format molt diferent a cada presentació (mostrar detalls recepta (aqui), o be mostrar detalls recepta per esborrar-la)
		$zutaten = "";
		if(count($this->zutatenListe) == 0)
		{
			$zutaten = "<p class='zentrieren'>kein Zutat</p>";
		}
		else
		{
			$zutaten .= "<div class='zutatenContainer'>
							<div class='mengeEinheitContainer'>";
							foreach($this->zutatenListe as $arrayZutaten)
							{
								if(empty($arrayZutaten['menge']) and empty($arrayZutaten['einheit_bz']))
								{
									$zutaten .= "<p>&nbsp;</p>";
								}
								else{
									$zutaten .= "<p>$arrayZutaten[menge] $arrayZutaten[einheit_bz]</p>";
								}
							}
							$zutaten .= "</div>";
							$zutaten .= "<div class='zutatenBzContainer'>";
							foreach($this->zutatenListe as $arrayZutaten)
							{
								$zutaten .= "<p>$arrayZutaten[zutaten_bz]</p>";
							}
			$zutaten .= "</div></div>";
		}	
		
		$string = str_replace("#ZUTATEN#", $zutaten, $string);
		
		//el Tipp el mostrem de forma diferent segons cada plantilla
		$tippWert = "";
		if(! empty($this->tipp))
		{
			$tippWert = "<p class='abstand'><span class='ueberschrift2'>Tipp </span>$this->tipp</p>";
		}
		
		$string = str_replace("#TIPP#", $tippWert, $string);
		
		return $string;
	}
	public function loeschen_besteatingen()
	{
		
		if(isset($_POST["rezept_loeschen"]))
		{
			
			if($_POST["rezept_loeschen"] == "NEIN")
			{
				# automatische Weiterleitung zur Verwaltung
				header("Location: /".BASIS_PFAD."/adminbereich");
				# PHP Programm beenden
				exit;
			
			}
			if($_POST["rezept_loeschen"] == "JA")
			{
				return $this->loeschen();
				
			}
		}	
		#Mostrem totes les dades de la recepta i el boto de confirmar la baixa
		$vorlage = file_get_contents("html/rezept_formular_loeschen.html");
		$pfad_zurueck = "/".BASIS_PFAD."/adminbereich";
		
		//omplim la plantilla amb les dades de la recepta
		$string = $this->vorlageDetails_fuellen($vorlage, $pfad_zurueck);
		
		$string = str_replace("#TIPP#", $this->tipp, $string);
		$string = str_replace("#BILD#", $this->bild, $string);
		
		//els ingredients ho fem apart pq tenen un format molt diferent
		$zutaten = "";
		if(count($this->zutatenListe) == 0)
		{
			$zutaten = "kein Zutat";
		}
		else
		{
			foreach($this->zutatenListe as $arrayZutaten)
			{
				$zutaten .= "<p class='tabLinks'>$arrayZutaten[menge] $arrayZutaten[einheit_bz] $arrayZutaten[zutaten_bz]</p>";
			}
			
		}	
		
		$string = str_replace("#ZUTATEN#", $zutaten, $string);
		
		return $string;
	}
	protected function loeschen()
	{
		$string = "<p class='zentrieren'><a class='linkButton' href='/".BASIS_PFAD."/adminbereich'>Zurück</a></p><br /><br />";
		# 1.- Bild löschen, wenn vorhanden
		if(!empty($this->bild) && file_exists("img/".$this->bild))
		{
			# ALTE Bild löschen
			unlink("img/".$this->bild); # datei auf der festplatte löschen
		}	
		$db = new Datenbank();
		
		#2 .- esborro els ingredients de la recepta
		$rueckmeldung = $db->loeschen(" DELETE FROM rezepte_zutaten WHERE rezepte_nr = '$this->rezepte_nr'");
		
		if($rueckmeldung >= 0)
		{
			# 3.- si ha funcionat, esborro la recepta
			$rueckmeldung = $db->loeschen("DELETE FROM rezepte WHERE rezepte_nr = '$this->rezepte_nr'");
		
			#si ha funcionat, mostrem missatge de que ha anat be
			if($rueckmeldung == 1)
			{
				$string .= "<p class='zentrieren meldung2'>Löschen erfolgreich</p><br />";
			}
			else
			{
				$string .= "<p class='zentrieren meldung2'>Löschen fehlgeschlagen</p><br />";
			}	
		}
		else
		{
			$string .= "<p class='zentrieren meldung2'>Löschen fehlgeschlagen</p><br />";
		}
		return $string;
		
	}
	protected function datenFormular_checken()
	{
		$rezepte_nr = "";
		$fehlerMeldung = "";
		
		if(isset($_POST['rezepte_nr']))
		{
			$rezepte_nr = htmlspecialchars($_POST['rezepte_nr']);
		}
		#abans cal volcar les dades que ha entrat l usuari en el formulari en un array temporal, sobre aquesta vble temporal farem el control de correctesa dels camps i tb la utilitzarem per  mostrar les dades en el formulari de la recepta
		$this->temp_daten["bezeichnung"]   =  htmlspecialchars($_POST['bezeichnung']);
		$this->temp_daten["menueart_nr"]   =  htmlspecialchars($_POST['menueart_nr']);
		$this->temp_daten["schwstufe_nr"]  =  htmlspecialchars($_POST['schwstufe_nr']);
		$this->temp_daten["arbeitzeit"]    =  htmlspecialchars($_POST['arbeitzeit']);
		$this->temp_daten["portionen"]     =  htmlspecialchars($_POST['portionen']);
		$this->temp_daten["zubereitung"]   =  htmlspecialchars($_POST['zubereitung']);
		$this->temp_daten["tipp"] 		   =  htmlspecialchars($_POST['tipp']);
		$this->temp_daten["kcal"] 	 	   =  htmlspecialchars($_POST['kcal']);
		$this->temp_daten["eiweiss"] 	   =  htmlspecialchars($_POST['eiweiss']);
		$this->temp_daten["fett"] 		   =  htmlspecialchars($_POST['fett']);
		$this->temp_daten["kohlenhydrate"] =  htmlspecialchars($_POST['kohlenhydrate']);
		$this->temp_daten["bild"] 		   =  htmlspecialchars($_POST['bild']);
		
		#llegim els ingredients dels formulari pero encara no els comprovem
		$this->zutaten = trim($_POST["zutaten"]);
		$this->zutatenVereandert = $_POST["zutatenVereandert"];	
		
		#control de camps obligatoris i format (No tenim en compte els Zutaten)
		$fehlerMeldung = include("unterseiten/verwaltung/checkFelder.php"); 
		
		return $fehlerMeldung;
	}
	protected function formular_zeigen($meldung="")
	{
		$db = new Datenbank();
		$menueart_liste = $db->lesen("select * from menue_arten");
		$schwstufe_liste = $db->lesen("select * from schwierigkeitsstufen");
		
		#mostrem el formulari amb o sense dades. Per donar una rezepte d alta o modificar-la
		#mostrem sempre les dades que tenim en el $this->temp_daten
		#no poso cap action en el formulari pq amb el submit button sempre tornem al lloc on hem carregat el formulari
		return include("unterseiten/verwaltung/rezept_formular.php"); 
	}
	
    public function hinzufuegen()
	{
		$fehlerMeldung = "";
		#si venim del formulari havent premut el boto submit: rezept_speichern
		if(isset($_POST["rezept_speichern"]))
		{
			#echo "<pre>";
			#print_r($_FILES);
			#echo "</pre>";
			$fehlerMeldung = "";
			$fehlerMeldung_zutaten = "";
			$meldung_einheit = "";
			$meldung = "";
			
			#comprovar que les dades del formulari son correctes, aqui no tenim en compte els ingredients
			$fehlerMeldung = $this->datenFormular_checken();
			if(!empty($fehlerMeldung))
			{
				$meldung .= $fehlerMeldung;
			}
			
			#comprovar si el format dels ingredients es correcte, sempe i quan hi hagi hagut modificacions
			#comprovem Menge Einheit Zutat
			$rezepte_zutaten = new Rezepte_zutaten();
			if($this->zutatenVereandert == 1 && !empty(trim($this->zutaten)))
			{
				$fehlerMeldung_zutaten = $rezepte_zutaten->datenFormularFormat_checken($this->zutaten,$meldung_einheit);
			}
			
			if($fehlerMeldung_zutaten < 0)
			{
				if($fehlerMeldung_zutaten == -1 || $fehlerMeldung_zutaten == -3)
				{
					#avisem usuari de que el format dels ingredients no es correcte
					$meldung .= "<p class='meldung'>Das Format im Zutaten Feld ist nicht richtig.<br /></p>";
				}
				if($fehlerMeldung_zutaten == -2 || $fehlerMeldung_zutaten == -3)
				{
					#cal afegir que hi ha alguna einheit que no es permesa
					$meldung .= $meldung_einheit;
				}
			}
			
			#Si NO hi ha Meldung, es a dir esta en blanc, podem gravar les dades a la bd
			if($meldung == "")
			{
				$saveBD_erfolgreich = true;
				
				#insert a la BD. Tabelle Rezepte i posar foto al directri corresponent
				$db = new Datenbank();
				
				#Bild
				if(!empty($_FILES["bild_upload"]["tmp_name"]))
				{
					$quelle = $_FILES["bild_upload"]["tmp_name"];
					$zieldateiname = uniqid().".jpg";
					move_uploaded_file($quelle,"img/".$zieldateiname);
					$this->temp_daten["bild"] = $zieldateiname;
				}
				
				#Dades principals de la recepta
				$rezepte_nr = $db->einfuegen( "INSERT INTO rezepte 
						(bezeichnung, menueart_nr, portionen, zubereitung, tipp, schwstufe_nr, arbeitzeit, kcal, eiweiss, fett, kohlenhydrate, bild)
						VALUES
						(:bezeichnung,:menueart_nr,:portionen,:zubereitung,:tipp,:schwstufe_nr,:arbeitzeit,:kcal,:eiweiss,:fett,
						:kohlenhydrate,:bild)",$this->temp_daten);
				
				if($rezepte_nr == -1 ) 
				{
					$saveBD_erfolgreich = false;
					$meldung  .= "<p class='meldung'>Fehler beim Insert <br /></p>";
				}
				if($rezepte_nr  > 0 )   
				{
					$meldung .= "<p class='meldung'>Die Rezept Daten sind erfolgreich gespeichert. Rezept Nr.: ".$rezepte_nr." <br /></p>";
					
					#anem a guardar els Zutaten
					#gravem els ingredients nomes si han estat modificats
					if($this->zutatenVereandert == 1)
					{
						$fehlerMeldung_zutaten = $rezepte_zutaten->speichern($rezepte_nr,"neu");
					}
					if($fehlerMeldung_zutaten == -1)
						{
							$saveBD_erfolgreich = false;
						}
					else
					{
						$meldung .= $fehlerMeldung_zutaten;
					}
				}
				if($saveBD_erfolgreich)
				{
					#inicialitzo aquestes propietats per tal de poder tornar a mostrar el formulari en blanc per a una nova recepta
					$this->temp_daten = [];
					$this->zutaten = "";
					$this->zutatenVereandert = "";
				}
			
			}
			return $this->formular_zeigen($meldung);
		}
		
		return $this->formular_zeigen();
		
	}
	
	public function bearbeiten()
	{
		#si venim del formulari havent premut el boto submit: rezept_speichern
		if(isset($_POST["rezept_speichern"]))
		{
			$fehlerMeldung = "";
			$fehlerMeldung_zutaten = "";
			$meldung_einheit="";
			$meldung = "";
			
			#comprovar que les dades del formulari son correctes
			$fehlerMeldung = $this->datenFormular_checken();
			if(!empty($fehlerMeldung))
			{
				$meldung .= $fehlerMeldung;
			}
			
			#comprovar si el format dels ingredients es correcte, sempe i quan hi hagi hagut modificacions
			#comprovem Menge Einheit Zutat
			$rezepte_zutaten = new Rezepte_zutaten();
			if($this->zutatenVereandert == 1 && !empty(trim($this->zutaten)))
			{
				#echo "vaig a comprovar el format ingredients";
				$fehlerMeldung_zutaten = $rezepte_zutaten->datenFormularFormat_checken($this->zutaten,$meldung_einheit);
			}
			
			if($fehlerMeldung_zutaten < 0)
			{
				if($fehlerMeldung_zutaten == -1 || $fehlerMeldung_zutaten == -3)
				{
					#avisem usuari de que el format dels ingredients no es correcte
					$meldung .= "<p class='meldung'>Das Format im Zutaten Feld ist nicht richtig. Bitte eingeben: Menge Einheit Zutat<br /></p>";
				}
				if($fehlerMeldung_zutaten == -2 || $fehlerMeldung_zutaten == -3)
				{
					#cal afegir que hi ha alguna einheit que no es permesa
					$meldung .= $meldung_einheit;
				}
			}
			
			#Si NO hi ha Meldung, es a dir esta en blanc, podem gravar les dades a la bd
			if($meldung == "")
			{
				$saveBD_erfolgreich = true;
				
				#Update a la BD. Tabelle Rezepte i comprovar si hi ha canvi de foto
				$db = new Datenbank();
				#if($_FILES["bild"]["size"] > 0) # Anzahl der Bytes vom Upload
				if(!empty($_FILES["bild_upload"]["tmp_name"]))
				{
					# si la recepta ja tenia una foto, cal esborrar-la del directori img
					if(file_exists("img/".$this->temp_daten["bild"]))
					{
						# ALTE Bild löschen
						unlink("img/".$this->temp_daten["bild"]); # datei auf der festplatte löschen
					}
					#posem en el directori img la nova foto a carregar
					$quelle = $_FILES["bild_upload"]["tmp_name"];
					$zieldateiname = uniqid().".jpg";
					move_uploaded_file($quelle,"img/".$zieldateiname);
					$this->temp_daten["bild"] = $zieldateiname;
					
					#actualitzem la bd
					$rows_nr = $db->aktualisieren( "UPDATE rezepte
												       SET bild   = '".$this->temp_daten["bild"]."'	
											         WHERE rezepte_nr = '".$this->temp_daten["rezepte_nr"]."'");
													 
					if($rows_nr == -1 ) 
					{
						$meldung .= "<p class='meldung'>Bild upload fehlgeschlagen <br /></p>";
						$saveBD_erfolgreich = false;
					}
				}
				#actualitzem les dades principals de la recepta
				$rows_nr = $db->aktualisieren("UPDATE rezepte
												  SET bezeichnung   = '".$this->temp_daten["bezeichnung"]."',
													  menueart_nr   = '".$this->temp_daten["menueart_nr"]."',
													  portionen     = '".$this->temp_daten["portionen"]."',
													  zubereitung   = '".$this->temp_daten["zubereitung"]."',
													  tipp 	     = '".$this->temp_daten["tipp"]."',
													  schwstufe_nr  = '".$this->temp_daten["schwstufe_nr"]."',
													  arbeitzeit    = '".$this->temp_daten["arbeitzeit"]."',
													  kcal 	     = '".$this->temp_daten["kcal"]."',
													  eiweiss 		 = '".$this->temp_daten["eiweiss"]."',
												   	  fett 		 = '".$this->temp_daten["fett"]."',
												  	  kohlenhydrate = '".$this->temp_daten["kohlenhydrate"]."'		
											    WHERE rezepte_nr = '".$this->temp_daten["rezepte_nr"]."'");
				if($rows_nr == -1 ) 
				{
					$saveBD_erfolgreich = false;
					$meldung  .= "<p class='meldung'>Fehler beim Update <br /></p>";
				}
				if($rows_nr > 0 ) 
				{
					$meldung .= "<p class='meldung'>Die Rezept Daten sind erfolgreich gespeichert <br /></p>";
				}
				#$rows_nr podria ser 0 en cas de no haver modificat cap dada de la recepta, potser hem modificat nomes els ingredients o res!!!
				if($rows_nr != -1 ) 
				{
						#anem a guardar els Zutaten nomes si han estat modificats
						if($this->zutatenVereandert == 1)
						{
							$fehlerMeldung_zutaten = $rezepte_zutaten->speichern($this->temp_daten["rezepte_nr"],"bearbeiten",$this->zutatenInitialCount);
						}
						
						if($fehlerMeldung_zutaten == -1)
						{
							$saveBD_erfolgreich = false;
						}
						else
						{
							$meldung .= $fehlerMeldung_zutaten;
						}
				}	
				
				if($saveBD_erfolgreich)
				{
					$this->daten_laden();
					#return $this->formular_zeigen($fehlerMeldung );
				}
			}
		
			return $this->formular_zeigen($meldung );
			
			
		}
		return $this->formular_zeigen();
	}
}
?>
