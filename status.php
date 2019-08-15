<?php
if (isset($_POST['token'])) {
    session_id($_POST['token']);
    session_start();
} else {
    session_start();
}

if ($_SESSION['loggeftd6s']=="true") {
        echo "true";
    } else {echo "false";}
?>