<?php
class APIService
{
    private $NameService;
    private $ActionService;
    private $ParamService;
    private $InstanceClassService;

    public function __construct(){}

    public function SetCall($_nameservice, $_actionservice, $_paramservice = array())
    {
        if (!empty($_nameservice) && !empty($_actionservice)){
            $this->NameService = $_nameservice;
            $this->ActionService = $_actionservice;
            $this->ParamService = $_paramservice;
            $this->InstanceClassService = NULL;
        }else{
            throw new AuthenticationException("Name service and Action service is required");
        }
    }

    public function run()
    {
        if (can_allocate(API, $this->NameService))
        {
            allocate(LIBRARIES, 'APILibraries');
            allocate(API, $this->NameService);
            $this->InstanceClassService = new $this->NameService($this->ActionService, $this->ParamService);
            return $this->InstanceClassService->GenerateReport();
        }
        else
        {
            throw new MethodNotFoundException("The action indicated is not implemented or is blank");
        }
    }
}
