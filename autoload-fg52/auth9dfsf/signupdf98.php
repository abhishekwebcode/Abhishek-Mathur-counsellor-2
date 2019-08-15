<?php
function signup_native($name,$email,$password) {
    check();
    $stmt_signup= query("select * from users_data where email = ?");
    $re=select($stmt_signup, array("s",$email));
    if (sizeof($re)>0) {
        echo json_encode(array("success"=>false,"message"=>"You are already registered.Please Login"));
        die();
    } 
    else {
        $hash= password_hash($password,PASSWORD_BCRYPT);
        $stmt_insert=query("insert into users_data(name,email,hash,signupip,signupdate,contacted,city,state,method)"
                . " values (?,?,?,?,NOW(),0,?,?,'native')");
        bind($stmt_insert, array("ssssss",$name,$email,$hash,$_SERVER['REMOTE_ADDR'],$_POST['city'],$_POST['state']));
        if (execute($stmt_insert)) {
                $stmt_main= query("select * from users_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
            echo json_encode(array(
                "success"=>true,
                "name"=>$_POST['name'],
                "email"=>$_POST['email'],
                "message"=>"Sign up successfull.",
                "token"=> ((string) session_id())
                )
            );
            die();
        } 
    }
}
?>