<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

use com\bj58\spat\scf\client\utility\keyload\KeyLoad;
use com\bj58\spat\scf\client\utility\LogHelper;
class ManagerServerDispatch
{
    private $managerServerConfigList;
    private $sendManagerServer;

    public function __construct($managerServerConfigList)
    {
        $this->managerServerConfigList = $managerServerConfigList;
        self::initManagerServer();
    }

    public function getManagerServer()
    {
        if (null === $this->managerServerConfigList || count($this->managerServerConfigList) === 0) {
            return null;
        }
        return $this->sendManagerServer;
    }

    public function initManagerServer()
    {
        $retryCount = 0;
        while (null === $this->sendManagerServer || !$this->sendManagerServer->isConnected())
        {
            if (($retryCount++) >= count($this->managerServerConfigList)) {
                break;
            }
            try {
                self::startConnect();
//                 self::requestCollector();
            } catch (\Exception $e) {
                LogHelper::logErrorMsgException($e);
                throw $e;
            }
        }
    }

    private function startConnect()
    {
        $currentIndex = 0;
        $len = count($this->managerServerConfigList);
        if ($len === 1) {
            $currentIndex = 0;
        } else {
            $currentIndex = rand(0, $len -1);
        }
        $serConfig = $this->managerServerConfigList[$currentIndex];
        $this->sendManagerServer = new ManagerServer($serConfig);
        $this->sendManagerServer->connect();
    }

    private function requestCollector()
    {
        try {
            $keyContent = KeyLoad::getKey();
            $req = '{"scfKey":"' .  $keyContent . '",';
            $req = $req . '"CompressType":1,';
            $req = $req . '"NeedId":true}';

            $reqProtocol = new SSMReqProtocol();
            $reqProtocol->setType(1);
            $sendData = $reqProtocol->dataCreate($req);
            $this->sendManagerServer->sendMessage($sendData);
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
        }
    }
}

?>