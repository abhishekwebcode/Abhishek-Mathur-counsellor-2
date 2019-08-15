<?php
error_reporting(E_ALL);
require_once("autoload-fg52/index.php");
if (!($_POST["2aFVuiaqrC5nLcuUn5Dx2LWc0OroxT"]=="qMrvBhJwOM2U1sc5v0nna8KnzgLhTp")) {
    die();
}
else {
    $user=getUser();
    if ($user==null) {
        echo json_encode(array("success"=>false,"messsage"=>"You are not Logged In.Kindly SIGNUP|LOGIN.","login"=>true));
        die();
    }
    else {
        $stmt_get=query("select * from counsellors where id = ?");
        $res=select($stmt_get,array("i",(int)$_POST['id']));
        if (sizeof($res)>0) {
            $main=$res[0];
            $main["success"]=true;
            echo json_encode(($main));
            $views=(int) ($res[0]["views"]);
            $views+=1;
            $stmt_update=query("update counsellors set views = ? where email = ?");
            select($stmt_update,array("ss",strval($views),$res[0]["email"]));
        } else {
            echo json_encode(array("success"=>false,"messsage"=>"Profile Not Found"));
        }
    }
}
?>