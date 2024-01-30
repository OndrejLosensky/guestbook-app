<?php
echo "<style>
    .logout {
        background-color: red;
        font-size: 20px;
        Color:white;
    }

    .buttonLogout { 
        position:absolute; 
        top:12px; 
        right: 20px;
        border-radius: 5px;
        background-color: transparent;
        border: 0px solid black;
        padding-top: 6px;
        padding-bottom: 6px;
        padding-left: 10px;
        padding-right:10px;
        color:white;
        cursor: pointer;
    }

    .button-link {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        background-color: #3498db;
        color: #fff;
        padding: 10px 15px; 
        border-radius: 5px;
    }


    .button-icon {
        width: 20px;
        height: 20px; 
    }
    </style>";
    echo " <script src='../components/show_password.js'></script>";
    function getUserName() {
        if (isset($_SESSION['user_id'])) {
            echo "<h4>Welcome, {$_SESSION['name']}!</h4>
                 <button class='buttonLogout' onclick='confirmLogout()'> <img src='/GuestBook_GITHUB/assets/logout.png' alt='Icon' class='button-icon'> logout </button>";
        } else {
            echo "<h4>Welcome, Guest!</h4>";
        }
    }
    
?>