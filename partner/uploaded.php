<?php
require_once 'autoload-fg52/index.php';
if ($_POST["VLgwzpatorSCYVqd4kvbV4V9MjVvg3"]!="XQYwhgLethCcLEg6Fc1Kyz0n5G5spm") {
    die();
}
$user=getUser();
if ($user==null) {
echo json_encode(array("success"=>false,"message"=>"You are not authentiated"));
die();
}
else {
$email=$user["email"];
check();
    $stmt_signup=query("select * from counsellors where email = ?");
    $re=select($stmt_signup, array("s",$email));
    if (sizeof($re)>0) {
        echo json_encode(array("success"=>true,"exists"=>true,"message"=>"Profile exists"));
        die();
    } 
else {
 echo json_encode(array("success"=>true,"message"=>"Profile Doesnt exists","exists"=>false));
        die();

}

} 
?>