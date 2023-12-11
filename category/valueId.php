
<?php
try {
    include "../connect.php";
    $oper_type ="get";
$stmt = $con->prepare("SELECT id,name from " . Constants::category_table);
$stmt->execute();

$data =$stmt->fetchAll(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();

// تحويل القيم المناسبة إلى أنواع البيانات الصحيحة
$data = convertValueToDataType($data);


ResponseResult::getResponseSuccess(data:$data,operation_type:$oper_type);
} catch (Exception $e) {
    ResponseResult::getResponseException($ex,operation_type:$oper_type);
}



?>