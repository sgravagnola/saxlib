<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Classe aSaxLog
	* @version v1.0.1 03/07/2015
	* 
	* @description Rappresenta un generico interfacciamento ai log
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

	/**
	* @name aSaxLog
	* @abstract true
	* 
	* Classe astratta che rappresenta la gestione dei log
	*/
	abstract class aSaxLog
	{
		// ATTRIBUTI
		private $dirLog;
		
		// METODI ASTRATTI
		abstract public function scriviLog($_testo);
		
		// METODI PUBBLICI
		// Imposta la directory dei log
		public function setDirLog($_dirLog)
		{
			try
			{
				$this->dirLog = $_dirLog;
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
		// Restituisce la directory dei log settata
		public function getDirLog()
		{
			$ret = '';
		
			try
			{
				$ret = $this->dirLog;
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
	}
?>