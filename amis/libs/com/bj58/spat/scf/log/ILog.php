<?php
namespace com\bj58\spat\scf\log;

interface ILog
{
    function logErrorMsg($msg);

    function logErrorMsgException($e);

    function logWarnMsg($msg);

    function logWarnMsgException($e);

    function logInfoMsg($msg);

    function logInfoMsgException($e);
}

?>