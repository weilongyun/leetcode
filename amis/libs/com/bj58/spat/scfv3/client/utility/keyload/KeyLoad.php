<?php
namespace com\bj58\spat\scf\client\utility\keyload;

class KeyLoad
{
    public static $keyContent = '';

    public static function getKeyContent($filepath, $serviceName)
    {
        try {
            $succ = '';
            $content = apcu_fetch($serviceName, $succ);
            if ($succ) {
                $GLOBALS[$filepath]['scf_keyContent'] = $content;
                if ($GLOBALS['SCF_IS_GLOBAL_PATH']) {
                    $GLOBALS['scf_keyContent'] = $content;
                }
            } else {
                $content = self::readFileByLines($filepath);
                if ($content == null) {
                    throw new \Exception("scfkey content is null or empty. path is " . $filepath);
                } else {
                    apcu_add($serviceName, $content);
                }
            }
            return $GLOBALS[$filepath]['scf_keyContent'];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function readFileByLines($filepath)
    {
        try {
            $conn = file_get_contents($filepath);
            $conn = trim($conn);
            $conn = str_replace('rn', '<br/>', $conn);
            $GLOBALS[$filepath]['scf_keyContent'] = $conn;
            return $conn;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getKey()
    {
        return $GLOBALS['scf_keyContent'];
    }
}

?>