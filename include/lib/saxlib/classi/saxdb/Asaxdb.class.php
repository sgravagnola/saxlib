<?php
/**
* @name Classe aSaxDB
* @version v1.0.1 03/07/2015
* 
* Rappresenta un generico interfacciamento a database
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxDB;

/**
* @name aSaxDB
* @abstract true
* 
* Classe astratta di database generico
*/
abstract class aSaxDB
{
	// ATTRIBUTI
	protected $db;
	protected $isTransazioni;
	protected $isStoredProcedure;
	
	// METODI ASTRATTI
	// Apertura e chiusura connessione
	abstract public function apriConnessione($_driver);
	abstract public function chiudiConnessione();
	
	// Transazioni
	abstract public function avviaTransazione();
	abstract public function commitTransazione();
	abstract public function rollbackTransazione();
	
	// Query
	abstract public function eseguiQuery($_query);
	abstract public function eseguiNonQuery($_query);
	abstract public function getRecord($_tabella, $_arrCampi, $_filtro);
	abstract public function inserisciRecord($_tabella, $_arrDati);
	abstract public function eliminaRecord($_tabella, $_filtro);
	
	// ALTRO
	// Restituisce l'ultimo id inserito
	abstract public function getIdentity();
	
	// METODI PUBBLICI
	// Indica se il database è connesso o meno
	public function isConnesso()
	{
		try
		{
			return isset($this->db);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Indica se il database supporta le transazioni
	public function isTransazioni()
	{
		try
		{
			return $this->isTransazioni;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	// Indica se il database supporta le stored procedure
	public function isStoredProcedure()
	{
		try
		{
			return $this->isStoredProcedure;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
?>