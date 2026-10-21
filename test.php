<?php
    
    function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    $officeIP='182.183.38.193';
    if($officeIP==getUserIP()){
        echo 'Ip Matched';
    }else{
        echo 'No Ip Matched';
    }
    

?>