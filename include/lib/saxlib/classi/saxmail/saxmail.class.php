<?php
/**
* @name Classe SaxMail
* @version v1.0.2 03/07/2015
* 
* Gestione delle e-mail
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxMail;

require_once "Asaxmail.class.php";

use SaxLib\SaxString\SaxString;

/**
* @name SaxMail
* 
* Gestione delle e-mail
*/
class SaxMail extends aSaxMail
{
	// ATTRIBUTI
	private $dirAllegati;
	
	// COSTRUTTORE
	public function __construct($_mittente, $_destinatario, $_oggetto, $_testo, $_smtp = NULL, $_portaSmtp = NULL)
	{
		try
		{
			$this->setMittente($_mittente);
			$this->setDestinatario($_destinatario);
			$this->setOggetto($_oggetto);
			$this->setTesto($_testo);
			
			if(!is_null($_smtp))
			{
				$this->setSmtp($_smtp);
			}
			
			if(!is_null($_portaSmtp))
			{
				$this->setPortaSmtp($_portaSmtp);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// METODI PUBBLICI
	// Invia la mail
	public function inviaMail($_allegati = NULL)
	{
		$ret = FALSE;
		
		try
		{
			if($this->isMailPronta())
			{
				ini_set("SMTP", $this->getSmtp());
				
				if(!is_null($this->getPortaSmtp()))
				{
					ini_set("smtp_port", $this->getPortaSmtp());
				}
			
				$boundary1 = 'XXMAILXX' . md5(time()) . 'XXMAILXX';
				$boundary2 = 'YYMAILYY' . md5(time()) . 'YYMAILYY';
				
				// Imposto il mittente
				$mittente = $this->getMittente();
				$headers = "From: $mittente\n";
				$headers .= "MIME-Version: 1.0\n";
				
				// Se ho un allegato adeguo l'header
				if (!is_null($_allegati)){
					$headers .= "Content-Type: multipart/mixed;\n";
					$headers .= " boundary=\"$boundary1\";\n\n";
					$headers .= "--$boundary1\n";
				}
				
				$headers .= "Content-Type: multipart/alternative;\n";
				$headers .= " boundary=\"$boundary2\";\n\n";
				
				// Mail alternativa solo testo
				$html = $this->getTesto();
				$testoPuro = SaxString::getTestoPuro($html);
				
				$body = "--$boundary2\n";
				$body .= "Content-Type: text/plain; charset=utf-8; format=flowed\n";
				$body .= "Content-Transfer-Encoding: 7bit\n\n";
				$body .= "$testoPuro\n";
				
				// Mail html
				$body .= "--$boundary2\n";
				$body .= "Content-Type: text/html; charset=utf-8\n";
				$body .= "Content-Transfer-Encoding: 7bit\n\n";
				$body .= "$html\n\n";
				$body .= "--$boundary2--\n";
				
				// Gestione allegati
				if (!is_null($_allegati)){
					$fileallegato = $this->getDirAllegati() . $_allegati;
					$fp = @fopen($fileallegato, "r");
					
					if ($fp) {
						$data = fread($fp, filesize($fileallegato));	
					}
					
					$curr = base64_encode($data);
					
					$body .= "--$boundary1\n";
					$body .= "Content-Type: application/octet-stream;";
					$body .= "name=\"$_allegati\"\n";
					$body .= "Content-Transfer-Encoding: base64\n\n";
					$body .= "$curr\n";
					$body .= "--$boundary1--\n";
				}
				
				// Tentativo di invio mail
				if(mail($this->getDestinatario(), $this->getOggetto(), $body, $headers)) {
					$ret = TRUE;
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Imposta la directory degli allegati
	public function setDirAllegati($_dirAllegati)
	{
		try
		{
			$this->dirAllegati = $_dirAllegati;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce la directory degli allegati settata
	public function getDirAllegati()
	{
		$ret = '';
	
		try
		{
			$ret = $this->dirAllegati;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
}
?>