<?php

require_once 'autoload-patnerxc7v6duyfir/index.php';
$user = getUser();
if (!($user)) {
    echo json_encode(array(
        "success" => false,
        "message" => "Please Log In|Sign Up to continue"
    ));
    die();
} else {
    check();
    $stmt_counsellor_check = query("select * from counsellors whre email = ?");
    $res = select($stmt_counsellor_check, array("s", $user['email']));
    if (sizeof($res) > 0) {
        $stmt_update= query("update counsellors set where email = ?");
        $stmt_update->bind_param("s",$user['email']);
        $e=$stmt_update->execute();
        $res=$stmt_update->fetch_results();
    } else {
        $stmt_counsellor_insert = query("insert into");
    }
}
?>