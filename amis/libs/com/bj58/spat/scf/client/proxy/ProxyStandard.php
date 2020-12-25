<?php
namespace com\bj58\spat\scf\client\proxy;

use com\bj58\spat\scf\serialize\component\TypeMap;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\log\SCFNoLog;
use com\bj58\spat\scf\log\LogFactory;
use com\bj58\spat\scf\client\SCFInit;
class ProxyStandard
{
    public $serviceName;
    public $lookup;
    public $initObj;

    public function __construct($serviceName='', $lookup='', $initObj = '')
    {
        TypeMap::init();
        $this->lookup = $lookup;
        $this->serviceName = $serviceName;
        $this->initObj = $initObj;
    }

    public function invoke($methodName, $param)
    {
        try {
            if (LogFactory::getLog() === null) {
                SCFInit::InitLog(SCFNoLog::getInstance());
            }
            $startTime = explode(' ', microtime());
            $obj = MethodCaller::doMethodCall($param, $methodName, $this->serviceName, $this->lookup, $this->initObj);
            $endTime = explode(' ', microtime());
            $wasteTime = $endTime[0] + $endTime[1] - ($startTime[0] + $startTime[1]);
            $wasteTime = round($wasteTime, 3);
            if ($wasteTime > 0.2) {
                $message = 'this request execute time exceed 200ms invoke time is ' . $wasteTime * 1000;
                LogHelper::logInfoMsg($message);
            }
            return $obj;
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
        }
    }
 /**
     * @return the $serviceName
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

 /**
     * @return the $lookup
     */
    public function getLookup()
    {
        return $this->lookup;
    }

 /**
     * @param string $serviceName
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

 /**
     * @param string $lookup
     */
    public function setLookup($lookup)
    {
        $this->lookup = $lookup;
    }

}
