<?php

function filterRequest($requestName)
{
    return htmlspecialchars(strip_tags($_POST[$requestName]));
}

function getCurrentDateTime()
{
    $now = new DateTime(); // Create a new DateTime object with the current date and time
    $currentDateTime = $now->format('Y-m-d H:i:s'); 
    return $currentDateTime;
}


function getQueryMaxId(string $tableName, string $column_name="id")
{
    $query ="SELECT MAX($column_name) AS max_id FROM ".$tableName;
    return $query;
}

function getQueryById(string $tableName, string $column_name="id")
{
    $query ="SELECT * FROM ".$tableName." where $column_name = ?";
    return $query;
}

function getMaxId(string $tableName, string $column_name="id")
{
    $query ="SELECT MAX($column_name) AS max_id FROM ".$tableName;
    return $query;
}

// دالة ترجع استعلام المصروفات لعدم التكرار
function getExpenseQuery()
{
    $query ="SELECT exps.*, cate.name categoryName from " . Constants::expense_table." exps 
    inner join " . Constants::category_table." cate on cate.id=exps.categoryId ";
    return $query;
}

function isDate($value) 
{
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

//define('MB', 1048576);

    function checkAuthenticate()
    {
        if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {    
            if ($_SERVER['PHP_AUTH_USER'] != "bh" || $_SERVER['PHP_AUTH_PW'] != "123456bh"){
                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Page Not Found';
                exit;
            }
        } else {
            exit;
        }
    }

    function bigintval($value) {
        $value = trim($value);
        if (ctype_digit($value)) {
          return $value;
        }
        $value = preg_replace("/[^0-9](.*)$/", '', $value);
        if (ctype_digit($value)) {
          return $value;
        }
        return 0;
      }
#region ActionResultDRY
    
    // دالة تحويل القيم المناسبة إلى أنواع البيانات الصحيحة
    // كل هذا من اجل العمود الي من نوع بلين لا يتوافق بلغة السي شارب اما البقية عادي
function convertValueToDataType($data) {
    foreach ($data as &$item) {  
        $item = convertValueToDataTypeItem($item); 
        // foreach ($item as $key => $value) {
        //     $item[$key] = _convertValueToDataType($value);         
        // }
    }
    return $data;
}
function convertValueToDataTypeItem($item) {   
    foreach ($item as $key => $value) {
        $item[$key] = _convertValueToDataType($value);         
        
    }
    return $item;
}
function convertExpenseCategories($data)
{
    foreach ($data as &$item) {   
        //$item["isLimitAmountName"] = $item["isLimitAmount"]==="1" ? "موجود" :"لا يوجد";
        foreach ($item as $key => $value) {
            // $valueType = gettype($value);
            if($item[$key]===$item["isLimitAmount"])
            {
                
                $item[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                $item["isLimitAmountName"] = $item[$key]===true ? "موجود" :"لا يوجد";
            }
            else
                $item[$key] = _convertValueToDataType($value);         
        }
    }
    return $data;
}

function _convertValueToDataType($value) {
    if (is_numeric($value)) {
        if (strpos($value, '.') !== false) {
            return floatval($value);
        } else {
            return intval($value);
        }
    } else if ($value === 'true' || $value === 'false') {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    } else {
        return $value;
    }
}

#endregion

