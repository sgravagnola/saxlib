<?php
/**
* @name Classe aSaxLog
* @version v1.0.1 03/07/2015
* 
* Rappresenta un generico interfacciamento ai log
* 
* @author Saverio Gravagnola
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