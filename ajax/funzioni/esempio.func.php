<?php
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