<?php
function login_native($email,$password) {
    check();
    $stmt_check= query("select * from users_data where email = ?");
    $res=select($stmt_check, array("s",$email));
    if  (sizeof($res)==0) {
        echo json_encode(array("success"=>false,"message"=>"You are not registered"));die();
    }
    else {
        $result=$res[0];
        $hash=$result['hash'];
        if (!(password_verify($password, $hash))) {
            echo json_encode(array("success"=>false,"message"=>"Incorrect password or email"));die();
        }
        else {
            $stmt_main= query("select * from users_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
            echo json_encode(array(
                "name"=>$res['name'],
                "email"=>$_POST['email'],
                "success"=>true,
                "message"=>"DONE",
                "token"=> session_id()
            ));die();
        }
    }
}
?>