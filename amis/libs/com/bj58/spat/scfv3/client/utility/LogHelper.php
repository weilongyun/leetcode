<?php
namespace com\bj58\spat\scf\client\utility;

use com\bj58\spat\scf\log\LogFactory;
class LogHelper
{
    static function logErrorMsg($msg) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logErrorMsg($msg);
        }
    }

    static function logErrorMsgException($e) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logErrorMsgException($e);
        }
    }

    static function logWarnMsg($msg) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logWarnMsg($msg);
        }
    }

    static function logWarnMsgException($e) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logWarnMsgException($e);
        }
    }

    static function logInfoMsg($msg) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logInfoMsg($msg);
        }
    }

    static function logInfoMsgException($e) {
        $logger = LogFactory::getLog();
        if (null !== $logger) {
            $logger->logInfoMsgException($e);
        }
    }
}