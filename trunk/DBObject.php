<?php

abstract class DBObject {

    protected $fields = array();
    protected $error = '';
    protected $queries = array();
    protected $results = array();
    protected $complete = false;
    protected $exists = false;
    
    
    /**
      * Gibt zurück, ob der Datensatz bereits existiert.
      *
      * @return bool
    */
    public function exists() {
        if(!$this->exists) {
            return (bool) $this->getResultsAsArray($this->queries['exists']);
        } else {
            return true;
        }
    }
    
    /**
      * Gibt zurück, ob alle Pflicht Felder einen Wert haben.
      *
      * @return bool
    */
    public function isComplete() {
        if(!$this->complete) {
            return $this->complete = (!in_array(null, $this->fields, true));
        } else {
            return true;
        }
    }
    
    /**
      * Führt eine vordefinierte create-Anfrage an die Datenbank durch.
      * Gibt bei Erfolg true, andernfalls false zurück.
      *
      * @return bool
    */
    public function create() {
        if(!$this->exists()) {
            return $this->enquire($this->quieries['create']);
        } else {
            return true;
        }
    }
    
    /**
      * Führt eine vordefinierte update-Anfrage an die Datenbank durch.
      * Gibt bei Erfolg true, andernfalls false zurück.
      *
      * @return bool
    */
    public function update() {
        if($this->isComplete() && $this->exists()) {
            $this->enquire($this->quieries['update']);
        }
    }
    
    /**
      * Erzeugt ein QuerySet.
      *
      * @param  string       Name des QuerySets
      * @param  string      SQL-Query
      * @param  mix         entweder Array oder Array-Elemente
      *
      * @return bool
    */
    protected function addQuery($type, $sql) {
        if(!is_string($type) || !is_string($sql)) {
            exit('Type und Sql müssen vom Typ String sein!');
        }
        
        if(!is_array(($params = func_get_arg(2)))) {
            $params = array_slice(func_get_args(), 2);
        }
        
        $obj = new QuerySet();
        $obj->add($sql, $params);
        
        $this->queries[$type] = $obj;
    }
    
    /**
      * Führt eine vordefinierte Anfrage an die Datenbank durch.
      * Gibt bei Erfolg true, andernfalls false zurück.
      *
      * @param  QuerySet    das auszuführende QuerySet-Objekt
      *
      * @return bool
    */
    protected function enquire(QuerySet $obj) {
        if(!mysql_query('START TRANSACTION')) {
            return false;
        }
        
        $this->results = array();
        
        for($i=0; $i<$obj->count(); $i++) {
            for($k=0;$k<count($arr1 = $obj->getParams($i)); $k++) {
                $arr2[$k] = $this->fields[$arr1[$k]];
            }
            
            $sql = vsprintf($obj->getQuery($i), $arr2);
            
            if(!($this->results[] = mysql_query($sql))) {
                $this->error = mysql_error();
                mysql_query('ROLLBACK');
                return false;
            }
        }
        
        if(!mysql_query('COMMIT')) {
            return false;
        }
        
        return true;
    }
    
    /**
      * Wandelt die Ergebnisse der letzten Datenbankabfrage mit enquire()
      * in ein assoziatives Array um.
      *
      * @param  QuerySet    das auszuführende QuerySet-Objekt
      *
      * @return bool
    */
    public function getResultsAsArray(QuerySet $obj = null) {
        if(!empty($obj)) {
            $this->enquire($obj);
        }
        
        $return = array();
        
        for($i=0;$i<count($this->results);$i++) {
            if(is_resource(($rs = $this->results[$i]))) {
                $arr = array();
                
                while($row = mysql_fetch_assoc($rs)) {
                    if(count($row)>1) {
                        $arr[] = $row;
                    } else {
                        $arr[] = array_shift($row);
                    }
                }
                
                if(count($arr)>1) {
                    $return[] = $arr;
                } else {
                    $return[] = array_shift($arr);
                }
            }
        }
        
        if(count($return)>1) {
            return $return;
        } else {
            return array_shift($return);
        }
    }
    
    public function getSQLError() {
        return $this->error;
    }
} ?>