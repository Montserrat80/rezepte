<?php
namespace php\classes;
/*
Aufgaben:
-	HTML-Code zur Verfügung stellen
*/
class Webseite
{
	# Eigenschaften
	public $navigationslinks = 'Links';	
	public $seiteninhalt = 'Unbekannt, noch nicht definierter Inhalt';
	public $footerlinks_links = 'Links';
	public $footerlinks_rechts = 'Links';
	
	# Methoden
	public function __construct($linksNavigation,$seiteninhalt,$footerlinks_links,$footerlinks_rechts)
	{
		$this->navigationslinks = $linksNavigation;
		$this->seiteninhalt = $seiteninhalt;
		$this->footerlinks_links = $footerlinks_links;		
		$this->footerlinks_rechts = $footerlinks_rechts;		
	}	

	public function grundgeruest()
	{
		$string = file_get_contents('html/grundgeruest.html');	
		
		$string = str_replace("#NAVIGATION#",$this->navigationslinks,$string);
		$string = str_replace("#FOOTER_LINKS#",$this->footerlinks_links,$string);
		$string = str_replace("#FOOTER_RECHTS#",$this->footerlinks_rechts,$string);
		$string = str_replace("#PATH#",PFAD_KORREKTUR,$string);
		$string = str_replace("#INHALT#",$this->seiteninhalt,$string);
		
		return $string;
	}

	public function __toString()
	{
		return $this->grundgeruest();
	}	
}
?>