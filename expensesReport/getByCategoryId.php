<?php

try {
    include "../connect.php";
$oper_type ="get";
$categoryId = intval($_GET['categoryId'] ?? 0);

if (isset($categoryId) == false || empty($categoryId) || is_numeric($categoryId) == false
|| $categoryId==0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"categoryId input is incomplete",operation_type:$oper_type);
   return;
}

$stmt = $con->prepare(getExpenseQuery()." where categoryId=?");
$stmt->execute(array($categoryId));

$data =$stmt->fetchAll(PDO::FETCH_ASSOC);

$data = convertValueToDataType($data);

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>