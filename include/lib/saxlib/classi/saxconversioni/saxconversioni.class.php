<?php
/**
* @name Classe SaxConversioni
* @version v1.2.1 03/07/2015
* 
* Gestione delle conversioni
* 
* @author Saverio Gravagnola
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