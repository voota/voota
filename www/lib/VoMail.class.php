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
class VoMail {
	const MAIL_SERVER = 'ssl://smtp.gmail.com';
	const MAIL_PORT = 465;
	const MAIL_USER = 'no-reply@voota.es';	
	const SPOOL_DIR = '/var/spool/swift';
	
	private static function doSend ($subject, $mailBody, $to, $from, $ret = false , $spoolMe = false) {
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		
		$mailEnabled = sfConfig::get('sf_mail_enabled');
		$mailServer = sfConfig::get('sf_mail_server');
		$mailPort = sfConfig::get('sf_mail_port');
		$mailUser = sfConfig::get('sf_mail_user');
		$mailSpoolDir = sfConfig::get('sf_mail_spool_dir');

		if ($mailEnabled == 'on') {				
			if ($spoolMe){
				$transport = new Swift_SpoolTransport( new Swift_FileSpool( $mailSpoolDir ) );
			}
			else {
				$transport = Swift_SmtpTransport::newInstance($mailServer, $mailPort)
	                    ->setUsername( $mailUser )
	                    ->setPassword( $smtp_pass );
			}
			 		                    
			$mailer = Swift_Mailer::newInstance($transport);
			  
			$message = Swift_Message::newInstance( $subject )
						->setCharset('utf-8')
	  					->setFrom( $from )
	  					->setTo( $to )
	  					->setReplyTo($ret)
	  					->setBody( $mailBody, 'text/html', 'utf-8' )
	  					;
	  		if ($ret) {
	  			$message->setReturnPath($ret);
	  		}
	  		$result = $mailer->send($message);
		}	
	}
	
	public static function send($subject, $mailBody, $to, $from, $spoolMe = false){
		VoMail::doSend ($subject, $mailBody, $to, $from, false , $spoolMe);
	}	
	
	public static function sendWithRet($subject, $mailBody, $to, $from, $ret, $spoolMe = false){
		VoMail::doSend ($subject, $mailBody, $to, $from, $ret , $spoolMe);
	}
	
	public static function flush(){
  		$mailServer = sfConfig::get('sf_mail_server');
		$mailPort = sfConfig::get('sf_mail_port');
		$mailUser = sfConfig::get('sf_mail_user');
		$mailSpoolDir = sfConfig::get('sf_mail_spool_dir');
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		
		
		$transport = Swift_SmtpTransport::newInstance($mailServer, $mailPort)
                    ->setUsername( $mailUser )
                    ->setPassword( $smtp_pass );
				
		$spool = new Swift_FileSpool( $mailSpoolDir );
		
		$spool->flushQueue($transport);
	}
}
