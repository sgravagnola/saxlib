<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	*
	* @name SaxLib
	* @version v1.1.0 03/07/2015
	* 
	* @description Libreria di funzioni in PHP.
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
 
	namespace SaxLib;

	function autoloadClassi($_classe) {
		try
		{
			// Rimuovo la prima parte (il namespace base della libreria)
			$arrPercorso = explode('\\', $_classe);
			array_shift($arrPercorso);
			$percorso = implode('/', $arrPercorso);
			
			// Costruisco la posizione dei file di classe della libreria
			$percorsoFile = dirname(__FILE__) . '/classi/' .strtolower($percorso) . '.class.php';
			
			// Carico il file di classe
			if(file_exists($percorsoFile))
			{
				require_once $percorsoFile;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	spl_autoload_register("SaxLib\autoloadClassi");
?>