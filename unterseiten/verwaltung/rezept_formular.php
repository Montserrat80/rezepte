<?php
$string = "$meldung";
$string .= "<form id='rezeptFormular' action='' method='post' enctype='multipart/form-data'>";
		$string .= "<p><label><small><sup>*</sup></small>Bezeichnung </label></p>
					<p><input type='text' name='bezeichnung' maxlength='100' value='".@$this->temp_daten["bezeichnung"]."'></p>";
		$string .= "<p><label><small><sup>*</sup></small>Menüart</label></p>
					<p><select name='menueart_nr'>
					<option value=''></option>";
					foreach($menueart_liste as $menueart)
					{
						if($menueart["menueart_nr"] == @$this->temp_daten["menueart_nr"])
						{
							$string .= "<option  selected value='$menueart[menueart_nr]'>$menueart[menueart_bz]</option>";
						}
						else
						{
							$string .= "<option value='$menueart[menueart_nr]'>$menueart[menueart_bz]</option>";
						}
					}
		$string .=	"</select></p>";
					
		$string .= "<p><label><small><sup>*</sup></small>Schwierigkeitsstufe</label></p>
					<p><select name='schwstufe_nr'>
					<option value=''></option>";
					foreach($schwstufe_liste as $schwstufe)
					{
						if($schwstufe["schwstufe_nr"] == @$this->temp_daten["schwstufe_nr"])
						{
							$string .= "<option selected value='$schwstufe[schwstufe_nr]'>$schwstufe[schwstufe_bz]</option>";
						}
						else
						{
							$string .= "<option value='$schwstufe[schwstufe_nr]'>$schwstufe[schwstufe_bz]</option>\n";
						}
					}
		$string .= "</select></p>";
							
		$string .= "<p><label><small><sup>*</sup></small>Arbeitzeit<small> (in minuten)</small></label></p>
					<p><input type='number' name='arbeitzeit' min='5' max='600' step='5' value='".@$this->temp_daten["arbeitzeit"]."'></p>";	
		$string .= "<p><label><small><sup>*</sup></small>Portionen</label></p>
					<p><input type='number' name='portionen' min='1' max='20'  value='".@$this->temp_daten["portionen"]."'></p>";	
		$string .= "<p><label>Zutaten</label></p>
					<p class='bemerkung'>Menge Einheit Zutat, Menge Einheit Zutat, Menge Einheit Zutat</p>
					<p class='bemerkung'>z.B.: 200 g Mehl, 1 TL Bakpulver</p>
					<p><textarea name='zutaten' rows='5' cols='50' 
					onclick=\"document.getElementById('zutatenVereandert').value=1;\">".@$this->zutaten."</textarea></p>";	
				
		$string .= "<p><label><small><sup>*</sup></small>Zubereitung</label></p>
					<p><textarea name='zubereitung' rows='5' cols='50'>".@$this->temp_daten["zubereitung"]."</textarea></p>";		
		$string .= "<p><label>Tipp</label></p>
					<p><textarea name='tipp' rows='5' cols='50' maxlength='500'>".@$this->temp_daten["tipp"]."</textarea></p>";		
		$string .= "<p><label><small><sup>*</sup></small>Kcal <small>(z.B. 560)</small></small></label></p>
					<p><input type='number' name='kcal' min='1' max='900' value='".@$this->temp_daten["kcal"]."'></p>";		
		$string .= "<p><label><small><sup>*</sup></small>Eiweiss <small>(z.B. 10.37)</small></label></p>
					<p><input type='text' name='eiweiss' placeholder='00.00' value='".@$this->temp_daten["eiweiss"]."'></p>";		
		$string .= "<p><label><small><sup>*</sup></small>Fett <small>(z.B. 7.08)</small></label></p>
					<p><input type='text' name='fett' placeholder='00.00' value='".@$this->temp_daten["fett"]."'></p>";		
		$string .= "<p><label><small><sup>*</sup></small>Kohlenhydrate <small>(z.B. 12.23)</small></label></p>
					<p><input type='text' name='kohlenhydrate' placeholder='00.00'value='".@$this->temp_daten["kohlenhydrate"]."'></p>";

		if(!empty($this->temp_daten['bild']))
		{			
			$string .= "<img class = 'imgKlein' src='".PFAD_KORREKTUR."img/".@$this->temp_daten['bild']."'>";	
		}		
		$string .= "<p><label>Bild</label>
					<input type='file' name='bild_upload' multiple/><br />";	

		$string .= "<p><input type='hidden' name='bild' value='".@$this->temp_daten['bild']."'/></p>";
		$string .= "<p><input type='hidden' name='rezepte_nr' value='".@$this->temp_daten["rezepte_nr"]."'/></p>";
		$string .= "<p><input type='hidden' name='zutatenVereandert' id='zutatenVereandert' value='".@$this->zutatenVereandert."'/></p>";
					
		$string .= "<p class='zentrieren'><small><sup>*</sup></small> pflicht</p>
					<p class='zentrieren'><input type='submit' name='rezept_speichern' /></p>";		
					
		$string .= "</form>";
		return $string;
?>