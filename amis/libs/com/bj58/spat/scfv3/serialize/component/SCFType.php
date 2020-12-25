<?php
namespace com\bj58\spat\scf\serialize\component;

/**
 * Data types that can be sent via Thrift
 */
class SCFType
{

    const DBNULL = 1;

    const OBJECT = 2;

    const BOOL = 3;

    const CHAR = 4;

    const BYTE = 5;

    const I16 = 7;

    const I32 = 9;

    const I64 = 11;

    const FLOAT = 13;

    const DOUBLE = 14;

    const BIGDECIMAL = 15;

    const DATE = 16;

    const STRING = 18;

    const LST = 19;

    const GKEYVALUEPAIR = 22;

    const ARAY = 23;

    const MAP = 24;

    const SET = 26;

    const BBOOL = 29;

    const BCHAR = 30;

    const BBYTE = 31;

    const BSHORT = 32;

    const BINT = 33;

    const BLONG = 34;

    const BFLOAT = 35;

    const BDOUBLE = 36;
}