<?php
class ServiceHelper
{
    static private $NameService;
    static private $ActionService;
    static private $ParamService;

    public static function SetCall($_nameservice, $_actionservice, ...$_paramservice)
    {
        if (!empty($_nameservice) && !empty($_actionservice)){
            self::$NameService = $_nameservice;
            self::$ActionService = $_actionservice;
            self::$ParamService = $_paramservice;
        }else
            throw new Exception("Name service and Action service is required");
    }

    public static function run()
    {
        $apiInstance = Allocator::allocate_api(self::$NameService);
        if (!is_null($apiInstance))
        {
            if (!empty(self::$ActionService))
            {
                $ResultService = array(
                    'result' => array(
                        "NameAction" => self::$ActionService,
                        "Status" => "",
                        "Response" => "",
                        "RequestStart" => "",
                        "RequestEnd" => "",
                        "TimeExecution" => ""
                    ),
                );
                $apiInstance = new self::$NameService($ResultService, self::$ActionService, self::$ParamService);
                $ResultService['result']['RequestStart'] = microtime(true);
                $ResultService['result']['Response'] = call_user_func(array($apiInstance, self::$ActionService), self::$ParamService);
                $ResultService['result']['RequestEnd'] = microtime(true);
                $ResultService['result']['Status'] = !is_null($ResultService['result']['Response']);
                $ResultService['result']['TimeExecution'] = $ResultService['result']['RequestEnd'] - $ResultService['result']['RequestStart'];
                return $ResultService['result'];
            }
            throw new Exception("You must be indicate the action");
        }
        throw new Exception("API doesn't exist");
    }
}
