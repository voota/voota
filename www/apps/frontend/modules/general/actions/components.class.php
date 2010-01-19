<?php
 function highlightWords($string, $words)
 {
    foreach ( $words as $word )
    {
        $string = str_ireplace(SfVoUtil::stripAccents($word), '<span class="highlight_word">'.$word.'</span>', SfVoUtil::stripAccents($string));
    }
    /*** return the highlighted string ***/
    return $string;
 }
 
 
class generalComponents extends sfComponents
{
  public function executePoliticoResult(){
  	$this->quote = '';
  	$words = explode  ( ' ', $this->q );
  	
  	if (stripos(SfVoUtil::stripAccents($this->obj->getNombre()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getNombre();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getApellidos()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getApellidos();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getAlias()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getAlias();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getBio()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getBio();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getPresentacion()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getPresentacion();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getResidencia()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getResidencia();
  	}
  	else if (stripos(SfVoUtil::stripAccents($this->obj->getFormacion()), SfVoUtil::stripAccents($this->q)) !== FALSE){
  		$this->quote = $this->obj->getFormacion();
  	}
  
  	$this->quote = highlightWords($this->quote, $words);
  }
}
