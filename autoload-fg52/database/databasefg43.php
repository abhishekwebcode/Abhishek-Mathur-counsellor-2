<?php
header("Content-Type: text/plain");
global $dbh55;
function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}
$dbh55 = mysqli_connect("mm.caompsumt9ml.ap-south-1.rds.amazonaws.com", "yJcC91xR4YVyTWSS", "sgMEviMEWYIz7XdF907JeUV8wUo8FgotawPsxl7d", "counsellor_9Z31UdPUOGiOyZV") or die("ERRORINIT73Y contact support for futher help");
function query($sql) { 
	global $dbh55;
	return $dbh55->prepare($sql) ;
}
function bind($stmt,$args) {
global $dbh55;
call_user_func_array(array($stmt, "bind_param"), refValues($args));
}
function execute($stmt) {
$stmt->execute();
return $stmt->affected_rows>0;
}

function getaff() {
	global $dbh55;
	return $dbh55->affected_rows;
}
function rows() {
	global $dbh55;
}
function lastId() {
    global $dbh55;
    return $dbh55->insert_id;
}
function select($stmt,$args) {
global $dbh55;
call_user_func_array(array($stmt, "bind_param"), refValues($args));
$stmt->execute();
$meta = $stmt->result_metadata();

while ($field = $meta->fetch_field()) {
  $parameters[] = &$row[$field->name];
}

call_user_func_array(array($stmt, 'bind_result'), $parameters);
$results=array();
while ($stmt->fetch()) {
  foreach($row as $key => $val) {
    $x[$key] = $val;
  }
  $results[] = $x;
}
$stmt->close();
return $results;
}
/*
$stmt=query("insert into users_data (name) values (?)");
$name="wahtever";
bind($stmt,array("s",&$name));
var_dump(execute($stmt));
echo $stmt->error;
echo lastId();
*/
?>