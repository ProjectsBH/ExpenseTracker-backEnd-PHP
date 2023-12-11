<?php

try {
    include "../connect.php";
$oper_type ="get";
$categoryId = intval($_GET['categoryId'] ?? 0);
$fromDate = $_GET['fromDate'] ?? null;
$toDate = $_GET['toDate'] ?? null;

 
if (isset($categoryId) == false || empty($categoryId) || is_numeric($categoryId) == false
|| $categoryId==0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"categoryId input is incomplete",operation_type:$oper_type);
   return;
}


if(isset($fromDate) == false || empty($fromDate) || isset($toDate) == false || empty($toDate) 
|| isDate($fromDate)==false || !isDate($toDate)
)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"the dates input is incomplete",operation_type:$oper_type);
    return;
}
$fromDate = date("Y-m-d", strtotime($fromDate));  
$toDate = date("Y-m-d", strtotime($toDate)); 

$stmt = $con->prepare(getExpenseQuery()." where categoryId=? and theDate Between ? and  ?");
$stmt->execute(array($categoryId,$fromDate,$toDate));

$data =$stmt->fetchAll(PDO::FETCH_ASSOC);

$data = convertValueToDataType($data);

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>