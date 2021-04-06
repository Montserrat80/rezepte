<?php
namespace php\classes\mysqli;
/*
Aufgaben:
- Verbindung aufbauen
- Verbindung schließen
- Tabelle auswählen
- Antwort der Datenbank auswerten
- select (Antwort: Die getroffene Auswahl an Datensätze)
- insert (Antwort: Der Primärschlüssel)
- update (Antwort: Die Anzahl der geänderten Datensätze)
- delete (Antwort: Die Anzahl der gelöschten Datensätze)
*/
class Datenbank
{
	public $verbindung;
	public $host = "localhost";
	public $user = "root";
	public $passwort = "";
	public $datenbank = "kochrezepte2";
	
	public function __construct()
	{
		#echo "<h1>Konstruktor wird gestartet (MYSQLI)</h1>";
		$this->verbindung = mysqli_connect($this->host,$this->user,$this->passwort,$this->datenbank);
		$this->sql_abfrage("SET NAMES utf8");		
	}
	public function __destruct()
	{
		#echo "<h1>Destruktor wird gestartet (MYSQLI)</h1>";
		mysqli_close($this->verbindung);
	}
	
	public function sql_abfrage($befehl, $daten = array())
	{
		#$ergebnis = mysqli_query($this->verbindung, $befehl);
		
		# ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
		# Variante 1: nur mit ? Platzhalter
		# Befehl ohne Daten vorbereiten
		/*
		$prepare = $this->verbindung->prepare($befehl);
		if(count($daten) >= 1)
		{
			$prepare->bind_param("s", $daten[0]);	# s = string
			#$prepare->bind_param("s", $daten[1]);
			#$prepare->bind_param("s", $daten[2]);
		}
		# Ausführen
		$prepare->execute();
		*/
		#:p1, :p2, :p2, :p4, :p5
		# VARIANTE 2: mit benannte Platzhalter
		foreach($daten as $schluessel => $wert)
		{
			$daten[$schluessel] = mysqli_real_escape_string($this->verbindung, $wert);
			$befehl = str_replace(":".$schluessel, "'".$wert."'", $befehl);
		}
		#echo "<h1>$befehl</h1>";
		// Senden
		$ergebnis = mysqli_query($this->verbindung, $befehl);		
		return $ergebnis;
	}		
	
	public function einfuegen($befehl, $daten = array())
	{
		$antwort = $this->sql_abfrage($befehl, $daten);	
		if($this->verbindung->insert_id > 0)
		{		
			return $this->verbindung->insert_id; # der neue Primärschlüssel
		}
		else
		{
			echo "Fehler beim Insert:";
			echo $befehl;
		}
	}		
	public function aktualisieren($befehl, $daten = array())
	{
		$antwort = $this->sql_abfrage($befehl, $daten);	
		if($antwort == true)
		{
			$string = "Änderungen erfolgreich:";
			$string .= $antwort->affected_rows."x Datensätze verändert";
			return $string;
		}
		else
		{
			return "Fehler:".$befehl;
		}		
	}	
	public function loeschen($befehl, $daten = array())
	{
		$antwort = $this->sql_abfrage($befehl, $daten);	
		if($antwort == true)
		{
			$string = "Löschen erfolgreich:";
			$string .= $antwort->affected_rows."x Datensätze gelöscht";
			return $string;
		}
		else
		{
			return "Fehler:".$befehl;
		}		
	}	
	public function lesen($befehl, $daten = array())
	{
		$antwort = $this->sql_abfrage($befehl, $daten);	
		$datensaetze = array();
		while($datensatz = mysqli_fetch_assoc($antwort))
		{
			$datensaetze[] = $datensatz;
		}		
		return $datensaetze;		
	}		
}

###################################################
#$db = new Datenbank();
#echo $db->einfuegen("insert into farben (bezeichnung) values('orange2')");
#echo $db->einfuegen("insert into farben (bezeichnung) values(?)", array("orange"));
#echo $db->einfuegen("insert into farben (bezeichnung) values(:farbe)", array("farbe" => "navy1"));
#echo $db->sql_abfrage("insert into farben (bezeichnung) values(:farbe)", array("farbe" => "navy2"));

# Details
#$datensaetze = $db->lesen("select * from farben where bezeichnung=:bezeichnung", 
#array("bezeichnung" => "navy1"));
#echo "<pre>";
#print_r($datensaetze);
#echo "<pre>";
# Zusammenfassung (Statistik)
#$datensaetze = $db->sql_abfrage("select * from farben where bezeichnung=:bezeichnung", 
#array("bezeichnung" => "navy1"));
#echo "<pre>";
#print_r($datensaetze);
#echo "<pre>";
/*

echo $db->einfuegen("insert into farben (bezeichnung) values(?)", array("orange"));
echo $db->einfuegen("insert into farben (bezeichnung) values(:farbe)", array("farbe" => "navy"));

echo $db->aktualisieren("update farben set bezeichnung = 'Orange' where bezeichnung='orange'");
echo $db->loeschen("delete from farben where bezeichnung = 'Orange'");
$datensaetze = $db->lesen("select * from farben where bezeichnung = :farbe", 
								array("farbe" => "navy"));
echo "<pre>";
print_r($datensaetze);
echo "<pre>";


echo $db->einfuegen("insert into farben (bezeichnung, hexwert) values(?,?)", 
array("orange","#fc0"));
*/












?>