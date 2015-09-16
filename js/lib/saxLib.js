/**
 * @name SaxLib
 * @version v1.6.2 03/07/2015
 * 
 * Funzioni utili in javascript.
 * 
 * @author Saverio Gravagnola
 * @link http://www.saveriogravagnola.it
 */
 
 /**
 * Espressioni regolari per controlli comuni (usate con la funzione test, es.: REG_PURO_TESTO.test(testo))
 */
var REG_PURO_TESTO = /^[A-Z]*$/i; // Solo testo senza numeri o spazi
var REG_SOLO_NUMERI = /^\d+$/i; // Solo numeri senza testo o spazi
var REG_NOME = /^[A-Z]{3,30}$/i; // Nome comune di persona
var REG_COGNOME = /^[A-Z \']{3,30}$/i; // Cognome
var REG_USERNAME = /^[A-Za-z0-9_]{3,30}$/; // Username
var REG_PASSWORD = /^[A-Za-z0-9!@#$%^&*()_]{6,30}$/; // Password
var REG_EMAIL = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/; // Indirizzo e-mail asd@asd.it
var REG_TELEFONO = /^(([0-9]{2,4})+([- .\\\\\/])+)?([0-9]+)$/; // Numeri di telefono 012(- .\/)345678

/**
 * Valida il campo passato in base alla regular indicata. Restituisce un array con l'eventuale errore indicato
 * 
 * @param campo
 * @param regular
 * @param errore
 * @returns array di errori
 */
function(campo, regular, errore)
{
	// Array dei codici di errore
	var ret = new Array();
	
	// Verifico la regular expression
	if(!regular.test(campo))
	{
		ret.push(errore);
	}
	
	return ret;
}

/**
 * Restituisce un numero casuale nel range passato
 * 
 * @param minimo
 * @param massimo
 * @returns numero casuale
 */
function numeroRandom(minimo, massimo)
{
	var ret = Math.floor((Math.random() * massimo) + minimo);
	
	return ret;
}

/**
 * Sostituisce tutte le occorrenze _strDaCercare con _strDaSostituire nella stringa sorgente _strOrigine
 * 
 * @param _strOrigine
 * @param _strDaCercare
 * @param _strDaSostituire
 * @returns Stringa risultante
 */
function replaceAll(_strOrigine, _strDaCercare, _strDaSostituire) {
    var temp = _strOrigine;
    var indice = temp.indexOf(_strDaCercare);

    // Finchè trovo occorrenze continuo con i replace
    while (indice != -1) {
        temp = temp.replace(_strDaCercare, _strDaSostituire);
        indice = temp.indexOf(_strDaCercare);
    }

    return temp;
}

/**
 * Esegue una chiamata di tipo post/get all'url passato con i parametri indicati
 * 
 * @param _path
 * @param _parametri
 * @param _method
 */
function postGetToUrl(_path, _parametri, _method) {
    _method = _method || "post";
    
    var form = document.createElement("form");
    form.setAttribute("method", _method);
    form.setAttribute("action", _path);
    
    for(var chiave in _parametri) {
        var inputNascosto = document.createElement("input");
        inputNascosto.setAttribute("type", "hidden");
        inputNascosto.setAttribute("name", chiave);
        inputNascosto.setAttribute("value", _parametri[chiave]);
        form.appendChild(inputNascosto);
    }

    document.body.appendChild(form);
    form.submit();
}

/**
 * Recupera il valore della varibile passata in ingresso se presente in querystring
 * 
 * @param _parametro
 * @returns valore della variabile trovato
 */
function getParameter(_parametro) {
	var ret = "";
	var valore = location.search.substring(1).split('&');
    var tp = new Array();
    
    for (var i = 0; i < valore.length; i++) {
        tp = valore[i].split('=');
        
        if (_parametro == tp[0])
    	{
            ret = unescape(tp[1].replace(/\+/g, " "));
    	}
    }
    
    return ret;
}

/**
 * Pulisce una stringa togliendo i caratteri che possono dar fastidio durante una chiamata ajax o simili
 * 
 * @param _stringaDaPulire
 * @returns stringa pulita
 */
function pulisciStringa(_stringaDaPulire) {
    var stringaPulita = _stringaDaPulire.replace(/\'/g, '\\\'');

    return stringaPulita;
}

/**
 * Stampa il testo passato
 * 
 * @param _testo
 */
function stampa(_testo) {
    var finestraStampa = window.open("Stampa");
    
    finestraStampa.document.write(_testo);
    finestraStampa.document.close();
    finestraStampa.focus();
    finestraStampa.print();
    finestraStampa.close();
}

/**
 * Restituisce una data come oggetto Date() a partire da quella in formato italiano
 * 
 * @param _itString
 * @returns oggetto Date() corrispondente al formato italiano passato
 */
function getDateByItString(_itString) {
    var dataSplit = _itString.split("/");

    return new Date(dataSplit[2], eval(dataSplit[1] - 1), dataSplit[0]);    
}

/**
 * Imposta al date passato l'orario indicato
 * 
 * @param oggetto Date
 * @param orario
 * @returns data aggiornata
 */
function settaOrarioDate(date, orario)
{
	date.setHours(orario.getHours());
	date.setMinutes(orario.getMinutes());
	date.setSeconds(orario.getSeconds());
	
	return date;
}

/**
 * Inserisce il separatore delle migliaia ad un intero passato
 * 
 * @param _numero
 * @returns stringa con il separatore delle migliaia
 */
function separaMigliaia(_numero) {
    _numero = Math.round((_numero * 100) / 100);
    
    var tmp = "";
    var num = "" + _numero;
    var $1 = num.length % 3;
    var $2 = Math.floor(num.length / 3);
    
    if ($1 > 0) {
        tmp += num.substring(0, $1) + ".";
        
        for (i = 0; i < $2; i++) {
            tmp += num.substring($1 + (i * 3), ($1 + 3) + (i * 3)) + ".";
        }
    }
    else {
        if ($1 == 0 && $2 > 0) {
            for (i = 0; i < $2; i++) {
                tmp += num.substring(i * 3, 3 + (i * 3)) + ".";
            }
        }
    }
    
    tmp = tmp.substring(0, tmp.length - 1);
    
    return tmp;
}

/**
 * Recupera il testo selezionato nell'elemento passato
 * 
 * @param _idElem
 * @returns testo selezionato
 */
function getSelected(_idElem) {
    var tagPassato = document.getElementById(_idElem);
    var testoSelezionato = '';
    var range = null;
    
    // IE
    if (document.selection) {
    	tagPassato.focus();
    	
        range = document.selection.createRange();
        
        testoSelezionato = range.htmlText;
    }
    // Altri
    else {
        range = (window.getSelection()).getRangeAt(0);
        
        var contenutoRange = range.cloneContents();
        var nuovoSpan = document.createElement("span");
        
        document.body.appendChild(nuovoSpan);
        nuovoSpan.setAttribute('style', 'display: none');
        nuovoSpan.appendChild(contenutoRange);

        testoSelezionato = nuovoSpan.innerHTML;
    }
    
    return testoSelezionato;
}

/**
 * Calcola l'età a partire dalla data di nascita
 * 
 * @param _dataNascita
 * @returns Età calcolata
 */
function calcolaEta(_dataNascita)
{
    var gg = _dataNascita.substring(0,2);
    var mm = _dataNascita.substring(3,5);
    var aa = _dataNascita.substring(6,10);
    var dataconv = mm + "/" + gg + "/" + aa;

    var datanasc = new Date(dataconv);
    var oggi = new Date();
    var mesims = oggi.getTime() - datanasc.getTime();
    var anni = Math.floor((mesims / (1000 * 60 * 60 * 24 * 30.416)/12));

    return anni;
}

/**
 * Cerca l'elemento con l'attributo passato settato al valore indicato all'interno dell'array passato
 * @param array
 * @param attr
 * @param valore
 * @returns elemento trovato
 */
function getElemInArrayByAttr(array, attr, valore)
{
	var elemTrovato = null;

	for(var i = 0; i < array.length; i++)
	{
		if(array[i][attr] == valore)
		{
			elemTrovato = array[i];
			
			break;
		}
	}
	
	return elemTrovato;
}

/**
 * Scrive il cookie con i dati passati
 * @param nomeCookie
 * @param valoreCookie
 * @param durataCookie
 */
function scriviCookie(nomeCookie, valoreCookie, durataCookie)
{
	var scadenza = new Date();
	var adesso = new Date();
	
	scadenza.setTime(adesso.getTime() + (parseInt(durataCookie) * 60000));
	
	document.cookie = nomeCookie + '=' + escape(valoreCookie) + '; expires=' + scadenza.toGMTString() + '; path=/';
}

/**
 * Legge il valore del cookie con il nome passato
 * @param nomeCookie
 * @returns valore del cookie
 */
function leggiCookie(nomeCookie)
{
	var ret = "";

	if (document.cookie.length > 0)
	{
		var inizio = document.cookie.indexOf(nomeCookie + "=");
		
		if (inizio != -1)
		{
			inizio = inizio + nomeCookie.length + 1;
			var fine = document.cookie.indexOf(";",inizio);
			
			if (fine == -1)
			{
				fine = document.cookie.length;
			}
			
			ret = unescape(document.cookie.substring(inizio,fine));
		}
	}
	
	return ret;
}

/**
 * Cancella il cookie con il nome passato
 * @param nomeCookie
 */
function cancellaCookie(nomeCookie)
{
	scriviCookie(nomeCookie, '', -1);
}

/**
 * Verifica che sul browser siano attivi i cookie
 * @returns booleano che indica se i cookie sono attivi o meno
 */
function verificaCookie()
{
	var ret = false;

	scriviCookie('ChkCK', 'ok', 1);

	if(leggiCookie('ChkCK') == 'ok')
	{
		ret = true;
	}
	
	return ret;
}

/**
 * Verifica che se sul browser è attivo firbug
 * @returns booleano che indica se firebug è attivo o meno
 */
function verificaFireBug()
{
	var ret = false;
	
	if( window.console && (console.firebug || console.firebuglite || console.table && /firebug/i.test(console.table()) ))
	{
		ret = true;
	}
	
	return ret;
}

/**
 * Disattiva alcune funzioni di base di firebug
 * @param bloccaConsole
 */
function disattivaFunzioniFirebug()
{
	if (! ('console' in window) || !('firebug' in console)) {
	    var names = ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd', 
			'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'];
	    
		window.console = {};
	    
		for (var i = 0; i < names.length; ++i)
		{
			window.console[names[i]] = function() {};
		}
	}
}

/**
 * Blocca l'oggetto javascript passato
 * @param obj
 */
function bloccaOggetto(obj) {
	Object.freeze(obj); // Blocco l'oggetto principale

	// Ciclo le proprietà per vedere se qualcuna di esse è fa bloccare
	for (prop in obj) {
		if (!obj.hasOwnProperty(prop) || !(typeof obj === "object") || Object.isFrozen(obj)) {
			continue;
		}

		bloccaOggetto(obj[prop]); // Chiamata ricorsiva
	}
}

// Settaggio parametro al document per indicare se il full screen è realizzabile
document.fullscreenAbilitato = document.fullscreenEnabled || document.mozFullScreenEnabled || document.documentElement.webkitRequestFullScreen;

// Esegue il full screen
function eseguiFullScreen() {
	var element = document.documentElement;
	
	if (element.requestFullscreen) {
		element.requestFullscreen();
	}
	else if (element.mozRequestFullScreen) {
		element.mozRequestFullScreen();
	}
	else if (element.webkitRequestFullScreen) {
		element.webkitRequestFullScreen();
	}
}

// Esce dal full screen
function esciFullScreen() {
	if (document.exitFullscreen) {
		document.exitFullscreen();
	}
	else if (document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	}
	else if (document.webkitCancelFullScreen) {
		document.webkitCancelFullScreen();
	}
}