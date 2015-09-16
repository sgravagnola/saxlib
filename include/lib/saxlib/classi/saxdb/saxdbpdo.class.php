<?php
/**
* @name Classe SaxDBPDO
* @version v1.0.4 03/07/2015
* 
* Rappresenta un generico interfacciamento a database tramite PDO
* 
* @author Saverio Gravagnola
*/

namespace SaxLib\SaxDB;

require_once "Asaxdb.class.php";

use PDO;

/**
* @name SaxDBPDO
* 
* Gestione database PDO
*/
class SaxDBPDO extends aSaxDB
{
	// ATTRIBUTI
	private $query_statement;
	
	// COSTRUTTORE
	public function __construct($_driver = 'mysql', $_host = 'localhost', $_utente = '', $_password = '', $_database = NULL, $_porta = NULL, $_isTransazioni = NULL, $_isStoredProcedure = NULL)
	{
		$ret = FALSE;
		
		try
		{
			// Se ho almeno un parametro passato eseguo il tentativo di connessione
			if(func_num_args() > 0)
			{
				$ret = $this->apriConnessione($_driver, $_host, $_utente, $_password, $_database, $_porta, $_isTransazioni, $_isStoredProcedure);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// METODI PUBBLICI
	/*** CONNESSIONE ***/
	// Esegue la connessione al database istanziando l'oggetto PDO interno
	public function apriConnessione($_driver, $_host = 'localhost', $_utente = '', $_password = '', $_database = NULL, $_porta = NULL, $_isTransazioni = TRUE, $_isStoredProcedure = TRUE)
	{
		$ret = FALSE;
		
		try
		{			
			$dns = "$_driver:host=$_host";
			
			// Aggiungo la porta se passata
			if(isset($_porta) && is_int($_porta))
			{
				$dns .= ";port=$_porta";
			}
			
			if(isset($_database) && is_string($_database) && $_database != '')
			{
				$dns .= ";dbname=$_database";
			}
			
			$this->db = new PDO($dns, $_utente, $_password);
			
			// Transazioni supportate o meno
			$this->isTransazioni = $_isTransazioni;
			
			// Stored procedure supportate o meno
			$this->isStoredProcedure = $_isStoredProcedure;
			
			$ret = TRUE;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Chiude la connessione al database
	public function chiudiConnessione()
	{
		$ret = FALSE;
		
		try
		{
			$this->db = NULL;
			
			$ret = TRUE;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	/*** QUERY ***/
	// Esegue una query e ne restituisce il risultato
	public function eseguiQuery($_query = NULL, $_arrParametri = NULL, $_arrColonne = NULL)
	{
		$ret = NULL;
		
		try
		{
			$this->eseguiNonQuery($_query, $_arrParametri);
			
			// Associo le colonne
			$this->collegaColonne($_arrColonne);
			
			// Restituisco lo statement con il risultato della query
			$ret = $this->query_statement;
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Esegue una query senza restituire il risultato ma un booleano che indica se la query è andata a buon fine
	public function eseguiNonQuery($_query = NULL, $_arrParametri = NULL)
	{
		$ret = FALSE;
		
		try
		{
			if($this->setQuery($_query))
			{
				// Associo i parametri alla query
				$this->collegaParametri($_arrParametri);
				
				// Eseguo la query e restituisco il flag di risposta
				$ret = $this->query_statement->execute();
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Recupera dalla tabella passata, in base al filtro, i campi indicati nell'array
	public function getRecord($_tabella, $_arrCampi, $_filtro = '')
	{
		$ret = NULL;

		try
		{
			// Costruisco l'elenco dei campi
			$campi = implode(',' , array_values($_arrCampi));
			
			// Query
			$query = "SELECT $campi FROM $_tabella $_filtro;";
			
			$ret = $this->eseguiQuery($query);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Recupera il primo record trovato con i campi indicati nell'array, dalla tabella passata, in base al filtro
	public function getRecordSingolo($_tabella, $_arrCampi, $_filtro = '')
	{
		$ret = NULL;
		
		try
		{
			$record = $this->getRecord($_tabella, $_arrCampi, $_filtro);
			
			$ret = $record->fetch();
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Inserisce nella tabella indicata un elemento in base all'array passato
	public function inserisciRecord($_tabella, $_arrDati)
	{
		$ret = FALSE;
	
		try
		{
		    // Pulisco tutti i valori
			foreach($_arrDati as $chiave => $valore)
		    {
				$_arrDati[$chiave] = trim($this->db->quote($valore));
		    }
			
			// Costruisco l'elenco dei campi e dei valori
		    $campi = implode(',', array_keys($_arrDati));
		    $valori = implode(',', array_values($_arrDati));
		    
		    // Query
		    $query = "INSERT INTO $_tabella ($campi) VALUES($valori);";
			
		    $ret = $this->eseguiNonQuery($query);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Modifica nella tabella indicata, in base al filtro, i campi passati nell'array
	public function updateRecord($_tabella, $_arrDati, $_filtro = '')
	{
		$ret = NULL;
		
		try
		{
			// Query
			$query = "UPDATE $_tabella SET ";

		    // Ciclo i dati
			$lunghArrDati = count($_arrDati);
			$chiavi = array_keys($_arrDati);
			
			for($i = 0; $i < $lunghArrDati; $i++)
			{
				if($i > 0)
				{
					$query .= ', ';
				}
				
				$query .= $chiavi[$i] . ' = :' . $chiavi[$i];
			}
			
			// Aggiungo il filtro
			$query .= ' ' . $_filtro . ';';
			
			$ret = $this->eseguiNonQuery($query, $_arrDati);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Elimina dalla tabella indicata gli elementi in base al filtro passato
	public function eliminaRecord($_tabella, $_filtro = '')
	{
		$ret = FALSE;
	
		try
		{
		    // Query
			$query = "DELETE FROM $_tabella $_filtro;";
				
		    $ret = $this->eseguiNonQuery($query);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Conta i record della tabella indicata usando la colonna di riferimento ed il filtro passato
	public function contaRecord($_tabella, $_colonnaCount, $_filtro = '')
	{
		$ret = -1;
	
		try
		{
			$record = $this->getRecordSingolo($_tabella, array("COUNT($_colonnaCount) AS totale"), $_filtro);
			
			$ret = $record['totale'];
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	// Restituisce l'ultimo id inserito
	public function getIdentity()
	{
		$ret = -1;
	
		try
		{
			$ret = $this->db->lastInsertId();
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	// Prepara la query da eseguire
	public function setQuery($_query)
	{
		$ret = FALSE;
	
		try
		{
			if(is_string($_query))
			{
				$this->query_statement = $this->db->prepare($_query);
			}
			
			$ret = $this->isSetQuery();
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Verifica se c'è una query settata
	public function isSetQuery()
	{
		$ret = FALSE;
	
		try
		{
			$ret = isset($this->query_statement);
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	/*** TRANSAZIONI ***/
	// Avvia una transazione
	public function avviaTransazione()
	{
		$ret = FALSE;
		
		try
		{
			if($this->isTransazioni())
			{
				$ret = $this->db->beginTransaction();
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Completa la transazione
	public function commitTransazione()
	{
		$ret = FALSE;
		
		try
		{
			if($this->isTransazioni())
			{
				$ret = $this->db->commit();
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}
	
	// Annulla la transazione
	public function rollbackTransazione()
	{
		$ret = FALSE;
		
		try
		{
			$ret = $this->db->rollBack();
		}
		catch(Exception $e)
		{
			throw $e;
		}
		
		return $ret;
	}

	// METODI PRIVATI
	// Collega i parametri passati
	private function collegaParametri($_arrParametri)
	{
		try
		{
			if(is_array($_arrParametri))
			{
				// Ciclo i parametri per settarli
				foreach ($_arrParametri as $parametro => &$valoreParametro) {
				    $this->query_statement->bindParam(":$parametro", $valoreParametro);
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	// Collega le colonne passate
	private function collegaColonne($_arrColonne)
	{
		try
		{
			if(is_array($_arrColonne))
			{
				// Ciclo le colonne per settarle
				for($i = 0; $i < count($_arrColonne); $i++)
				{
					$this->query_statement->bindColumn($i+1, $_arrColonne[$i]);
				}
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
?>