<?php
error_reporting(E_ALL);
require_once("autoload-fg52/index.php");
$user=getUser();
if ($user==null) {
    echo json_encode(array("success"=>false,"messsage"=>"You are not Logged In.Kindly SIGNUP|LOGIN.","login"=>true));
    die();
}
$stmt_check=query("select * from users_chats where counsellor_id=? and user_email=?");
$res=select($stmt_check,array("ss",$_POST['idcon'],$user['email']));

if (sizeof($res)>0) {
    $res=$res[0];
    $room_id=$res['room_id'];
    $user_email=$user['email'];
    $counsellor_name=$res['counsellor_name'];
    echo json_encode(array("success"=>true,"room"=>$room_id,"con_email"=>$res['counsellor_email'],"counsellor"=>$counsellor_name));
} else {

    $counsellor_set=query("select * from counsellors where id=?");
    $set=select($counsellor_set,array("i",(int)$_POST['idcon']));

    $conn=(int)$set[0]['connects'];
    $conn+=1;
    $conn=strval($conn);
    $counsellor_con=query("update counsellors set connects=? where id=?");
    bind($counsellor_con,array("si",$conn,(int)$_POST['idcon']));
    execute($counsellor_con);

    $counsellor_email=$set[0]['email'];
    $room_id=$user['email']."_".$counsellor_email;
    $stmt_insert=query("insert into users_chats(user_name,counsellor_email,user_email,time,ip,status,room_id,counsellor_id,counsellor_name) values (?,?,?,NOW(),?,?,?,?,?)");
    bind($stmt_insert,array("ssssssss",$user['name'],$counsellor_email,$user['email'],$_SERVER['REMOTE_ADDR'],"active",$room_id,$_POST['idcon'],$set[0]['name']));
    $tt=execute($stmt_insert);
    if ($tt) {
        echo json_encode(array("success"=>true,"room"=>$room_id,"con_email"=>$counsellor_email,"counsellor"=>$set[0]["name"]));
    } else {
        echo json_encode(array("success"=>false,"message"=>"Failed to start chat"));
    }

}
?>