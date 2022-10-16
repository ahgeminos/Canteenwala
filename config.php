<?php

$servername="localhost";
$username="root";
$password="mysql12345";
$dbname="canteenwala";

$conn= new mysqli($servername,$username,$password,$dbname);
$mydate=getdate(date("U"));
?>