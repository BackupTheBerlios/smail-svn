<?php

require_once 'Account.php';

class Group {

    private $name;
    private $description;
    private $level;
    private $exists = false;
    
    public static function LoadAllFromDb($account) {
        $sql = '
            SELECT id AS name, description, g.readInvs,
            g.writeInvs
            FROM `group` g
            JOIN membership m
            ON (g.id=m.group)
            WHERE readInvs=0
            AND g.id NOT IN (
                SELECT `group`
                FROM membership mm
                WHERE mm.account="'.$account.'")';
        
        $arr = array();
        
        if(($rs = mysql_query($sql)) && mysql_num_rows($rs)>0) {
            while($entry = mysql_fetch_assoc($rs)) {
                $arr[] = new Group($entry);
            }
        }
        
        return $arr;
    }
    
    public function __construct($group, Account $account) {
        $this->name = $group;
        $this->account = $account->getName();
        
        $this->checkForExist();
    }
    
    public function create($description, $readInvs, $writeInvs) {
        mysql_query('START TRANSACTION');
        
        $sql = '
            INSERT INTO `group`
            (id, readInvs, writeInvs, description)
            VALUES ("'.$this->name.'", "'.$readInvs.'",
            "'.$writeInvs.'", "'.$description.'")';
        
        if(!mysql_query($sql)) {
            mysql_query('ROLLBACK');
            return false;
        }
        
        $sql = '
            INSERT INTO membership
            (`group`, account, level)
            VALUES ("'.$this->name.'", "'.$this->account.'", "w")';
        
        if(!mysql_query($sql)) {
            mysql_query('ROLLBACK');
            return false;
        }
        
        if(!mysql_query('COMMIT')) {
            return false;
        }
        
        $this->description = $groupArray['description'];
        $this->level = 'w';
        $this->readInvs = $groupArray['readInvs'];
        $this->writeInvs = $groupArray['writeInvs'];
        
        return true;
    }
    
    public function delete() {
        // Transaction
        // table group record mit id löschen
        // table membership records mit id löschen
        // table message records mit id löschen
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getLevel() {
        return $this->level;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function leave() {
        $sql = '
            DROP FROM membership
            WHERE `group`="'.$this->name.'"
            AND account="'.$this->account.'"';
        
        return mysql_query($sql);
    }
    
    private function checkForExist() {
        $sql = '
            SELECT g.id AS name, g.description, m.level, g.readInvs,
            g.writeInvs
            FROM `group` g
            JOIN membership m
            ON (g.id=m.group)
            WHERE g.id="'.$this->name.'"
            AND m.account="'.$this->account.'"';
        
        if(($rs = mysql_query($sql)) && mysql_num_rows($rs) == 1) {
            $groupArray = mysql_fetch_array($rs);
            
            $this->description = $groupArray['description'];
            $this->level = $groupArray['level'];
            $this->readInvs = $groupArray['readInvs'];
            $this->writeInvs = $groupArray['writeInvs'];
            
            return $this->exists = true;
        }
        else {
            return $this->exists;
        }
    }
    
    public function join() {
        if(!$this->exists) {
            return false;
        }
        
        if($this->readInvs>0) {
            return false;
        }
        else {
            $level = 'r';
            
            if($this->writeInvs==0) {
                $level = 'r';
            }
            
            $sql = '
                INSERT INTO membership
                (group, account, level)
                VALUES ("'.$this->name.'",
                "'.$this->account.'", "'.$level.'")';
            
            return mysql_query($sql);
        }
    }
} ?>