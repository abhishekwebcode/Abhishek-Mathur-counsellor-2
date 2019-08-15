<?php
session_id($_POST['token']);
session_start();
session_destroy();
echo json_encode(array("success"=>true));
?>