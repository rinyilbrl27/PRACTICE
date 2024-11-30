<?php

    $db_server = "127.0.0.1";
    $db_user = "test";
    $db_pass = "";
    $db_name = "record-list";
    $conn = mysqli_connect($db_server,
                            $db_user,
                            $db_pass,
                            $db_name,3309);
    
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
    //Nilagyan ko ng Port yung sa mysqli_connect(server,user,pas,port)
                            
?>