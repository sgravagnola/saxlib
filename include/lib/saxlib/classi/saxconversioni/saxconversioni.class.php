<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Classe SaxConversioni
	* @version v1.2.1 03/07/2015
	* 
	* @description Gestione delle conversioni
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

	namespace SaxLib\SaxConversioni;

	/**
	* @name SaxConversioni
	* 
	* Gestione delle conversioni
	*/
	final class SaxConversioni
	{
		// COSTRUTTORE
		// Costruttore privato per evitare di far istanziare oggetti (per avere una classe "statica")
		private function __construct() {}
		
		// METODI PUBBLICI STATICI
		// Converte il timestamp passato in un date
		public static function timestampInDate($_timestamp, $_formato = 'r')
		{
			$ret = null;
		
			try
			{
				$ret = date($_formato, $_timestamp);
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Converte il DateTime MySql passato in un timestamp
		public static function mySqlDateTimeInTimeStamp($_dateTime)
		{
			$ret = -1;
		
			try
			{
				$ret = strtotime($_dateTime);
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Converte il timestamp passato in un datetime valido per MySql
		public static function timestampInMySqlDateTime($_timestamp)
		{
			$ret = null;
		
			try
			{
				$ret = date('Y-m-d H:i:s', $_timestamp);
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Converte il date passato con il formato indicato in timestamp
		public static function dateInTimestamp($_data, $_formato)
		{
			$ret = -1;
		
			try
			{
				$tmpTime = date_parse_from_format($_data, $_formato);
				
				$ret = mktime(0, 0, 0, $tmpTime['month'], $tmpTime['day'], $tmpTime['year']);
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Converte il DateTime MySql passato in formato italiano
		public static function mySqlDateTimeInFormatoItaliano($_dateTime)
		{
			$ret = null;
		
			try
			{
				$ret = self::timestampInDate(self::mySqlDateTimeInTimeStamp($_dateTime), 'd/m/Y H:i:s');
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
		
		// Converte il DateTime MySql passato in formato americano
		public static function mySqlDateTimeInFormatoAmericano($_dateTime)
		{
			$ret = null;
		
			try
			{
				$ret = self::timestampInDate(self::mySqlDateTimeInTimeStamp($_dateTime), 'Y/m/d H:i:s');
			}
			catch(Exception $e)
			{
				throw $e;
			}
			
			return $ret;
		}
	}
?>