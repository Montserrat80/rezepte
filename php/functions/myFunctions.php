<?php
function check_fomat_decimal($wert)
{
	#1 comprovar que es numeric
	#$wert = str_replace(".","",$wert);
	 $number = is_numeric($wert); #trec el . per mirar si el que obtinc es numeric o no
	 if(!$number) return false; #no es un numeric
	
	#haig de mirar que tan els enters com els decimals (si ho han entrat), siguin < 99
	$count=0;
	#miro si hi ha mes d un .
	$count = substr_count($wert,".");
	if($count > 1) return false; #hi ha mes d un punt
		
	if($count == 1) #si han entrat un . (cal mirar que no sigui .nn o be nn.), 
	{
		$tmp=explode(".",$wert);
		if(!$tmp[0] || !$tmp[1])return false; #un des dos camps esta buit
		 
		if($tmp[0])
		{
			if($tmp[0] >99)return false; #primer camp > 99 
		}
			 
		if($tmp[1])
		{
			if($tmp[1] >99)return false; #segon camp > 99  
		}
	}
	else #si no hi ha punt, es a dir han entrat un enter
	{
		if($wert >99)return false; #el valor numeric > 99
	}
	
	return true;
}
?>