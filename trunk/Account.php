<?php

class Account {

    private $name;
    private $password;
    private $exists = false;

    private function __construct($name, $password) {
        $this->name = $name;
        $this->password = $name;
        
        $this->checkForExist();
    }
    
    private function checkForExist() {
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
    
    public function create() {
        $sql = '
            INSERT INTO account
            (id, password)
            VALUES ("'.$name.'", SHA1("'.$password.'"))';
        
        if(!$this->exists()) {
            return mysql_query($sql);
        }
        else {
            return false;
        }
    }
    
    
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
    
    public function getName() {
        return $this->name;
    }
    
} ?>