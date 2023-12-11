<?php

// المصفوفة الأصلية
$data = [
    [
        "id" => "1",
        "name" => "general",
        "isLimitAmount" => "0",
        "limitAmount" => "0.00",
        "created_by" => "1",
        "created_in" => "2023-11-18 16:45:42"
    ],
    [
        "id" => "2",
        "name" => "عام",
        "isLimitAmount" => "1",
        "limitAmount" => "650.00",
        "created_by" => "1",
        "created_in" => "2023-11-19 13:16:06"
    ]
];

// دالة تحويل القيم المناسبة إلى أنواع البيانات الصحيحة
function convertStringToDataType($value) {
    if (is_numeric($value)) {
        if (strpos($value, '.') !== false) {
            return floatval($value); // تحويل السلسلة النصية إلى عدد عشري
        } else {
            return intval($value); // تحويل السلسلة النصية إلى عدد صحيح
        }
    } else if ($value === 'true' || $value === 'false') {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN); // تحويل السلسلة النصية إلى بوليان
    } else {
        return $value; // السلسلة النصية كما هي
    }
}

// تحويل قيم البيانات في المصفوفة إلى أنواع بيانات صحيحة
$data = array_map(function ($item) {
    return array_map('convertStringToDataType', $item);
}, $data);

// طباعة المصفوفة بعد التحويل
//print_r($data);

$response = json_encode($data);

// إرجاع الاستجابة
echo $response;
?>