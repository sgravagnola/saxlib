<?php
/**
* @name Classe aSaxMail
* @version v1.0.1 03/07/2015
* 
* Rappresenta un generico interfacciamento con le e-mail
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxMail;

use SaxLib\SaxString\SaxString;

/**
* @name aSaxMail
* @abstract true
* 
* Classe astratta che rappresenta la gestione delle e-mail
*/
abstract class aSaxMail
{
	// ATTRIBUTI
	private $smtp;
	private $portaSmtp;
	private $mittente;
	private $destinatario;
	private $oggetto;
	private $testo;
	
	// METODI ASTRATTI
	abstract public function inviaMail();
	
	// METODI PUBBLICI
	// Imposta l'smtp
	public function setSmtp($_smtp)
	{
		try
		{
			$this->smtp = $_smtp;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce l'smtp impostato
	public function getSmtp()
	{
		$ret = '';
	
		try
		{
			$ret = $this->smtp;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	// Imposta la porta dell'smtp
	public function setPortaSmtp($_portaSmtp)
	{
		try
		{
			$this->portaSmtp = $_portaSmtp;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce la porta smtp impostata
	public function getPortaSmtp()
	{
		$ret = '';
	
		try
		{
			$ret = $this->portaSmtp;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Imposta il mittente se è un'indirizzo e-mail valido
	public function setMittente($_mittente)
	{
		try
		{
			if(SaxString::verificaRegular(SaxString::REG_EMAIL, $_mittente))
			{
				$this->mittente = $_mittente;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce il mittente impostato
	public function getMittente()
	{
		$ret = '';
	
		try
		{
			$ret = $this->mittente;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Imposta il destinatario
	public function setDestinatario($_destinatario)
	{
		try
		{
			if(SaxString::verificaRegular(SaxString::REG_EMAIL, $_destinatario))
			{
				$this->destinatario = $_destinatario;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce il destinatario impostato
	public function getDestinatario()
	{
		$ret = '';
	
		try
		{
			$ret = $this->destinatario;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Imposta l'oggetto
	public function setOggetto($_oggetto)
	{
		try
		{
			$this->oggetto = $_oggetto;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce l'oggetto impostato
	public function getOggetto()
	{
		$ret = '';
	
		try
		{
			$ret = $this->oggetto;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Imposta il testo della mail
	public function setTesto($_testo)
	{
		try
		{
			$this->testo = $_testo;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce il testo della mail impostato
	public function getTesto()
	{
		$ret = '';
	
		try
		{
			$ret = $this->testo;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	// METODI PROTETTI
	// Verifica che la mail da inviare sia pronta
	protected function isMailPronta()
	{
		$ret = FALSE;
		
		try
		{
			if(	!is_null($this->smtp) && 
				!is_null($this->mittente) &&
				!is_null($this->destinatario) &&
				!is_null($this->oggetto) &&
				!is_null($this->testo))
			{
				$ret = TRUE;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
}
?>