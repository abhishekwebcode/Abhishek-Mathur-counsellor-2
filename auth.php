<?php
require_once 'autoload-fg52/index.php';
if ($_POST["VLgwzpatorSCYVqd4kvbV4V9MjVvg3"]!="XQYwhgLethCcLEg6Fc1Kyz0n5G5spm") {
    die();
}
switch ($_POST['intent']) {
    case "signup":
        require_once 'autoload-fg52/auth9dfsf/signupdf98.php';
        signup_native($_POST['name'], $_POST['email'], $_POST['password']);
        break;
    case "login":
        require_once 'autoload-fg52/auth9dfsf/login342f.php';
        login_native($_POST['email'],$_POST['password']);
        break;
    case "google":
        require_once 'autoload-fg52/auth9dfsf/google343wd.php';
        auth_google($_POST['auth_token_google']);
        break;
    case "facebook":
        require_once 'autoload-fg52/auth9dfsf/dsf8facebookkj34FDSG.php';
        auth_facebook($_POST['auth_token_facebook']);
        break;
    default:
        echo json_encode(array(
            "success"=>false,
            "message"=>"Not Yet Implemented")
        ); 
        break;
}
?>