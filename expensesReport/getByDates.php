<?php

try {
    include "../connect.php";
$oper_type ="get";
$fromDate = $_GET['fromDate'] ?? null;
$toDate = $_GET['toDate'] ?? null;


if(isset($fromDate) == false || empty($fromDate) || isset($toDate) == false || empty($toDate) 
|| isDate($fromDate)==false || !isDate($toDate)
)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"the dates input is incomplete",operation_type:$oper_type);
    return;
}
$fromDate = date("Y-m-d", strtotime($fromDate));  
$toDate = date("Y-m-d", strtotime($toDate));

$stmt = $con->prepare(getExpenseQuery()." where theDate Between ? and  ?");
$stmt->execute(array($fromDate,$toDate));

$data =$stmt->fetchAll(PDO::FETCH_ASSOC);

//$data = convertValueToDataType($data);

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>