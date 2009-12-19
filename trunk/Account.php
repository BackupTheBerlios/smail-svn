<?php

/**
 * Stores account information and provides access to the database.
 * @author thomas, maikel
 */
class Account {

    private $name;
    private $password;
    private $exists = false;

    public function __construct($name, $password) {
        $this->name = $name;
        $this->password = $password;
    }

    /*
     * TODO:
     * Noch mal zum Konzept wie ich es verstanden habe:
     * 1. Problem: Eine Instanz hat immer einen entsprechenden Datensatz.
     * Um Instanz und Datensatz zu synchronisieren sind verschiedene
     * Funktionen notwendig.
     * 2. Lösung: Wird eine neue Instanz erstellt, wird im Konstruktor
     * geprüft, ob sie bereits existiert. Dies wird von checkForExist() erledigt.
     * Das Ergebnis wird in der Eigenschaft $exists gespeichert. Der
     * Account Manager kann jetzt abfragen, ob der Eintrag existiert.
     * Ist dies nicht der Fall, kann mit dem Aufruf create() der Datensatz
     * erzeugt werden. Außerdem kann der Konstruktor ggf. weitere Informationen
     * nach laden, wenn der Datensatz existiert.
     *
     *
     * Name nicht ganz korrekt: Prüft nicht, ob ein bestimmter Name schon
     * vergeben ist, sondern ob die Name-Passwort-Kombination existiert.
     * Passender Name vielleicht: validate
     * Wird nur für den Login gebraucht.
     *
     * Account anlegen:
     * Beim Einfügen kann immer ein Fehler passieren. Fehlgeschlagenes Einfügen
     * ist aber auch nicht schädlich. Deshalb würde ich mir die vorige Abfrage
     * sparen.
     *
     * Feature für später:
     * Prüfung, ob ein Name vergeben ist, um dies per Javascript direkt im
     * Formular anzeigen zu können.
     */
    
    /**
      * Prueft, ob die Instanz bereits durch einen Datensatz repraesentiert
      * wird.
      *
      * @return boolean
    */
    public function exists() {
        $sql = '
            SELECT COUNT(*)
            FROM account
            WHERE id="'.$this->name.'"
            AND password=SHA1("'.$this->password.'")';

        if(($rs = mysql_query($sql)) && ($exist = mysql_result($rs, 0, 0))) {
            return $this->exists = (bool) $exist;
        }
        else {
            return $this->exists = false;
        }
    }
    
    /**
      * Erstellt einen Datensatz, der die Instanz repraesentiert. Gibt bei
      * Erfolg true, andernfalls false zurueck.
      *
      * @return boolean
    */
    public function create() {
        $sql = '
            INSERT INTO account
            (id, password)
            VALUES ("'.$this->name.'", SHA1("'.$this->password.'"))';
        
        if(!$this->exists() && !$this->existsName()) {
            return mysql_query($sql);
        }
        elseif($this->existsName()) {
            exit('Name existiert bereits!');
        }
        else {
            return false;
        }
    }
    
    /**
      * Prüft, ob der Account-Name bereits existiert.
      *
      * @return boolean
    */
    protected function existsName() {
        $sql = 'SELECT COUNT(*) FROM account WHERE id="'.$this->name.'"';
        
        return (bool) mysql_result(mysql_query($sql), 0, 0);
    }
    
    /**
      * Loescht den Datensatz der Instanz aus der Datenbank, sofern er
      * existiert. Gibt bei Erfolg true, andernfalls false zurueck.
      *
      * @return boolean
    */
    public function delete() {
        $sql = '
            DELETE FROM account WHERE id="'.$this->name.'"
            AND password=SHA1("'.$this->password.'")';

        if($this->exists()) {
            return mysql_query($sql);
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
        return $this->name;
    }

} ?>