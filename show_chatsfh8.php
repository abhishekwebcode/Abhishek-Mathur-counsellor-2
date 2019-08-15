<?php
require_once("autoload-fg52/index.php");
$user=getUser();
if ($user==null) {
    echo json_encode(array("success"=>false,"message"=>"Please Log In"));die();
}
$stmt_get=query("select * from users_chats where user_email=?");
$res=select($stmt_get,array("s",$user['email']));
if (sizeof($res)>0) {
    echo json_encode(array("success"=>true,"data"=>$res));die();
} else {
    echo json_encode(array("success"=>true,"data"=>null));die();
}
?>