<?php

$dsn = "mysql:host=localhost;dbname=carfectdb";   //national method of setting up sql to my phpcode
$dbuser="root";     
$dbpassword="tatsulok123";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpassword);  //setting up the pdo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); /*Without it: Errors could silently fail or display generic warnings, making debugging difficult.
    With it: You can catch the specific error and respond appropriately in the catch block. */
    } catch (PDOException $e) {
        echo "Query Failed! . $e->getMessage"();   //we use this to display error message if there is any
    }
?>