<?php
    session_start();
    $string = md5(time());
    $string = substr($string, 0, 6);
    
    $_SESSION['cap_code'] = $string;
    
    $img = imagecreatefromjpeg("C:/xampp/htdocs/webMap/img/cap_cha.jpg");
    $background = imagecolorallocate($img, 0 , 0, 0);
    $text_color = imagecolorallocate($img, 255,255,255);
    imagestring($img, 4,40,15, $string, $text_color);
    
    header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);
?>