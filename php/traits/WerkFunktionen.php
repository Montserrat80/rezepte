<?php
namespace php\traits;

trait WerkFunktionen
{	
	public function testNumber($wert)
	{
		if(is_numeric($wert) || ( is_numeric(substr($wert,0,1)) && substr($wert,1,1) == "/" && is_numeric(substr($wert,2,1))))    
		{
			return true; 
		}
		else
		{
			return false; 
		}
		
	}
	public function testEinheit($wert,$einheit_array)
	{
		$einheit_gefunden = "";
		/*
		if(in_array(strtoupper($wert),$einheit_array))
		{
			$einheit_gefunden = $wert;
		}
		
		else
		{
			*/
			$index = 0;
			$procent_gefunden = 0;
			$sim_gefunden = 0;
			while($index < count($einheit_array))
			{	
				$sim = similar_text(strtoupper($wert),strtoupper($einheit_array[$index]),$prozent);
				if(floor($prozent) >= 80 && 
				   (floor($prozent) > $procent_gefunden ||
				    (floor($prozent) == $procent_gefunden && $sim > $sim_gefunden)
				   )
				  )
				{
					$einheit_gefunden = $einheit_array[$index];
					$procent_gefunden = $prozent;
					$sim_gefunden = $sim;
				}
				$index ++;
			}
		#}
		
		return $einheit_gefunden;
	}
}
?>