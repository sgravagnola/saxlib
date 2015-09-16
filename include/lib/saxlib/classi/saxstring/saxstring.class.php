<?php
/**
* @name Classe SaxString
* @version v1.1.1 03/07/2015
* 
* Gestione delle stringhe
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxString;

use SaxLib\SaxFileSystem\SaxFileSystem;

/**
* @name SaxString
* 
* Gestione delle stringhe
*/
final class SaxString
{
	// ATTRIBUTI
	// Espressioni regolari per controlli comuni (usate con la funzione verificaRegular)
	const REG_PURO_TESTO = '/^[A-Z]*$/i'; // Solo testo senza numeri o spazi
	const REG_NOME = '/^[A-Z]{3,30}$/i'; // Nome comune di persona
	const REG_COGNOME = '/^[A-Z \']{3,30}$/i'; // Cognome
	const REG_USERNAME = '/^[A-Za-z0-9_]{3,30}$/'; // Username
	const REG_PASSWORD = '/^[A-Za-z0-9!@#$%^&*()_]{6,30}$/'; // Password
	const REG_EMAIL = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/'; // Indirizzo e-mail asd@asd.it
	const REG_TELEFONO = '/^(([0-9]{2,4})+([- .\\\\\/])+)?([0-9]+)$/'; // Numeri di telefono 012(- .\/)345678
	
	// COSTRUTTORE
	// Costruttore privato per evitare di far istanziare oggetti (per avere una classe "statica")
	private function __construct() {}
	
	// METODI PUBBLICI STATICI
	// Cripta la stringa passata
	public static function cripta($_strDaCriptare)
	{
		$ret = '';
	
		try
		{
			$ret = md5($_strDaCriptare);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Verifica il formato della stringa passata con la regular expression indicata
	public static function verificaRegular($_regEx, $_stringa)
	{
		$ret = FALSE;
		
		try
		{
			if (preg_match($_regEx, $_stringa) == 1)
			{
				$ret = TRUE;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Valida i campi passati in base alle regular expression indicate e carica l'eventuale messaggio di errore in un array restituito
	public static function validaCampi($_arrCampi)
	{
		$ret = array();
		
		try
		{
			if(is_array($_arrCampi))
			{
				foreach($_arrCampi as $campo => $attributi)
				{
					if(!self::verificaRegular($attributi['regular'], $attributi['campo']))
					{
						array_push($ret, $attributi['errore']);
					}
				}
			}
			else
			{
				array_push($ret, -1);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Genera una password casuale della lunghezza passata
	public static function generaRandomPassword($_lunghezza = 10)
	{
		$ret = '';
	
		try
		{
			$caratteriDisponibili = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
			
			for($i = 0; $i < $_lunghezza; $i++)
			{
				$ret = $ret . substr($caratteriDisponibili, rand(0, strlen($caratteriDisponibili) -1), 1);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Tronca il testo passato in base alla lunghezza indicata evitando però di tagliare le parole a metà
	public static function getTestoTroncato($_testo, $_lunghezza = 200)
	{
		$ret = array('troncato' => FALSE, 'testo' => $_testo);
		
		try
		{
			if(strlen($_testo) > $_lunghezza)
			{
				$pos = ($_lunghezza - stripos(strrev(substr($_testo, 0, $_lunghezza)), ' '));
				$testoRet = substr($_testo, 0, $pos-1);
				$chr = $testoRet[strlen($testoRet)-1];
				
				if (strpos($chr, '.,!?;:'))
				{
					$testoRet = substr($testoRet, 0, strlen($testoRet)-1);
				}
				
				// Accodo i puntini sospensivi  e completo la struttura da restituire
				$ret['testo'] = $testoRet . "&#8230;";
				$ret['troncato'] = TRUE;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Esegue le sostituzioni passate sul testo recuperato dal file indicato
	public static function getTestoFileReplace($_file, $_arrReplace)
	{
		try
		{
			$ret = SaxFileSystem::leggiFile($_file);
			
			if($ret)
			{
				foreach ($_arrReplace as $chiave => $valore) {
					$ret = str_replace($chiave, $valore, $ret);
				}
			}
			
			return $ret;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	// Recupera il testo puro dall'html passato
	public static function getTestoPuro($_html)
	{
		try
		{
			$testoPuro = str_replace('<br>', '\n', $_html);
			$testoPuro = str_replace('<br />', '\n', $testoPuro);
			$testoPuro = strip_tags($testoPuro);
			
			return $testoPuro;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Rimuove spazi esterni e rende tutto minuscolo il testo passato
	public static function trimLower($_testo)
	{
		try
		{
			return strtolower(trim($_testo));
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
?>