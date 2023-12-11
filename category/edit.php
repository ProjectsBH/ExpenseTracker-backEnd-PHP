<?php



try
{
    include "../connect.php";
$id = $_GET['id'];
$oper_type ="edit";

if (isset($id) == false || empty($id) || is_numeric($id) == false)
{
    ResponseResult::getResponseError(error_code:"402",error_message:"id input is incomplete",operation_type:$oper_type);
   return;  
}
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['name']) ==false || !isset($data['isLimitAmount'])
|| isset($data['limitAmount']) ==false)
{
    ResponseResult::getResponseError(error_code:"405",error_message:"البيانات المرسلة خاطئة",operation_type:$oper_type);
    return;
}
$name= $data['name'];
$isLimitAmount = $data["isLimitAmount"];
$limitAmount = $data["limitAmount"];


if (isset($name) == false || empty($name))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"name input is incomplete",operation_type:$oper_type);
   return;
}
if ($isLimitAmount == true && (empty($limitAmount) || $limitAmount <1))
{
    ResponseResult::getResponseError(error_code:"402",error_message:"مبلغ الحد غير صحيح",operation_type:$oper_type);
   return;
}

// getForExists - الفئة غير مكرة، قم بتعديل السجل
$stmt = $con->prepare("SELECT * FROM ".Constants::category_table." WHERE name = ? and id != ?");
$stmt->execute(array($name,$id));
$count=$stmt->rowCount();
if($count>0)
{
    ResponseResult::getResponseError(error_code:"402",error_message:'الفئة مكررة',operation_type:$oper_type);
    return;
}

$stmt = $con->prepare("UPDATE " . Constants::category_table . " SET `name`=?, isLimitAmount=?, limitAmount=? Where id = ?");

$stmt->execute(array($name,$isLimitAmount, $limitAmount, $id));

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