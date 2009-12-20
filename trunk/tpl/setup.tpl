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
        
        <h2>MySQL-Setup:</h2>
        <form action="./" method="post">
            
            <label for="host">Host:</label>
            <input id="host" type="text" name="host" value="localhost" />
            
            <label for="user">Benutzer:</label>
            <input id="user" type="text" name="user" value="smail" />
            
            <label for="passwd">Passwort:</label>
            <input id="passwd" type="password" name="passwd" value="" />
            
            <label for="dbname">Datenbank:</label>
            <input id="dbname" type="text" name="dbname" value="smail" />
            
            <input type="submit" value="Speichern" />
        </form>
        
    </body>
</html>