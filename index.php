<?php
	/**
	* 
	* SaxLib
	* 
	* Copyright (C) 2015 Saverio Gravagnola
	* 
	* @name Index
	* @version v1.0.0 03/07/2015
	* 
	* @description Pagina iniziale dell'esempio
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
?>

<?php
	include_once 'include/settaggi/programma.inc.php'; // Settaggi del programma in PHP
?>

<!doctype html>

<html lang="IT">

<head>
	
	<script type="text/javascript" src="js/lib/jquery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/lib/saxLibJQuery.js"></script>
	<script type="text/javascript" src="js/errori/errori.js"></script>
	<script type="text/javascript" src="js/esempio.js"></script>
	
</head>

<body>

	<input type="text" id="txt_esempio" placeholder="Inserire la stringa da inviare" />
	<input type="button" id="btn_esempio" value="Esempio" />
	
</body>

</html>