<?php
session_start();
    $mes ='0';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['captcha'] == $_SESSION['cap_code']) {        
            $mes = '1';
        } 
    }
echo $mes;
?>