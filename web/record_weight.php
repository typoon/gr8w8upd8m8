<?php

if(isset($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $person   = $_POST['person'];
    $weight   = $_POST['weight'];

    if($username == 'dummy' &&
       $password == 'dummy') {


       $db = new SQLite3('weight.db');

       // Yeah yeah, I always try to recreate because I am lazy to check if 
       // the table already exists...
       @$db->exec('create table measurements(id INTEGER PRIMARY KEY AUTOINCREMENT, person STRING, weight REAL, date TEXT)');

       $stmt = $db->prepare('insert into measurements(person, weight, date) values (:person, :weight, datetime())');
       $stmt->bindValue(':person', $person);
       $stmt->bindValue(':weight', $weight);

       $result = $stmt->execute();

       $db->close();

       die("Success");
    }
}

die("Error");
