/**
 * @name SaxLibExtJs
 * @version v1.2.2 03/07/2015
 * 
 * Funzioni utili specifiche per quando è inclusa ExtJs
 * 
 * Requisiti:
 * - Libreria ExtJs caricata in pagina
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
function ajaxCallerExt(fileFunzioni, funzione, parametri, funzSuccess, funzError, tipo, posCaller, posFunzioni)
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

	Ext.Ajax.request({
       url: posAjaxCaller + '?i=' + posFunzioniCaller + fileFunzioni + '&f=' + funzione,
       method: tipo,
	   params: parametri,
	   success: funzSuccess,
       failure: funzError
    });
}