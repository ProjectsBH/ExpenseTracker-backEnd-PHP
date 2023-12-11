<?php

try {
    include "../connect.php";
    $oper_type ="get";

$stmt = $con->prepare(getExpenseQuery()." LIMIT 50");
$stmt->execute();
$data =$stmt->fetchAll(PDO::FETCH_ASSOC);
//$count=$stmt->rowCount();

//$data = convertValueToDataType($data);

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>