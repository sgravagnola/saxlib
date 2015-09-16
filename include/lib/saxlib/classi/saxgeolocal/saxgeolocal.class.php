<?php
/**
* @name Classe SaxGeoLocal
* @version v1.0.1 03/07/2015
* 
* Gestione della geolocalizzazione
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxGeoLocal;

/**
* @name SaxGeoLocal
* 
* Gestione della geolocalizzazione
*/
class SaxGeoLocal
{
	// ATTRIBUTI
	private $indirizzo;
	
	// COSTRUTTORE
	public function __construct($_indirizzo)
	{
		try
		{
			$this->setIndirizzo($_indirizzo);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// METODI PUBBLICI
	// Imposta l'indirizzo
	public function setIndirizzo($_indirizzo)
	{
		try
		{
			$this->indirizzo = $_indirizzo;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Restituisce l'indirizzo settato
	public function getIndirizzo()
	{
		try
		{
			return $this->indirizzo;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Recupera con le Google API le coordinate geografiche in formato JSON
	public function getJsonLocalizzazione()
	{
		try
		{
			return file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($this->getIndirizzo()) . "&sensor=true");
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Recupera le informazioni geografiche restituendo un array di oggetti con tutte le posizioni trovate
	public function getLocalizzazione()
	{
		try
		{
			return json_decode($this->getJsonLocalizzazione())->results;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
?>