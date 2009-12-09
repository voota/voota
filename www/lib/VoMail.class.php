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
	
	public static function send($subject, $mailBody, $to, $from, $spoolMe = false){
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		if ($spoolMe){
			$transport = new Swift_SpoolTransport( new Swift_FileSpool( VoMail::SPOOL_DIR ) );
		}
		else {
			$transport = Swift_SmtpTransport::newInstance(VoMail::MAIL_SERVER, VoMail::MAIL_PORT)
                    ->setUsername( VoMail::MAIL_USER )
                    ->setPassword( $smtp_pass );
		}
		 		                    
		$mailer = Swift_Mailer::newInstance($transport);
		  
		$message = Swift_Message::newInstance( $subject )
					->setCharset('utf-8')
  					->setFrom(array( $from ))
  					->setTo(array( $to ))
  					->setBody( $mailBody, 'text/html', 'utf-8' )
  					;
  		$result = $mailer->send($message);
	}	
	
	public static function sendWithRet($subject, $mailBody, $to, $from, $ret, $spoolMe = false){
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		
		if ($spoolMe){
			$transport = new Swift_SpoolTransport( new Swift_FileSpool( VoMail::SPOOL_DIR ) );
		}
		else {
			$transport = Swift_SmtpTransport::newInstance(VoMail::MAIL_SERVER, VoMail::MAIL_PORT)
                    ->setUsername( VoMail::MAIL_USER )
                    ->setPassword( $smtp_pass );
		}
		 		                    
		$mailer = Swift_Mailer::newInstance($transport);
		  
		$message = Swift_Message::newInstance( $subject )
					->setCharset('utf-8')
  					->setFrom(array( $from ))
  					->setTo(array( $to ))
  					->setReturnPath($ret)
  					->setBody( $mailBody, 'text/html', 'utf-8' )
  					;
  		$result = $mailer->send($message);
	}
	
	public static function flush(){
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		$transport = Swift_SmtpTransport::newInstance(VoMail::MAIL_SERVER, VoMail::MAIL_PORT)
                    ->setUsername( VoMail::MAIL_USER )
                    ->setPassword( $smtp_pass );
				
		$spool = new Swift_FileSpool( VoMail::SPOOL_DIR );
		
		$spool->flushQueue($transport);
	}
}
