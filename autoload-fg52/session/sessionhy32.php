<?php
if (isset($_POST['token'])) {session_id($_POST['token']);
session_start();} else {session_start();}
function setUser($user ) {
    $_SESSION['loggeftd6s']="true";
    $_SESSION['user']=$user;
    return true;
}
function getUser() {
    if ($_SESSION['loggeftd6s']=="true") {
        return $_SESSION['user'];
    } else {return false;}
}
function destroy($id=null) {
    if ($id==null) {        session_destroy();} else {    session_destroy($id);}
}
?>