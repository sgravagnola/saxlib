<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Esempio funzioni
	* @version v1.0.0 03/07/2015
	* 
	* @description Esempio di file di funzioni
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

	use SaxLib\SaxLog\SaxLog;

	if(!isset($_SESSION))
	{
		session_start();
	}

	// Restituisce una semplice stringa
	function getStringa($parametro)
	{
		$ret;
		
		try
		{
			$ret = $parametro;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
?>