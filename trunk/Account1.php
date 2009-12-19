<?php

require_once 'DBObject.php';
require_once 'QuerySet.php';

/**
 * Stores account information and provides access to the database.
 * @author thomas, maikel
 */
class Account extends DBObject {
    
    private $existsName = false;
    
    
    public function __construct($name, $password) {
        $sql = '
            SELECT COUNT(*)
            FROM account
            WHERE name="%s"
            AND password=SHA1("%s")';
        
        $this->addQuery('exists', $sql, 'name', 'password');
        
        $sql = '
            INSERT INTO account
            (name, password)
            VALUES ("%s", SHA1("%s"))';
        
        $this->addQuery('create', $sql, 'name', 'password');
        
        $sql = '
            SELECT COUNT(*)
            FROM account
            WHERE name="%s"';
        
        $this->addQuery('existsName', $sql, 'name');
        
        $sql = '
            DELETE FROM account
            WHERE name="%s" AND password=SHA1("%s")';
        
        $this->addQuery('delete', $sql, 'name', 'password');
        
        
        $this->fields = array(
            'name' => $name,
            'password' => $password
        );
    }
    
    /**
      * Erstellt einen Datensatz, der die Instanz repraesentiert. Gibt bei
      * Erfolg true, andernfalls false zurueck.
      *
      * @return boolean
    */
    public function create() {
        if(!$this->exists() && !$this->existsName()) {
            return $this->enquire($this->queries['create']);
        }
        elseif($this->existsName()) {
            echo 'Name existiert bereits!';
        }
        else {
            return true;
        }
    }
    
    /**
      * Prüft, ob der Account-Name bereits existiert.
      *
      * @return boolean
    */
    protected function existsName() {
        if(!$this->existsName) {
            return (bool) $this->getResultsAsArray($this->queries['existsName']);
        } else {
            return true;
        }
    }
    
    /**
      * Loescht den Datensatz der Instanz aus der Datenbank, sofern er
      * existiert. Gibt bei Erfolg true, andernfalls false zurueck.
      *
      * @return boolean
    */
    public function delete() {
        if($this->exists()) {
            return $this->enquire($this->queries['delete']);
        }
        else {
            return false;
        }
    }
    
    /**
      * Gibt den Namen des Accounts zurueck.
      *
      * @return string
    */
    public function getName() {
        return $this->fields['name'];
    }
} ?>