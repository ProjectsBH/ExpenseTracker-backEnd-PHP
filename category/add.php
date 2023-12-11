<?php

include "../connect.php";
try {
$data = json_decode(file_get_contents('php://input'), true);
$oper_type ="add";
if (isset($data['name']) ==false || !isset($data['isLimitAmount'])
|| isset($data['limitAmount']) ==false || !isset($data['userId']))
{
    ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
    return;
}
$name= $data['name'];
$isLimitAmount = $data["isLimitAmount"];
$limitAmount = $data["limitAmount"];
$created_by = $data["userId"];

// $name= filterRequest("name");

if (isset($name) == false || empty($name))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"name input is incomplete",operation_type:$oper_type);
   return;
}
if ($isLimitAmount === true && (empty($limitAmount) || $limitAmount <1))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"مبلغ الحد غير صحيح",operation_type:$oper_type);
   return;
}
if (isset($created_by) == false || empty($created_by) || is_numeric($created_by) == false)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"userId input is incomplete",operation_type:$oper_type);
   return;
}

// getForExists - الفئة غير مكرة، قم بتعديل السجل
$stmt = $con->prepare("SELECT * FROM ".Constants::category_table." WHERE name = ?");
$stmt->execute(array($name));
$count=$stmt->rowCount();
if($count>0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:'الفئة مكررة',operation_type:$oper_type);
    return;
}


$stmt = $con->prepare(getQueryMaxId(Constants::category_table));
$stmt->execute();

$maxId = $stmt->fetch(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();
$id = 1;
if($count > 0)
{
    $id = $maxId['max_id']+1;
}


$stmt = $con->prepare("INSERT INTO " . Constants::category_table . " (`id`, `name`,isLimitAmount, limitAmount, created_by,`created_in`) 
VALUES (?,?,?,?,?,?)");

$stmt->execute(array($id, $name, $isLimitAmount, $limitAmount, $created_by, getCurrentDateTime()));

$count=$stmt->rowCount();

if($count>0)
{
    ResponseResult::getResponseSuccessAED(id:$id,operation_type:$oper_type);
}
else{
    ResponseResult::getResponseError(error_code:"402",error_message:"fail",operation_type:$oper_type);
    
}

} catch (Exception $ex) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
    // throw new Exception($e->getMessage());
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}

?>