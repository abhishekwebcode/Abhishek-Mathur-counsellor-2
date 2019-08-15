<?php
function proceed($name,$email) {
    $stmt_check= query("select * from users_data where email = ?");
    $res=select($stmt_check, array("s",$email));
    if (sizeof($res)>0) {
            $stmt_main= query("select * from users_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
            echo json_encode(array("res"=>($res),
                "success"=>true,
                "name"=>$name,
                "email"=>$email,
                "message"=>"Log in successfull.",
                "token"=> ((string) session_id())
                )
            );
            die(); 
   } else {
        $stmt_insert=query("insert into users_data(name,email,signupip,signupdate,contacted,city,state,method)"
                . " values (?,?,?,NOW(),0,?,?,'google_button_sign')");
        bind($stmt_insert, array("sssss",$name,$email,$_SERVER['REMOTE_ADDR'],$_POST['city'],$_POST['state']));
        if (execute($stmt_insert)) {
                $stmt_main= query("select * from users_data where email = ?");
            $res= select($stmt_main, array("s",$email));
            $res=$res[0];
            setUser($res);
            echo json_encode(array("res"=>($res),
                "success"=>true,
                "name"=>$name,
                "email"=>$email,
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
        echo json_encode(array('success' => false, "message" => "GOOGLE AUTH FAILED NO RESPONSE"));die();
    }
    $host = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" . $token;
    $content = file_get_contents($host) or die(json_encode(array('success' => false, "message" => "ERROR")));
    
    $web = json_decode($content, true);
    if ($web === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(array('success' => false, "message" => "ERROR"));die();
    } else {
        $tt="833942323414-hprspm984ql4l9h22q3vokm7ncoon5eb.apps.googleusercontent.com";
        if ($web["aud"] == $tt) { 
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
        else {
            echo json_encode(array('success' => false, "message" => "GOOGLE AUTH FAILED"));die();
        }
    }
}
?>