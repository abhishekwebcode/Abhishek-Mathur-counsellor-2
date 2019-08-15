<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once("autoload-fg52/index.php");
$user=getUser();
if ($user==null) {
    echo json_encode(array("success"=>false,"error"=>"You are logged out"));
    die();
}
$stmt_check=query("select * from counsellors where email = ?");
$ans=select($stmt_check,array("s",$user['email']));
if (sizeof($ans)>0) {
    echo json_encode(array("success"=>false,"error"=>"Your Profile Already exists","exists"=>true));die();
}
$views="0";
$connects="0";
$city=$_POST['city'];
$state=$_POST['state'];
$name=$user['name'];
$email=$user['email'];
$uri=$email;
$namef = $_FILES["image"]["name"];
$ext = end((explode(".", $namef)));
$url='/var/www/abhishek/counsellor/partner/KMfcg52LzYpcvrXujfhri2vZKYWv5P/'.$uri.".".$ext;
if (move_uploaded_file($_FILES['image']['tmp_name'], $url)) {
    $a=2+2;
} else {
    echo json_encode(array("success"=>false,"error"=>"Cannot read uploaded photo"));die();
}
$photo_url=$uri.".".$ext;
$descr=$_POST['descr'];
$age=(double)$_POST['age'];
$exp=(double)$_POST['exp'];
$niche=$_POST['niche'];
$phone=$_POST['phone'];
$active='true';
$website=$_POST['website'];
$type=$_POST['cat'];
$tagline=$_POST['tagline'];
$other_details=$_POST['notes'];
$name=$user['name'];

$stmt_insert=$dbh55->prepare("insert into counsellors (views,connects,city,state,name,email,photo_url,descr,age,exp,niche,phone,active,website,type,tagline,other_details) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("hello");
bind($stmt_insert,array("sssssssssssssssss",$views,$connects,$city,$state,$name,$email,$photo_url,$descr,$age,$exp,$niche,$phone,$active,$website,$type,$tagline,$other_details));
$res=execute($stmt_insert);
if (!($res)) {
    echo json_encode(array("success"=>false,"error"=>"Cannot Update Your Details"));die();
} else {
    echo json_encode(array("success"=>true));die();
}
?>