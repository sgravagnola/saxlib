<?php
	/**
	 * Settaggi riguardanti il programma
	 */

	define('IS_DEBUG', true); // Attiva/Disattiva il debug del progetto
	
	// Tipologia di errori da mostrare in base all'uso in debug o meno
	if(IS_DEBUG)
	{
		define('ERROR_REPORTING', E_ALL);
	}
	else
	{
		define('ERROR_REPORTING', E_STRICT);
	}
	
	define('CHARSET', 'utf-8');
	define('DIR_SITO', '/Tesi/'); // Directory assoluta del progetto
	
	define('DIR_LAVORO', $_SERVER['DOCUMENT_ROOT'] . DIR_SITO); // Directory di lavoro del programma
	
	define('DIR_LOG_OPERAZIONI', 'logOperazioni/'); // Directory dei log delle operazioni effettuate
	define('DIR_LOG_ERRORI', 'logErrori/'); // Directory dei log degli errori
?>