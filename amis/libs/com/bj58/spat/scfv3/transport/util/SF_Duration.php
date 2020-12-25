<?php
namespace com\bj58\spat\scf\transport\util;
/**
 * SF_Duration abstraction class
 * copied from twitter.util.SF_Duration
 */
class SF_Duration {

    const UNIT_SECONDS = 1000000;
    const UNIT_MICROSECONDS = 1;
    const UNIT_MILLISECONDS = 1000;
    private $microseconds = 0;

    public function __construct($value, $unit) {
        $this->microseconds = $value * $unit;
    }

    static public function fromSeconds($seconds) {
        return new SF_Duration($seconds, SF_Duration::UNIT_SECONDS);
    }

    static public function fromMilliseconds( $millis) {
        return new SF_Duration($millis, SF_Duration::UNIT_MILLISECONDS);
    }

    public function inSeconds() {
        return $this->microseconds / SF_Duration::UNIT_SECONDS;
    }

    public function inMilliseconds() {
        return $this->microseconds / SF_Duration::UNIT_MILLISECONDS;
    }

    public function inMicroseconds() {
        return $this->microseconds;
    }

    /**
     * 时间间隔(秒)
     * @param SF_Duration $d1
     * @param SF_Duration $d2
     * @return number
     */
    public static function timeIntervalInSeconds(SF_Duration $d1, SF_Duration $d2) {
        return abs($d1->inSeconds() - $d2->inSeconds());
    }
}