<?php
/**
* @name Classe aSaxInfoUtente
* @version v1.0.1 03/07/2015
* 
* Rappresenta un generico interfacciamento con le informazioni dell'utente
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxInfoUtente;

/**
* @name aSaxInfoUtente
* @abstract true
* 
* Classe astratta che rappresenta le informazioni dell'utente
*/
abstract class aSaxInfoUtente
{
	// ATTRIBUTI
	protected $ip;
	protected $browser;
	protected $userAgent;
	protected $so;
	protected $lingua;
	
	// METODI ASTRATTI
	abstract public function setIp();
	abstract public function setBrowser();
	abstract public function setUserAgent();
	abstract public function setSO();
	abstract public function setLingua();
	
	// METODI PUBBLICI
	// Setta tutte le informazioni dell'utente
	public function setInfoUtente()
	{
		try
		{
			$this->setIp();
			$this->setBrowser();
			$this->setUserAgent();
			$this->setSO();
			$this->setLingua();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce l'ip
	public function getIp()
	{
		$ret = '';
	
		try
		{
			if(is_null($this->ip))
			{
				$this->setIp();
			}
			
			$ret = $this->ip;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Restituisce il browser
	public function getBrowser()
	{
		$ret = '';
	
		try
		{
			if(is_null($this->browser))
			{
				$this->setBrowser();
			}
			
			$ret = $this->browser;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Restituisce lo user agent
	public function getUserAgent()
	{
		$ret = '';
	
		try
		{
			if(is_null($this->userAgent))
			{
				$this->setUserAgent();
			}
			
			$ret = $this->userAgent;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Restituisce il sistema operativo
	public function getSO()
	{
		$ret = '';
	
		try
		{
			if(is_null($this->so))
			{
				$this->setSO();
			}
			
			$ret = $this->so;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Restituisce la lingua
	public function getLingua()
	{
		$ret = '';
	
		try
		{
			if(is_null($this->lingua))
			{
				$this->setLingua();
			}
			
			$ret = $this->lingua;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
}
?>