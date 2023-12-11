<?php

try {
    include "../connect.php";
$oper_type ="get";
$id = bigintval($_GET['id'] ?? 0);//bigintval

if (isset($id) == false || empty($id) || is_numeric($id) == false
|| $id==0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"id input is incomplete",operation_type:$oper_type);
   return;
}

$stmt = $con->prepare(getExpenseQuery()." where exps.id=?");
$stmt->execute(array($id));

$data =$stmt->fetch(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();

if($count<1) $data =null;
else
$data = convertValueToDataTypeItem($data);

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>