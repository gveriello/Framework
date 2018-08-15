<?php
class APIService
{
    static private $NameService;
    static private $ActionService;
    static private $ParamService;
    static private $InstanceClassService;

    public static function SetCall($_nameservice, $_actionservice, $_paramservice = array())
    {
        if (!empty($_nameservice) && !empty($_actionservice)){
            self::$NameService = $_nameservice;
            self::$ActionService = $_actionservice;
            self::$ParamService = $_paramservice;
            self::$InstanceClassService = NULL;
        }else{
            throw new AuthenticationException("Name service and Action service is required");
        }
    }

    public static function run()
    {
        if (can_allocate(API, self::$NameService))
        {
            allocate(LIBRARIES, 'APILibraries');
            allocate(API, self::$NameService);
            self::$InstanceClassService = new self::$NameService(self::$ActionService, self::$ParamService);
            return self::$InstanceClassService->GenerateReport();
        }
        else
        {
            throw new MethodNotFoundException("The action indicated is not implemented or is blank");
        }
    }
}
