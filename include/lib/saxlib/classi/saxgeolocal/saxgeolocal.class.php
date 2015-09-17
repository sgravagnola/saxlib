<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Classe SaxGeoLocal
	* @version v1.0.1 03/07/2015
	* 
	* @description Gestione della geolocalizzazione
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