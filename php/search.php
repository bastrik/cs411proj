<?php
require_once("head.php");
//$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
//strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
//if(!$isAjax) {
//    $user_error = 'Access denied - not an AJAX request...';
//    trigger_error($user_error, E_USER_ERROR);
//}
// get what user typed in autocomplete input

$term = trim($_GET['term']);

$a_json = array();
$a_json_row = array();

$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
$json_invalid = json_encode($a_json_invalid);

include_once "connect.php";
// replace multiple spaces with one
$term = mysqli_real_escape_string($con, $term);


$rs = mysqli_query($con, "SELECT stackname, stack_id FROM stacks WHERE stackname LIKE '{$term}%' ORDER BY followers DESC LIMIT 10 ") or die($json_invalid);

if($rs === false) {
    $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . $conn->errno . ' ' . $conn->error;
    trigger_error($user_error, E_USER_ERROR);
}

while($row = $rs->fetch_assoc()) {
    $a_json_row["id"] = $row['stack_id'];
    $a_json_row["value"] = $row['stackname'];
    $a_json_row["label"] = $row['stackname'];
    array_push($a_json, $a_json_row);
}

$json = json_encode($a_json);
print $json;
?>
