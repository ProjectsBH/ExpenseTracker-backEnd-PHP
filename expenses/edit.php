<?php

try{
    include "../connect.php";
    $id = $_GET['id'];
    $oper_type ="edit";
    
    if (isset($id) == false || empty($id) || is_numeric($id) == false)
    {
        ResponseResult::getResponseError(error_code:"402",error_message:"id input is incomplete",operation_type:$oper_type);
       return;  
    }
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['categoryId']) ==false || !isset($data['theDate'])
    || isset($data['amount']) ==false || isset($data['theStatement']) ==false)
    {
        ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
        return;
    }

$categoryId = $data["categoryId"];
$theDate= $data["theDate"];
$amount=$data["amount"];
$theStatement = $data['theStatement'];

 
if (isset($categoryId) == false || empty($categoryId) || is_numeric($categoryId) == false)
    {
        ResponseResult::getResponseError(error_code:"402",error_message:"categoryId input is incomplete",operation_type:$oper_type);
        return;
    }
    if (isset($theDate) == false || empty($theDate))
    {
        ResponseResult::getResponseError(error_code:"402",error_message:"theDate input is incomplete",operation_type:$oper_type);
        return;
    }
    if (isset($amount) == false || empty($amount) || $amount<1)
    {
        ResponseResult::getResponseError(error_code:"402",error_message:"amount input is incomplete",operation_type:$oper_type);
        return;
    }

$stmt = $con-> prepare("UPDATE " . Constants::expense_table . " SET `categoryId`=?, `theDate`=? , amount=?, theStatement=? Where id = ?");

$stmt->execute(array($categoryId,$theDate,$amount, $theStatement, $id));

$count=$stmt->rowCount();

if($count>0)
{
    ResponseResult::getResponseSuccessAED(id:$id,operation_type:$oper_type);
}
else{
    ResponseResult::getResponseError(error_code:"402",error_message:"لم تعدل انت البيانات",operation_type:$oper_type);
}

} catch (Exception $ex) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>