<?php
class ServiceHelper
{
    static private $NameService;
    static private $ActionService;
    static private $ParamService;
    static private $ApiInstance;

    public static function InitializeCall($_nameservice, $_actionservice, ...$_paramservice)
    {
        if (!empty($_nameservice) && !empty($_actionservice)){
            self::$NameService = $_nameservice;
            self::$ActionService = $_actionservice;
            self::$ParamService = $_paramservice;
        }else
            throw new Exception("Name service and Action service is required");
    }

    public static function Run()
    {
        self::$ApiInstance = Allocator::AllocateAPI(self::$NameService);
        if (!is_null(self::$ApiInstance))
        {
            if (!empty(self::$ActionService))
            {
                $ResultService = array(
                    'result' => array(
                        "NameAction" => self::$ActionService
                    ),
                );
                self::$ApiInstance = new self::$NameService($ResultService, self::$ActionService, self::$ParamService);
                $ResultService['result']['RequestStart'] = microtime(true);
                $ResultService['result'] = self::CallService();
                $ResultService['result']['RequestEnd'] = microtime(true);
                $ResultService['result']['Status'] = !is_null($ResultService['result']['Response']);
                $ResultService['result']['TimeExecution'] = $ResultService['result']['RequestEnd'] - $ResultService['result']['RequestStart'];
                return $ResultService['result'];
            }
            throw new Exception("You must be indicate the action");
        }
        throw new Exception("API doesn't exist");
    }

    private static function CallService()
    {
        $response = array("Response" => null, "Exception" => null);
        try
        {
            $response["Response"] = call_user_func(array(self::$ApiInstance, self::$ActionService), self::$ParamService);
        }
        catch(Exception $ex)
        {
            $response["Exception"] = $ex;
        }
        finally
        {
            return $response;
        }
    }
}
