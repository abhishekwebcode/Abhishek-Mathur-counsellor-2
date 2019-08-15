<?php

error_reporting(E_ALL);
require_once("autoload-fg52/index.php");
$city="%".$_POST['city']."%";
if (isset($_POST['search'])) {
    if ((isset($_POST['cat'])) && ($_POST['cat']!="ALL")) {
        $stmt = query("SELECT * FROM counsellors where ((email like ?) or (name like ?) or (niche like ?) or (other_details like ?) or (descr like ?) or (tagline like ?))  and (type = ?) and (city like ?)  limit 10 offset ?");
        $res = select($stmt, array("ssssssssi", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%",$_POST['cat'],$city, (int)$_POST['offset']));
    }
    else {
        $stmt = query("SELECT * FROM counsellors where ((email like ?) or (name like ?) or (niche like ?) or (other_details like ?) or (descr like ?) or (tagline like ?) ) and (city like ?) limit 10 offset ?");
        $res = select($stmt, array("sssssssi", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%", "%" . $_POST['search'] . "%",$city, (int)$_POST['offset']));
    }
}
elseif (isset($_POST['cat'])) {
    $stmt=query("select * from counsellors where (type=?) and (city like ?) limit 10 offset ?");
    $res=select($stmt,array("ssi",$_POST['cat'],$city,(int)$_POST['offset']));
}
else {
    $stmt=query("select * from counsellors where (city like ?) limit 10 offset ?");
    $res=select($stmt,array("si",$city,(int)$_POST['offset']));
}
if (sizeof($res)>0) {
    $data=array();
    foreach ($res as $key=>$value) {
        $data[$key]=$value;
    }
    echo json_encode(array("success"=>true,"data"=>($data)));
} else {
    echo json_encode(array("success"=>true,"message"=>"No More Results","data"=>null));
}
?>