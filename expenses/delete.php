

<?php
try{
include "../connect.php";
$expense_id = $_GET['id']?? 0;
$oper_type ="delete";
if (isset($expense_id) == false || empty($expense_id) || is_numeric($expense_id) == false)
{
    ResponseResult::getResponseError(error_code:"405",error_message:"الرقم المرسل غير صحيح",operation_type:$oper_type);
    return;
}

$stmt = $con->prepare("DELETE FROM " . Constants::expense_table . " where id = ?");

$stmt->execute(array($expense_id));

$count=$stmt->rowCount();

if($count>0)
{
    ResponseResult::getResponseSuccessAED(id:$expense_id,operation_type:$oper_type);
}
else{
    ResponseResult::getResponseError(error_code:"402",error_message:"fail",operation_type:$oper_type);
}

} catch (Exception $ex) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>