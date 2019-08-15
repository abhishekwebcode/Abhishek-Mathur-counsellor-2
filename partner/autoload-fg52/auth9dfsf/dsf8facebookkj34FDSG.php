<?php
function proceed($name, $email)
{
    $stmt_check = query("select * from counsellor_data where email = ?");
    $res = select($stmt_check, array("s", $email));
    if (sizeof($res) > 0) {
        $stmt_main = query("select * from counsellor_data where email = ?");
        $res = select($stmt_main, array("s", $email));

        $stmt_main2 = query("select * from counsellors where email = ?");
        $res2 = select($stmt_main2, array("s", $email));
        if (sizeof($res2) > 0) {
            $exists = true;
        } else {
            $exists = false;
        }

        $res = $res[0];
        setUser($res);
        echo json_encode(array("res" => ($res),
                "success" => true,
                "name" => $name,
                "email" => $email,
                "message" => "Sign up successfull.",
                "token" => ((string)session_id()),
                "exists" => $exists
            )
        );
        die();
    } else {
        $stmt_insert = query("insert into counsellor_data(name,email,signupip,signupdate,contacted,city,state,method)"
            . " values (?,?,?,NOW(),0,?,?,'facebook_button_sign')");
        bind($stmt_insert, array("sssss", $name, $email, $_SERVER['REMOTE_ADDR'], $_POST['city'], $_POST['state']));
        if (execute($stmt_insert)) {
            $stmt_main = query("select * from counsellor_data where email = ?");
            $res = select($stmt_main, array("s", $email));
            $res = $res[0];
            setUser($res);
            echo json_encode(array("res" => ($res),
                    "success" => true,
                    "name" => $name,
                    "email" => $email,
                    "message" => "Sign up successfull.",
                    "token" => ((string)session_id()),
                    "exists" => false
                )
            );
            die();
        }
    }
}

function auth_facebook($token)
{
    if ($token == "") {
        echo json_encode(array('success' => false, "message" => "Facebook AUTH FAILED NO RESPONSE"));
        die();
    }
    $url = 'https://graph.facebook.com/me/';

    $postdata = http_build_query(
        array(
            "access_token" => $token,
            "fields"=>"name,email"
        )
    );

    // Set the POST options
    $opts = array('http' =>
        array (
            'method' => 'POST',
            'header' => 'Content-type: application/xwww-form-urlencoded',
            'content' => $postdata
        )
    );

    // Create the POST context
    $context  = stream_context_create($opts);

    // POST the data to an api
    $content = file_get_contents($url, false, $context);

    $web = json_decode($content, true);
    if ($web === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(array('success' => false, "message" => "ERROR OCCURED FACEBOOK LOGIN"));
        die();
    } else {
        if (!(array_key_exists("email", $web))) {
            echo json_encode(array('success' => false, "message" => "PLEASE ALLOW EMAIL PERMISSION AND TRY AGAIN"));
            die();
        } elseif (!(array_key_exists("name", $web))) {
            echo json_encode(array('success' => false, "message" => "PLEASE ALLOW NAME(PUBLIC_PROFILE) PERMISSION AND TRY AGAIN"));
        } else {
            proceed($web["name"], $web["email"]);
        }
    }
}

?>