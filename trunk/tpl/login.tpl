<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Welcome to Smail</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="global.css" />
    </head>
    <body>
        <h1>Smail</h1>
        <p>Willkommen!</p>
        
        <form action="{$Login}" method="POST">
            <h2>Anmeldung:</h2>
            
            <ul class="error">
                {foreach from=$LOGIN_ERRORS item=error}
                    <li>{$error}</li>
                {/foreach}
            </ul>
            
            <label>Benutzername:</label>
            <input type="text" name="name" />
            
            <label>Passwort:</label>
            <input type="password" name="password" />
            
            <input type="submit" value="Login" />
        </form>
        
        <form action="{$newAccount}" method="POST">
            <h2>Neues Benutzerkonto:</h2>
            
            <ul class="error">
                {foreach from=$NEW_ERRORS item=error}
                    <li>{$error}</li>
                {/foreach}
            </ul>
            
            <label>Benutzername:</label>
            <input type="text" name="name" />
            
            <label>Passwort:</label>
            <input type="password" name="password" />
            
            <label>Bestätigung:</label>
            <input type="password" name="confirm" />
            
            <input type="submit" value="Erstellen" />
        </form>
    </body>
</html>