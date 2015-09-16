<?php
	/**
	* @name Ajax caller
	* @version v1.2.4 03/07/2015
	* 
	* Chiamato tramite ajax, esegue la funzione PHP, dopo aver incluso il file che la contiene.
	* 
	* @author Saverio Gravagnola
	* @link http://www.saveriogravagnola.it
	*/

	use SaxLib\SaxLog\SaxLog;

	define('TENTATIVI_CROSS-DOMAIN_PERMESSI', 3);

	try
	{
		include_once '../include/settaggi/programma.inc.php'; // Settaggi del programma in PHP
		include_once DIR_LAVORO . 'include/lib/saxlib/saxLib.inc.php'; // Includo la libreria SaxLib

		$log = new SaxLog(DIR_LAVORO . DIR_LOG_ERRORI);
		
		// Verifico se si tratta di una chiamata ajax e non di un cross-domain
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// Verifico che ci siano tutti i parametri necessari
			if(isset($_GET['i']) && isset($_GET['f']))
			{
				// Recupero il file da includere e la funzione da chiamare
				$fileDaIncludere = $_GET['i'];
				$funzione = $_GET['f'];
				
				// Gestione degli start e limit nelle chiamate da ExtJs con paginazione
				if(isset($_GET['start']) && isset($_GET['limit']))
				{
					$_POST['start'] = $_GET['start'];
					$_POST['limit'] = $_GET['limit'];
				}
				
				// Gestione del filter nelle chiamate da ExtJs con filtro
				if(isset($_GET['filter']))
				{
					$_POST['filter'] = $_GET['filter'];
				}
				
				// Includo il file contenente la funzione
				include_once DIR_LAVORO . $fileDaIncludere;
				
				if(function_exists($funzione))
				{
					// Chiamo la funzione e ne restituisco la risposta
					echo call_user_func_array($funzione, $_POST);
				}
				else
				{
					$log->scriviLog('Tentativo di chiamata ajax fallito. Funzione inesistente: ' . $funzione);
				}
			}
		}
		else
		{
			session_start();
			
			$log->scriviLog('Tentativo di chiamata a funzioni senza chiamata ajax (probabile cross-domain).');
			
			// Al primo tentativo viene creata la sessione di controllo
			if(empty($_SESSION['cross']))
			{
				$_SESSION['cross'] = 1;
			}
			else
			{
				// Quando i tentativi superano il limite massimo permesso traccio il log ed eseguo l'eventuale ban
				if($_SESSION['cross'] >= TENTATIVI_CROSS-DOMAIN_PERMESSI)
				{
					// INSERIRE QUI LA PROCEDURA DI BAN
					$log->scriviLog('Esecuziona ban per tentativo di cross-domain.');
				}
				else
				{
					$_SESSION['cross']++;
				}
			}
		}
	}
	catch(Exception $ex)
	{
		throw $ex;
	}
?>