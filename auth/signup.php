<?php

include "../connect.php";
try {

    $data = json_decode(file_get_contents('php://input'), true);
$oper_type ="add";
if (isset($data['userName']) ==false || !isset($data['email'])
|| isset($data['password']) ==false || !isset($data['confirmPassword']))
{
    ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
    return;
}
$user= $data["userName"];
$email=$data["email"];
$password=$data["password"];
$confirmPassword =$data["confirmPassword"];

if (isset($user) == false || empty($user)
|| isset($password) == false || empty($password))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"User input is incomplete",operation_type:$oper_type);
    return;
}
if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
    ResponseResult::getResponseError(error_code:"402",error_message:"email valid",operation_type:$oper_type);
   return;
}
if ($password !== $confirmPassword)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"كلمة المرور لا تساوي تأكيدها",operation_type:$oper_type);
   return;
}

$stmt = $con->prepare("INSERT INTO " . Constants::User_table . " (`userName`, `email`, `password`,`created_in`) 
VALUES (?,?,?,?)");
$currentDateTime = getCurrentDateTime(); 
$stmt->execute(array($user,$email,$password,$currentDateTime));
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