<?php
/**
 * @name SaxLib
 * @version v1.1.0 03/07/2015
 * 
 * Libreria di funzioni in PHP.
 * 
 * @author Saverio Gravagnola
 * @link http://www.saveriogravagnola.it
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