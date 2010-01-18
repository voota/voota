<?php
 
/*
 * This file is an addon to the symfony package
 */
 
/**
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potentier modified by Karl
 */
 
/**
 *
 * myTabPager class.
 *
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potentier modified by Karl
 */
class myTabPager
{
  private
    $page                   = 1,
    $tab                    = array(),
    $maxPerPage             = 0,
    $lastPage               = 1,
    $nbResults              = 0,
    $objects                = null,
    $cursor                 = 1,
    $parameters             = array(),
    $currentMaxLink         = 1,
    $parameter_holder       = null;
 
  public function __construct($tab, $defaultMaxPerPage = 10)
  {
    $this->setTab($tab);
    $this->setMaxPerPage($defaultMaxPerPage);
    $this->setPage(1);
    $this->parameter_holder = new sfParameterHolder();
  }
 
  public function init()
  {
    $this->setNbResults(count($this->tab));
 
    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }
 
  public function setTab($tab)
  {
      $this->tab = $tab;
  }
 
  public function getTab()
  {
      return $this->tab;
  }
 
  public function getCurrentMaxLink()
  {
    return $this->currentMaxLink;
  }
 
  public function getLinks($nb_links = 5)
  {
    $links = array();
    $tmp   = $this->page - floor($nb_links / 2);
    $check = $this->lastPage - $nb_links + 1;
    $limit = ($check > 0) ? $check : 1;
    $begin = ($tmp > 0) ? (($tmp > $limit) ? $limit : $tmp) : 1;
 
    $i = $begin;
    while (($i < $begin + $nb_links) && ($i <= $this->lastPage))
    {
      $links[] = $i++;
    }
 
    $this->currentMaxLink = $links[count($links) - 1];
 
    return $links;
  }    
 
  public function haveToPaginate()
  {
    return (($this->getPage() != 0) && ($this->getNbResults() > $this->getMaxPerPage()));
  }
 
  public function getCursor()
  {
    return $this->cursor;
  }
 
  public function setCursor($pos)
  {
    if ($pos < 1)
    {
      $this->cursor = 1;
    }
    else if ($pos > $this->nbResults)
    {
      $this->cursor = $this->nbResults;
    }
    else
    {
      $this->cursor = $pos;
    }
  }
 
  public function getObjectByCursor($pos)
  {
    $this->setCursor($pos);
 
    return $this->getCurrent();
  }
 
  public function getCurrent()
  {
    return $this->retrieveObject($this->cursor);
  }
 
  public function getNext()
  {
    if (($this->cursor + 1) > $this->nbResults)
    {
      return null;
    }
    else
    {
      return $this->retrieveObject($this->cursor + 1);
    }
  }
 
  public function getPrevious()
  {
    if (($this->cursor - 1) < 1)
    {
      return null;
    }
    else
    {
      return $this->retrieveObject($this->cursor - 1);
    }
  }
 
  private function retrieveObject($offset)
  {
    return $this->tab[$offset];
  }
 
  public function getResults()
  {
    return array_slice($this->tab,($this->getPage() - 1) * $this->getMaxPerPage(),$this->maxPerPage);
  }
 
  public function getFirstIndice()
  {
    if ($this->page == 0)
    {
      return 1;
    }
    else
    {
      return ($this->page - 1) * $this->maxPerPage + 1;
    }
  }
 
  public function getLastIndice()
  {
    if ($this->page == 0)
    {
      return $this->nbResults;
    }
    else
    {
      if (($this->page * $this->maxPerPage) >= $this->nbResults)
      {
        return $this->nbResults;
      }
      else
      {
        return ($this->page * $this->maxPerPage);
      }
    }
  }
 
  public function getNbResults()
  {
    return $this->nbResults;
  }
 
  private function setNbResults($nb)
  {
    $this->nbResults = $nb;
  }
 
  public function getFirstPage()
  {
    return 1;
  }
 
  public function getLastPage()
  {
    return $this->lastPage;
  }
 
  private function setLastPage($page)
  {
    $this->lastPage = $page;
    if ($this->getPage() > $page)
    {
      $this->setPage($page);
    }
  }
 
  public function getPage()
  {
    return $this->page;
  }
 
  public function getNextPage()
  {
    return min($this->getPage() + 1, $this->getLastPage());
  }
 
  public function getPreviousPage()
  {
    return max($this->getPage() - 1, $this->getFirstPage());
  }
 
  public function setPage($page)
  {
    $page = intval($page);
 
    $this->page = ($page <= 0) ? 1 : $page;
  }
 
  public function getMaxPerPage()
  {
    return $this->maxPerPage;
  }
 
  public function setMaxPerPage($max)
  {
    if ($max > 0)
    {
      $this->maxPerPage = $max;
      if ($this->page == 0)
      {
        $this->page = 1;
      }
    }
    else if ($max == 0)
    {
      $this->maxPerPage = 0;
      $this->page = 0;
    }
    else
    {
      $this->maxPerPage = 1;
      if ($this->page == 0)
      {
        $this->page = 1;
      }
    }
  }
 
  public function getParameterHolder()
  {
    return $this->parameter_holder;
  }
 
  public function getParameter($name, $default = null, $ns = null)
  {
    return $this->parameter_holder->get($name, $default, $ns);
  }
 
  public function hasParameter($name, $ns = null)
  {
    return $this->parameter_holder->has($name, $ns);
  }
 
  public function setParameter($name, $value, $ns = null)
  {
    return $this->parameter_holder->set($name, $value, $ns);
  }
}
 
?>