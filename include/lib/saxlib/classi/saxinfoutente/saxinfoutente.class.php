<?php
/**
* @name Classe SaxInfoUtente
* @version v1.0.1 03/07/2015
* 
* Gestione delle informazioni sull'utente
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxInfoUtente;

require_once "Asaxinfoutente.class.php";

/**
* @name SaxInfoUtente
* 
* Gestione delle informazioni sull'utente
*/
class SaxInfoUtente extends aSaxInfoUtente
{
	// ATTRIBUTI
	private $browserConosciuti = array('msie', 'firefox','chrome', 'safari', 'webkit', 'opera', 'netscape',
	          'konqueror', 'gecko', 'googlebot', 'googlebot-image', 'ask', 'msnbot-products');
	private $soConosciuti = array('linux','mac','win','iphone os');
	
	// METODI PUBBLICI
	// Setta l'IP anche se l'utente usa un proxy server
	public function setIp($_decimale = FALSE)
	{
		try
		{
			if(!empty($_SERVER ['HTTP_CLIENT_IP']))
			{
				$this->ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			elseif(!empty($_SERVER ['HTTP_X_FORWARDED_FOR']))
			{
				$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$this->ip = $_SERVER['REMOTE_ADDR'];
			}
			
			if($_decimale)
			{
				$this->ip = self::ipToDecimale($this->ip);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Setta il browser dell'utente
	public function setBrowser()
	{
		try
		{
	        // Pulisco la stringa dello user agent
	        $userAgent = $this->getUserAgent();
			
	        $patternBrowser = '#(?<browser>' . join('|', $this->browserConosciuti) . ')[/ ]+(?<versione>[0-9]+(?:\.[0-9]+)?)#i';
			
	        // Recupero il browser tra quelli conosciuti
	        if(preg_match_all($patternBrowser, $userAgent, $browserTrovati))
			{
		        // Gestione per chrome in mac
		        if($chiave = array_search('chrome', $browserTrovati['browser']))
				{
					$this->browser = array('nome' => $browserTrovati['browser'][$chiave], 'versione' => $browserTrovati['versione'][$chiave]);
				}
				else
				{
			        // Gestione per gli user agent che hanno più di una frase (ad esempio firefox che ha "Gecko", Opera 7,8 che ha "MSIE", ecc.),
					// Uso l'ultima frase che è quella corretta
			        $i = count($browserTrovati['browser']) -1;
					
			        $this->browser = array('nome' => $browserTrovati['browser'][$i], 'versione' => $browserTrovati['versione'][$i]);
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Setta lo user agent dell'utente
	public function setUserAgent()
	{
		try
		{
			$this->userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Setta il sistema operativo dell'utente
	public function setSO()
	{
		try
		{
	        // Pulisco la stringa dello user agent
	        $userAgent = $this->getUserAgent();

	        // Recupero i dettagli del sistema operativo
	        $patternSO = '#\(.*?(['.join('|', $this->soConosciuti) . '].*?)\)#i';
			
	        if(preg_match($patternSO, $userAgent, $soTrovati) != 0)
	        {
	            $this->so = $soTrovati[1];
	        }
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Setta la lingua del sistema dell'utente
	public function setLingua()
	{
		try
		{
			$this->lingua = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Controlla se la versione del browser dell'utente è successiva a quella passata
	function isVersioneMaggiore($_versioneMinima)
	{
		$ret = FALSE;
		
		try
		{
			$arrBrowser = $this->getBrowser();
			
			$numVersBrowser = floatval($arrBrowser['versione']);
			$numVersMinima = floatval($_versioneMinima);
			
			if($numVersBrowser >= $numVersMinima)
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
	
	// METODI STATICI
	// Converte un indirizzo IP in un decimale con formato decimal(39,0) utile per memorizzarlo in MySQL
	public static function ipToDecimale($_ip)
	{
		$ret = -1;
	
		try
		{
		    // IPv4
		    if (strpos($_ip, ':') === false && strpos($_ip, '.') !== false)
			{
		        $_ip = '::' . $_ip;
		    }

		    // IPv6
		    if (strpos($_ip, ':') !== false)
			{
		        $rete = inet_pton($_ip);
		        $parti = unpack('N*', $rete);

		        foreach ($parti as &$parte)
				{
		                if ($parte < 0)
						{
		                        $parte = bcadd((string) $parte, '4294967296');
		                }

		                if (!is_string($parte))
						{
		                        $parte = (string) $parte;
		                }
		        }

		        $decimale = $parti[4];
				
		        $decimale = bcadd($decimale, bcmul($parti[3], '4294967296')); // 2^32
		        $decimale = bcadd($decimale, bcmul($parti[2], '18446744073709551616')); // 2^64
		        $decimale = bcadd($decimale, bcmul($parti[1], '79228162514264337593543950336')); // 2^96

		        $ret = $decimale;
		    }
			else
			{
				// Notazione decimale
				$ret = $_ip;
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Converte un decimale in un indirizzo IP
	public static function decimaleToIp($_decimale)
	{
		$ret = '';
	
		try
		{
		    // Già è in IPv4 o IPv6
		    if (strpos($_decimale, ':') !== false || strpos($_decimale, '.') !== false)
			{
		        return $_decimale;
		    }

		    // E' in formato decimale
		    $parti = array();
			
		    $parti[1] = bcdiv($_decimale, '79228162514264337593543950336', 0);
		    $_decimale = bcsub($_decimale, bcmul($parti[1], '79228162514264337593543950336'));
			
		    $parti[2] = bcdiv($_decimale, '18446744073709551616', 0);
		    $_decimale = bcsub($_decimale, bcmul($parti[2], '18446744073709551616'));
			
		    $parti[3] = bcdiv($_decimale, '4294967296', 0);
		    $_decimale = bcsub($_decimale, bcmul($parti[3], '4294967296'));
			
		    $parti[4] = $_decimale;

		    foreach ($parti as &$parte)
			{
		        if (bccomp($parte, '2147483647') == 1)
				{
		                $parte = bcsub($parte, '4294967296');
		        }

		        $parte = (int) $parte;
		    }

		    $rete = pack('N4', $parti[1], $parti[2], $parti[3], $parti[4]);
		    $ip = inet_ntop($rete);

		    if (preg_match('/^::\d+.\d+.\d+.\d+$/', $ip))
			{
		        $ret = substr($ip, 2);
		    }
			else
			{
				$ret = $ip;
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