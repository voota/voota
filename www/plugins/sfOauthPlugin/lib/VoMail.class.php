<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * VoMail
 *
 * @package    Voota
 * @subpackage oauth plugin
 * @author     Sergio Viteri
 */
class VoMail {
	private static function doSend ($subject, $mailBody, $to, $from, $ret = false , $spoolMe = false) {
		$mailEnabled = sfConfig::get('app_mail_enabled');
		$mailServer = sfConfig::get('app_mail_server');
		$mailPort = sfConfig::get('app_mail_port');
		$mailUser = sfConfig::get('app_mail_user');
		$mailSpoolDir = sfConfig::get('app_mail_spool_dir');
		$smtp_pass = sfConfig::get('app_mail_smtp_pass');

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
	  					->setBody( $mailBody, 'text/html', 'utf-8' )
	  					;
	  		if ($ret) {
	  			$message->setReplyTo($ret);
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
  		$mailServer = sfConfig::get('app_mail_server');
		$mailPort = sfConfig::get('app_mail_port');
		$mailUser = sfConfig::get('app_mail_user');
		$mailSpoolDir = sfConfig::get('app_mail_spool_dir');
		$smtp_pass = sfConfig::get('app_mail_smtp_pass');		
		
		$transport = Swift_SmtpTransport::newInstance($mailServer, $mailPort)
                    ->setUsername( $mailUser )
                    ->setPassword( $smtp_pass );
				
		$spool = new Swift_FileSpool( $mailSpoolDir );
		
		$spool->flushQueue($transport);
	}
}
