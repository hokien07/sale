<?php
    $host = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "saleapp";

    $dbc = mysqli_connect($host,$username, $pass, $dbname);

    //check connect database
    if(!$dbc){
        trigger_error("Không thể kết nối database" . mysqli_connect_error());
    }else {
        //set charset utf-8
        mysqli_set_charset($dbc, 'utf-8');
    }
?>

