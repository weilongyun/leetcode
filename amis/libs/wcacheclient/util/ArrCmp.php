<?php
namespace wcacheclient\util;

class ArrCmp
{

    public function cmpMultiArr($arrA, $arrB)
    {
        $rtA = array();
        $rtB = array();
        $this->transArr($arrA, $rtA);
        $this->transArr($arrB, $rtB);
        asort($rtA);
        asort($rtB);
        $count = count($rtA);
        $flag = true;
        if ($count != count($rtB)) {
            $flag = false;
        } else {
            for ($i = 0; $i < $count; $i ++) {
                if ($rtA[$i] != $rtB[$i]) {
                    $flag = false;
                    break;
                }
            }
        }
        return $flag;
    }

    private function transArr($arr, &$rt)
    {
        if (is_array($arr)) {
            foreach ($arr as $v) {
                if (is_array($v)) {
                    $this->transArr($v, $rt);
                } else {
                    $rt[] = $v;
                }
            }
        }
        return $rt;
    }
}
