<?php

include "../connect.php";
try
{
    $data = json_decode(file_get_contents('php://input'), true);
$oper_type ="add";
if (isset($data['categoryId']) ==false || !isset($data['theDate'])
|| isset($data['amount']) ==false || !isset($data['theStatement']) || !isset($data['userId']))
{
    ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
    return;
}
$categoryId = $data["categoryId"];
$theDate= $data["theDate"];
$amount= $data["amount"];
$theStatement = $data["theStatement"];
$created_by = $data["userId"];

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
    if (isset($created_by) == false || empty($created_by) || is_numeric($created_by) == false)
    {
        ResponseResult::getResponseError(error_code:"402",error_message:"userId input is incomplete",operation_type:$oper_type);
        return;
    }

    $stmt = $con->prepare("INSERT INTO " . Constants::expense_table . " (`categoryId`, `theDate`, `amount`,theStatement,created_by,`created_in`) 
    VALUES (?,?,?,?,?,?)");

    $stmt->execute(array($categoryId, $theDate,$amount,$theStatement, $created_by, getCurrentDateTime()));
    $id = $con->lastInsertId();
    $count=$stmt->rowCount();

if($count>0)
    ResponseResult::getResponseSuccessAED(id:$id,operation_type:$oper_type);
else
    ResponseResult::getResponseError(error_code:"402",error_message:"fail",operation_type:$oper_type);
    

} catch (Exception $ex) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}
?>