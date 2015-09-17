<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Classe aSaxInfoUtente
	* @version v1.0.1 03/07/2015
	* 
	* @description Rappresenta un generico interfacciamento con le informazioni dell'utente
	* 
	* @author Saverio Gravagnola
	* @link http://www.saveriogravagnola.it
	* 
	* This file is part of SaxLib.
	* SaxLib is free software: you can redistribute it and/or modify
	* it under the terms of the GNU General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* any later version.
	* 
	* SaxLib is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	* 
	* You should have received a copy of the GNU General Public License
	* along with SaxLib.  If not, see <http://www.gnu.org/licenses/>.
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