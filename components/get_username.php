<?php
    function getUserName() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['name'];
        }
            return "";
    } 
    echo getUserName(); 
?>