
<?php
try {
    include "../connect.php";
    $oper_type ="get";
$stmt = $con->prepare("SELECT * from " . Constants::category_table);
$stmt->execute();

$data =$stmt->fetchAll(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();

// تحويل القيم المناسبة إلى أنواع البيانات الصحيحة
//$data[0]["id"] = intval($data[0]["id"]);

/*foreach ($data as &$item)
{
$item["id"] = intval($item["id"]);
$item["isLimitAmount"] = intval($item["isLimitAmount"]);
$item["limitAmount"] = floatval($item["limitAmount"]);
$item['created_by'] = intval($item['created_by']);
}*/

$data = convertExpenseCategories($data);

// if($count>0)
//     ResponseResult::getResponseSuccess(data:$data,operation_type:"get");
// else
//     ResponseResult::getResponseError(error_code:"460",error_message:"fail",operation_type:"get");

ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}



?>