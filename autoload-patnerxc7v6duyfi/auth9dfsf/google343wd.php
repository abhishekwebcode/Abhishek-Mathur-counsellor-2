<?php
function proceed($name,$email) {
    $stmt_check= query("select * from counsellor_data where email = ?");
    $res=select($stmt_check, array("s",$email));
    if (sizeof($re)>0) {
            $stmt_main= query("select * from counsellor_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
        echo json_encode(array(
                "success"=>true,
                "message"=>"Sign in successfull.",
                "token"=> ((string) session_name())
                )
            );
            die();
    } else {
        $google_insert= query("insert into counsellor_data(name,email,signupip,signupdate,contacted,city,state,method)"
                . " values (?,?,?,?,NOW(),0,?,?,'google')");
        bind($stmt_insert, array("ssssss",$name,$email,$_SERVER['REMOTE_ADDR'],$city,$state));
        if (execute($stmt_insert)) {
            $stmt_main= query("select * from users_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
            echo json_encode(array(
                "success"=>true,
                "message"=>"Sign up successfull.",
                "token"=> ((string) session_id())
                )
            );
            die();
    }
}
}
function auth_google($token) {
    if ($token=="") {
        echo json_encode(array('success' => false, "message" => "GOOGLE AUTH FAILED"));
    }
    $host = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" . $token;
    $content = file_get_contents($host) or die(json_encode(array('success' => false, "message" => "ERROR")));
    $web = json_decode($content, true);
    if ($web === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(array('success' => false, "message" => "ERROR"));
    } else {
        if ($web["aud"] == "833942323414-n28jl17bhcvvutgmouif2f5uid89plcc.apps.googleusercontent.com") {
            if (!(array_key_exists("email", $web))) {
                echo json_encode(array('success' => false, "message" => "EMAIL NOT FOUND"));die();
            }
            elseif (!(array_key_exists("name", $web))) {
                echo json_encode(array('success' => false, "message" => "NAME NOT FOUND"));
            }
            else {
                proceed($web["name"],$web["email"]);
            }
        }
    }
}
?>