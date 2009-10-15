<?php
class sfGuardTestFunctional extends sfTestFunctional {

  var $username = 'test@voota.es';  
  var $password = '*****';

  public function initialize($hostname = null, $remote = null, $options = array())
  {
    parent::initialize($hostname, $remote, $options);
    $loader = new sfPropelData();
    $loader->loadData($sf_symfony_lib_dir.'/data/fixtures/');
  }

	public function signin() {
  
		try {
  			include("pass.php");
		}
		catch (Exception $e) {
			echo "\n\n\n=======================================================\n";
	    	echo "WARNING: To test correctly you should change the password ". 
	    		"in sfGuardTestFunctional.class.php or create a pass.php file with ".
	    		"something like \$this->password = 'test'; \n";
			echo "==========================================================\n\n\n\n";
		}
  		
		return $this->
			info(sprintf('Signin user using username "%s" and password "*****"', $this->username, $this->password))->
			post('/sfGuardAuth/signin', array('signin' => array('username' => $this->username, 'password' => $this->password,)))->
			isRedirected();
	}
}
?>