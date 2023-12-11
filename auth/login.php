<?php

include "../connect.php";
try{

    $data = json_decode(file_get_contents('php://input'), true);
    $oper_type ="get";
    if (isset($data['userName']) ==false || !isset($data['password']))
    {
        ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
        return;
    }

$user= $data["userName"];
$password= $data["password"];

if (isset($user) == false || empty($user)
|| isset($password) == false || empty($password))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"User input is incomplete",operation_type:$oper_type);
   return;
}

$stmt = $con->prepare("SELECT * from " . Constants::User_table . " where userName=? AND `password`=?");
$stmt->execute(array($user,$password));

$data =$stmt->fetch(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();

if($count>0)
{
    ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
}
else{
    ResponseResult::getResponseError(error_code:"402",error_message:"fail",operation_type:$oper_type);
}

} catch (Exception $ex) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}
?>