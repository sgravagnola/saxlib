/**
 * @name Esempio
 * @version v1.0.0 12/07/2015
 * 
 * Esempio di utilizzo
 * 
 * @author Saverio Gravagnola
 * @link http://www.saveriogravagnola.it
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