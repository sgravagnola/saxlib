/**
	SaxLib
	
	Copyright (C) 2015 Saverio Gravagnola
	
	@name Esempio
	@version v1.0.0 12/07/2015
	
	@description Esempio di utilizzo
	
	@author Saverio Gravagnola
	@link http://www.saveriogravagnola.it
	
	This file is part of SaxLib.
	SaxLib is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	any later version.
	
	SaxLib is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with SaxLib.  If not, see <http://www.gnu.org/licenses/>.
*/

$(document).ready(init);

// Main
function init()
{
	try
	{
		$('#btn_esempio').click(btn_esempio_click);
	}
	catch(errore)
	{
		GestisciErrore(errore);
	}
}

// Clic sul pulsante di esempio
function btn_esempio_click()
{
	try
	{
		var stringaEsempio = $('#txt_esempio').val();
		
		if(stringaEsempio != '')
		{
			ajaxCaller('esempio.func.php', 'getStringa', { parametro: stringaEsempio }, getStringa_success, getStringa_click_error);
		}
		else
		{
			alert("Inserire la stringa di esempio da inviare");
		}
	}
	catch(errore)
	{
		GestisciErrore(errore);
	}
}

// Success della chiamata a getStringa
function getStringa_success(response, request)
{
	try
	{
		alert(response);
	}
	catch(errore)
	{
		GestisciErrore(errore);
	}
}

// Errore nella chiamata a getStringa
function getStringa_click_error(erorre, request)
{
	try
	{
		alert("Errore");
	}
	catch(errore)
	{
		GestisciErrore(errore);
	}
}