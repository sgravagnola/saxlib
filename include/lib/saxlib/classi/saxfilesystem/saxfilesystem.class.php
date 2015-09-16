<?php
/**
* @name Classe SaxFileSystem
* @version v1.1.1 03/07/2015
* 
* Gestione del filesystem
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxFileSystem;

/**
* @name SaxFileSystem
* 
* Gestione del filesystem
*/
final class SaxFileSystem
{
	// COSTRUTTORE
	// Costruttore privato per evitare di far istanziare oggetti (per avere una classe "statica")
	private function __construct() {}
	
	// METODI PUBBLICI STATICI
	// Crea, se non esiste, la cartella passata
	public static function creaCartella($_cartella)
	{
		$ret = FALSE;
		
		try
		{
			if(!is_dir($_cartella))
			{
				if(mkdir($_cartella))
				{
					$ret = TRUE;
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Crea se non esiste il file passato e accoda o rimpiazza il contenuto con il testo indicato. Se richiesto crea il percorso per creare il file
	public static function scriviFile($_file, $_testo = '', $_metodo = 'a', $_creaPercorso = TRUE)
	{
		$ret = FALSE;
		
		try
		{
			// Se non esiste creo il percorso dove inserire il file
			if($_creaPercorso)
			{
				$arrPercorso = explode('/', $_file);
				$numCartelle = count($arrPercorso);
				$posizione = '';
				
				for($i = 0; $i < $numCartelle-1; $i++)
				{
					$posizione .= $arrPercorso[$i] . '/';
					self::creaCartella($posizione);
				}
			}
			
			// Creo il file
			$file = fopen($_file, $_metodo);
			
			fwrite($file, $_testo);
			
			$ret = fclose($file);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Legge il file indicato
	public static function leggiFile($_file)
	{
		$ret = null;
	
		try
		{
			$ret = file_get_contents($_file);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Restituisce l'attributo da usare come src usando come riferimento l'array passato e controllando l'esistenza dei file in cascata
	public static function getSrc($_arrSrc)
	{
		$ret = '';
		
		try
		{
			foreach($_arrSrc as $src)
			{
				if(@fopen($src, 'r'))
				{
					$ret = $src;
					
					break;
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
}
?>