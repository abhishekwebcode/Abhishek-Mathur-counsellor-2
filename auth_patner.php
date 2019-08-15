<?php
require_once 'autoload-patnerxc7v6duyfir/index.php';
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
        break;
    default:
        echo json_encode(array(
            "success"=>false,
            "message"=>"Not Yet Implemented")
        );
        break;
}
?>