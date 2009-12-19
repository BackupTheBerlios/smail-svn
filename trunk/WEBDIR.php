<?php

define(
 'WEBDIR',
 'http://'.str_replace('//','/',$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/')
);

?>
