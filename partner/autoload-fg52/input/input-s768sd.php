<?php
function check() {
    foreach ($_POST as $key => $value) {
        if ($value=="") {
            echo json_encode(array("success"=>false,"message"=>"Please Enter akll the Fields"));
        }
    }
}
?>

