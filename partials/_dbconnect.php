<?php
    $server="localhost";
    $username="root";
    $password="";
    $database="idiscuss";
    $conn=mysqli_connect($server,$username,$password,$database);

    if(!$conn){
        die("cant connect to this db".mysqli_error($conn));
    }
    else{
        // echo "connected";
    }
?>