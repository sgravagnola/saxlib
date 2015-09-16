/**
 * @name SaxLibJQuery
 * @version v2.0.3 03/07/2015
 * 
 * Funzioni utili specifiche per quando � inclusa jQuery
 * 
 * Requisiti:
 * - Libreria jQuery caricata in pagina
 * Per le chiamate ajax a funzione:
 * - Gestore ajaxCaller.php presente alla posizione indicata nella variabile posAjaxCaller
 * - Directory con le funzioni chiamate in ajaxCaller alla posizione indicata
 * 
 * @author Saverio Gravagnola
 * @link http://www.saveriogravagnola.it
 */

var posAjaxCaller = 'ajax/ajaxCaller.php'; // Posizione della ajax caller
var posFunzioniCaller = 'ajax/funzioni/'; // Posizione delle funzioni per il caller

/**
 * Esegue una chiamata ajax con i parametri passati usando il caller
 * 
 * @param fileFunzioni file contenente la funzione chiamata
 * @param funzione funzione da chiamare
 * @param parametri parametri da passare (in formato JSON)
 * @param funzSuccess funzione da chiamare al success della chiamata
 * @param funzError funzione da chiamare in caso di errore della chiamata
 * @param tipo tipo di chiamata da eseguire (POST o GET)
 * @param posCaller posizione del caller
 * @param posFunzioni posizione delle funzioni
 */
function ajaxCaller(fileFunzioni, funzione, parametri, funzSuccess, funzError, tipo, posCaller, posFunzioni)
{
	// Gestisco il tipo di chiamata da eseguire diversa da quella di default
	if(!tipo)
	{
		tipo = 'POST';
	}
	
	// Gestisco posizione caller diversa da quella di default
	if(posCaller)
	{
		posAjaxCaller = posCaller;
	}
	
	// Gestisco posizione funzioni diversa da quella di default
	if(posFunzioni)
	{
		posFunzioniCaller = posFunzioni;
	}

	$.ajax({
		url: posAjaxCaller + '?i=' + posFunzioniCaller + fileFunzioni + '&f=' + funzione,
		type: tipo,
		data: parametri,
		success: funzSuccess,
		error: funzError
	});
}

/**
 * Nasconde tutti gli elementi con id presente nell'array e mostra quello con l'id indicato
 * 
 * @param arrIdDaNascondere
 * @param idDaMostrare
 */
function nascondiTuttiTranne(arrIdDaNascondere, idDaMostrare)
{
	$.each(arrIdDaNascondere, function(chiave, valore){
		if(valore != idDaMostrare)
		{
			$('#' + valore).hide();
		}
	});
	
	$('#' + idDaMostrare).show();
}