<?php
namespace php\classes;
use php\classes\pdo\Datenbank;
/*
Aufgaben:
-	Benutzerinterkation auswerten
-	Unterseite auswählen
*/
class Navigation
{
	protected $linksNavigation = array("Startseite" =>"/".BASIS_PFAD."",
									   "Rezepte"    =>"/".BASIS_PFAD."/rezepteansicht");	
									   
	protected $linksFooter_links = array("Impressum" => "/".BASIS_PFAD."/impressumseite",
										 "Kontakt"   => "/".BASIS_PFAD."/kontaktseite");	
										 
	protected $linksFooter_rechts = array("Datenschutz" => 	"/".BASIS_PFAD."/datenschutzseite");	
	public $seiteninhalt = "leer";

	#Traits
	use \php\traits\LinksNav;

	# Methoden
	public function __construct()
	{
		$this->linkauswertung();
	}
	
	protected function linkauswertung()
	{
		# Loginauswertung
		if(isset($_POST["anmelden"]))
		{
			$db = new Datenbank();
			#print_r($_POST);
			$antwort = $db->lesen("select * from users where benutzername='".$_POST["benutzer"]."'");
			
			#print_r($antwort);
			if(count($antwort) == 1)
			{
				if(password_verify($_POST["pwd"], $antwort[0]["passwort"]))
				{
					$_SESSION["benutzer"] = $_POST["benutzer"];
					$_SESSION["login_erfolgreich"] = true;
					$_SESSION["admin"] = $antwort[0]["admin"];
					# automatische Weiterleitung zur Verwaltung
					header("Location: /".BASIS_PFAD."/adminbereich");
					# PHP Programm beenden
					exit;
				}
				else
				{
					$_SESSION["login_erfolgreich"] = false;
				}
			}
			else
			{
				$_SESSION["login_erfolgreich"] = false;
			}
		}
		# Logoutvorgang
		if(isset($_POST["abmeldenBesteatig"]))
		{
			unset($_SESSION["benutzer"]);
			unset($_SESSION["login_erfolgreich"]);			
			unset($_SESSION["admin"]);	
			# automatische Weiterleitung zur Verwaltung
			header("Location: /".BASIS_PFAD.""); #anem a la startseite
			# PHP Programm beenden
			exit;			
		}
		# dynamische Links anzeuigen, je nach Loginzustand
		if(isset($_SESSION["login_erfolgreich"] ) && $_SESSION["login_erfolgreich"])
		{
			if($_SESSION["admin"] == 1)
			{
				$this->linksNavigation["Admin Bereich"] = "/".BASIS_PFAD."/adminbereich";
				$this->linksNavigation["Abmelden"] = "/".BASIS_PFAD."/abmeldenseite";
			}
			else{
				$this->linksNavigation["Abmelden"] = "/".BASIS_PFAD."/abmeldenseite";
			}
			
		}
		else
		{
			$this->linksNavigation["Anmelden"] = "/".BASIS_PFAD."/anmeldenseite";
		}
		
		$seitenauswahl = SEITENAUSWAHL;
		
		$liste = explode("/", $seitenauswahl);
		#print_r($liste);
		if(
			($liste[1] == "rezepteansicht" || $liste[1] == "adminbereich")
			&&
			isset($liste[2])
			&&
			(
			$liste[2] == "details" || 
			$liste[2] == "rezept_bearbeiten" || 
			$liste[2] == "rezept_loeschen"
			)
		)
		{
			$seitenauswahl = "/".$liste[1]."/".$liste[2];
			if(isset($liste[3]))
			{
				$_POST["rezepte_nr"] = htmlspecialchars($liste[3]);
			}
		}
		
		switch($seitenauswahl)
		{
			case "/":				 $this->startseite();		break;
			case "/rezepteansicht":	 $this->rezepteZeigen();	break;
			case "/rezepteansicht/details":	 $this->rezeptDetailsZeigen();	break;
			case "/anmeldenseite":	 $this->anmelden();			break;
			case "/abmeldenseite":	 $this->abmelden();			break;
			case "/adminbereich":
				if(isset($_SESSION["login_erfolgreich"] ) && $_SESSION["login_erfolgreich"] )	
				{ 
					if($_SESSION["admin"] == 1) $this->adminbereich("");	
					else $this->startseite();
					#si es un usuari NO admin, no pot entrar en l´adminbereich pero no cal que li tornem a mostrar
					#la pantalla de login (anmelden), l´envio a l startseite
				}
				else
				{
					$this->anmelden();
				}
				break;
			case "/adminbereich/rezept_hinzufuegen"	: $this->adminbereich("hinzufuegen"); break;
			case "/adminbereich/rezept_bearbeiten"	: $this->adminbereich("bearbeiten");  break;
			case "/adminbereich/rezept_loeschen"	: $this->adminbereich("loeschen");    break;
			case "/adminbereich/details"			: $this->adminbereich("details");	  break;
			case "/registrieren":	 $this->registrieren();		break;
			case "/impressumseite":	 $this->impressum();		break;	
			case "/datenschutzseite":$this->datenschutz();		break;					
			case "/kontaktseite":	 $this->kontakt();			break;			
			
			default:
				$this->seiteninhalt = "404 - Seite nicht gefunden";
		}	
					
		echo new Webseite($this->links_nav_erzeugen($this->linksNavigation),
						  $this->seiteninhalt, 
						  $this->links_erzeugen($this->linksFooter_links),
						  $this->links_erzeugen($this->linksFooter_rechts)
						 );# toString Methode de la classe Webeite!!!
	
	}	
	protected function startseite()
	{
		include("unterseiten/startseite.php");
	}	
	protected function rezepteZeigen()
	{
		include("unterseiten/rezepte.php");
	}	
	protected function rezeptDetailsZeigen()
	{
		include("unterseiten/rezept_details.php");
	}
	protected function anmelden()
	{
		$meldung = "";
		if(isset($_SESSION["login_erfolgreich"]) && !$_SESSION["login_erfolgreich"])
		{
			$meldung = "Benutzarname / Passwort ist falsch";
			unset($_SESSION["login_erfolgreich"]);
		}
		include("unterseiten/anmelden.php");
	}
	protected function abmelden()
	{
		include("unterseiten/abmelden.php");
	}
	protected function adminbereich($modus)
	{
		#si es un usuari NO admin, no pot entrar en l´adminbereich pero no cal que li tornem a mostrar
		if(isset($_SESSION["login_erfolgreich"] ) && $_SESSION["login_erfolgreich"] )	
		{ 
			switch($modus)
			{
				case ""				: include("unterseiten/verwaltung/adminbereich.php");		break;
				case "hinzufuegen"	: include("unterseiten/verwaltung/rezept_hinzufuegen.php");	break;
				case "bearbeiten"	: include("unterseiten/verwaltung/rezept_bearbeiten.php");	break;
				case "loeschen"		: include("unterseiten/verwaltung/rezept_loeschen.php");	break;
				case "details"		: include("unterseiten/rezept_details.php");				break;
			}
		}
		else
		{
			$this->seiteninhalt =  "<p class='zentrieren meldung2'>Access denied!</p>";
		}	
	}
	
	protected function registrieren()
	{
		include("unterseiten/registrieren.php");
	}
	protected function impressum()
	{
		include("unterseiten/impressum.php");
	}	
	protected function kontakt()
	{
		include("unterseiten/kontakt.php");
	}	
	protected function datenschutz()
	{
		include("unterseiten/datenschutz.php");
	}	
}
?>