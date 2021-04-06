<?php
namespace php\traits;

trait LinksNav
{	####Ini - Links Header###########################
	public function url_nav_sublink_erzeugen($seite,$sublink_beschriftung,$bereich)
	{
		return " <li><a href='?seite=$seite&bereich=$bereich'>$sublink_beschriftung</a><li>\n"; 
	}

	public function url_nav_erzeugen($beschriftung, $seite,$sublinks)
	{
		if ($sublinks)
		{
			
			$string = "";
			$string .= "<li><a href='?seite=$seite'>$beschriftung</a>\n"; 
			$string .= "<ul>\n";
			
			foreach($sublinks as $sublink_beschriftung => $bereich)
			{
				$string .= $this->url_nav_sublink_erzeugen($seite,$sublink_beschriftung,$bereich);
			
			}
			return $string."</ul>\n</li>\n";
		}
		else {
			return " <li><a href='$seite'>$beschriftung</a><li>\n"; 
		}
	}

	public function links_nav_erzeugen($array_links,$array_sublinks=[])
	{
		$string = "";
		foreach($array_links as $beschriftung => $seite)
		{
			$string .= $this->url_nav_erzeugen($beschriftung, $seite,$array_sublinks);
			
		}
		return $string;
	}
	####End - Links Header###########################
	####Ini - Links Footer###########################
	public function url_erzeugen($beschriftung, $seite)
	{
		return "<a href='$seite'>$beschriftung</a>\n"; 
	}

	public function links_erzeugen($array_links)
	{
		$string = "";
		foreach($array_links as $beschriftung => $seite)
		{
			$string .= $this->url_erzeugen($beschriftung, $seite);
		}
		return $string;
	}
	####End - Links Footer###########################
}
?>