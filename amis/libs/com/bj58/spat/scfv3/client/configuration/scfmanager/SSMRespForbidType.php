<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

class SSMRespForbidType
{
    const OTHER = -1;
    const SERVICENOTEXIST = 1;
    const CALLERKEYNOTEXIST = 2;
    const NEEDAPPLYSERVICE = 3;
    const APPLYSERVICEFORBID = 4;

    public static function fromInt($value) {
        switch ($value) {
            case 1:
                return 'SERVICENOTEXIST';
            case 2:
                return 'CALLERKEYNOTEXIST';
            case 3:
                return 'NEEDAPPLYSERVICE';
            case 4:
                return 'APPLYSERVICEFORBID';
            default:
                return 'OTHER';
        };
    }

}

