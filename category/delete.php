

<?php


try
{
    include "../connect.php";
$id = $_GET['categoryId']??0;

$oper_type ="delete";

if (isset($id) == false || empty($id) || is_numeric($id) == false)
{
    ResponseResult::getResponseError(error_code:"405",error_message:"الرقم المرسل غير صحيح",operation_type:$oper_type);
   return;
}

// checkCategoryIdHasExpenses - الرقم غيرمرتبط بعمليات، قم بحذف السجل
$stmt = $con->prepare("SELECT * FROM ". Constants::expense_table ." Where categoryId=? order by created_in desc Limit 1");
$stmt->execute(array($id));
$count=$stmt->rowCount();
if($count>0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:'رقم الفئة مرتبطة بعمليات',operation_type:$oper_type);
    return;
}

$stmt = $con->prepare("DELETE FROM " . Constants::category_table . " where id = ?");

$stmt->execute(array($id));

$count=$stmt->rowCount();

if($count>0)
{
    ResponseResult::getResponseSuccessAED(id:$id,operation_type:$oper_type);
}
else{
    ResponseResult::getResponseError(error_code:"402",error_message:"fail",operation_type:$oper_type);
}

} catch (Exception $ex) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}
?>