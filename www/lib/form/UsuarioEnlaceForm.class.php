<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class UsuarioEnlaceForm extends RelatedEnlaceForm
{
	public function configure(){
	  unset($this['id'], $this['created_at'], $this['updated_at'], $this['sf_guard_user_id'], $this['mostrar']);
	}
}
