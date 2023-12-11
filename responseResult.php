
<?php
class ResponseResult
{
    
    public static function json_encode_bh($value)
    {
        header('Content-Type: application/json; charset=utf-8');               
        echo json_encode($value);
        //echo json_decode($value);
    }

    #region ResponseResult
    public static function getResponse($operation_type, bool $is_success= false, string $message= "", string $code= "",  $data=null, $error=null)
    {
        ResponseResult::json_encode_bh(array("is_success"=>$is_success,
        "message"=>$message,
        "code"=>$code,
        "operation_type"=>$operation_type,
        "data"=>$data,
        "error"=>$error));
    }

    public static function getResponseSuccess($data, $operation_type, string $message="")
    {
        //echo json_encode(array("status"=>"success","data"=>$data));
        ResponseResult::getResponse(is_success:true,message:$message,data:$data,operation_type:$operation_type,error:null);            
    }
    public static function getResponseSuccessAED($id, $operation_type, string $message="")
    {
        $message ="تمت العملية بنجاح";
        //$message="operation accomplished successfully";
        $data = array("success"=>true,"id"=>$id,"message"=>$message);
        ResponseResult::getResponseSuccess(data:$data,operation_type:$operation_type,message:$message);
    }
    public static function getResponseError(string $error_code,string $error_message, $operation_type)
    {
        $errorObj = array("error_code"=>$error_code,"error_message"=>$error_message);        
        ResponseResult::getResponse(error: $errorObj, operation_type: $operation_type,message:$error_message,data:null);
    }
    public static function getResponseException(Exception $ex, $operation_type)
    {
        $message="an exception occurred"; 
        $message=$ex->getMessage();
        //$errorObj = array("error_code"=>"492","error_message"=>$message);         
        $errorObj = array("error_code"=>$ex->getCode(),"error_message"=>$message);       
        ResponseResult::getResponse(error: $errorObj, operation_type: $operation_type,message:$message,data:null);
    }
    public static function getActionValue($value, $operation_type = "get")
    {
        $values =array("value"=>$value);//getActionDict
        ResponseResult::getResponseSuccess(data:$values,operation_type:$operation_type);
    }
    #endregion

    #region ActionResultDRY
    


    #endregion


    //function __construct() {}

    // static function  getResponseResultStatic($data)
    // {
    //     echo json_encode(array("is_success"=>true,"message"=>"","code"=>"","operation_type"=>"get","data"=>$data, "error"=>null));
    // }
    // public function  getResponseResult($data)
    // {
    //     echo json_encode(array("status"=>"success","data"=>$data));
    // }
      // $obj = new ResponseResult();
    // $obj->getResponseResult($data);

}

?>