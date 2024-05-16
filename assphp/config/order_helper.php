<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

 define('DB_HOST', "database-1.cjyok84yytm8.us-east-1.rds.amazonaws.com");
 define('DB_USER', "admin");
 define('DB_PASS', "B1234567b");
 define('DB_NAME', "databaseOne");
 define('DB_PORT', "3306");


$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

