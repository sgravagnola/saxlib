<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Classe SaxLog
	* @version v1.0.1 03/07/2015
	* 
	* @description Gestione dei log
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

	namespace SaxLib\SaxLog;

	require_once "Asaxlog.class.php";

	use SaxLib\SaxInfoUtente\SaxInfoUtente;
	use SaxLib\SaxFileSystem\SaxFileSystem;

	/**
	* @name SaxLog
	* 
	* Gestione dei log
	*/
	class SaxLog extends aSaxLog
	{
		// ATTRIBUTI
		private $usernameLog;
		
		// COSTRUTTORE
		public function __construct($_dirLog = '', $_usernameLog = 'Non loggato')
		{
			try
			{
				$this->setDirLog($_dirLog);
				$this->usernameLog = $_usernameLog;
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
		// METODI PUBBLICI
		// Scrive il log passato nella directory di log corrente per l'utente settato
		public function scriviLog($_testo)
		{
			$ret = FALSE;
		
			try
			{
				// Recupero l'IP
				$infoUtente = new SaxInfoUtente();
				
				// Gestione cartella che contiene tutti i log
				$posizioneLog = $this->getDirLog() . '/';
				
				// Gestione cartella anno
				$anno = date("Y");
				$posizioneLog .= $anno . "/";
				
				// Gestione cartella mese
				$mese = date("m");
				$posizioneLog .= $mese . "/";
				
				// Creo e riempio il file di log
				$giorno = date("d");
				$data = date("d/m/Y");
				$ora = date("H:i:s");
				
				$stringaLog = $data . "\t" . $ora . "\t" . $this->getUsernameLog() . "\t" . $infoUtente->getIp() . "\t" . $_testo . "#\r\n";
				
				$ret = SaxFileSystem::scriviFile($posizioneLog . $giorno . ".log", $stringaLog);
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Setta l'username dei log
		public function setUsernameLog($_username)
		{
			try
			{
				$this->usernameLog = $_username;
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
		// Restituisce l'username dei log settato
		public function getUsernameLog()
		{
			$ret = '';
		
			try
			{
				$ret = $this->usernameLog;
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
	}
?>