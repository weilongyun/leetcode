<?php
namespace com\bj58\spat\scf\serialize\serializer;

class SerializerFactory
{

    public static function GetSerializer($typeId, $initObj = '')
    {
        if (null === $typeId) {
            return new NullSerializer($initObj);
        } else {
            if (!is_object($typeId) && isset($GLOBALS['SCFTypeIdMap']) && isset($GLOBALS['SCFTypeNameEnumMap']) && array_key_exists(strval($typeId), $GLOBALS['SCFTypeIdMap']) && array_key_exists($GLOBALS['SCFTypeIdMap'][strval($typeId)], $GLOBALS['SCFTypeNameEnumMap'])) {
                return new EnumSerializer($initObj);
            }
        }
        if (is_string($typeId)) {
            return new ObjectSerializer($initObj);
        }
        $serializer = null;
        switch ($typeId) {
            case '0':
            case '1':
                $serializer = new NullSerializer($initObj);
                break;
            case '2':
                $serializer = new ObjectSerializer($initObj);
                break;
            case '3':
                $serializer = new BooleanSerializer($initObj);
                break;
            case '4':
                $serializer = new CharSerializer($initObj);
                break;
            case '5':
            case '6':
                $serializer = new ByteSerializer($initObj);
                break;
            case '7':
            case '8':
                $serializer = new Int16Serializer($initObj);
                break;
            case '9':
            case '10':
                $serializer = new Int32Serializer($initObj);
                break;
            case '11':
            case '12':
                $serializer = new Int64Serializer($initObj);
                break;
            case '13':
                $serializer = new FloatSerializer($initObj);
                break;
            case '14':
                $serializer = new DoubleSerializer($initObj);
                break;
            case '15':
                $serializer = new DecimalSerializer($initObj);
                break;
            case '16':
                $serializer = new DateTimeSerializer($initObj);
                break;
            case '18':
                $serializer = new StringSerializer($initObj);
                break;
            case '19':
            case '20':
            case '21':
                $serializer = new ListSerializer($initObj);
                break;
            case '22':
                $serializer = new KeyValueSerializer($initObj);
                break;
            case '23':
                $serializer = new ArraySerializer($initObj);
                break;
            case '24':
            case '25':
                $serializer = new MapSerializer($initObj);
                break;
            case '26':
                $serializer = new SetSerializer($initObj);
                break;
            default:
                $serializer = new ObjectSerializer($initObj);
        }
        return $serializer;
    }

    private static function getSerializerByTypeId($typeId)
    {
        $serializer = null;
        switch ($typeId) {
            case 0:
            case 1:
                $serializer = new NullSerializer();
                break;
            case 2:
                $serializer;
                break;
            case 3:
                $serializer = new BooleanSerializer();
                break;
            case 4:
                $serializer = new CharSerializer();
                break;
            case 5:
            case 6:
                $serializer = new ByteSerializer();
                break;
            case 7:
            case 8:
                $serializer = new Int16Serializer();
                break;
            case 9:
            case 10:
                $serializer = new Int32Serializer();
                break;
            case 11:
            case 12:
                $serializer = new Int64Serializer();
                break;
            case 13:
                $serializer = new FloatSerializer();
                break;
            case 14:
                $serializer = new DoubleSerializer();
                break;
            case 15:
                $serializer = new DecimalSerializer();
                break;
            case 16:
                $serializer = new DateTimeSerializer();
                break;
            case 18:
                $serializer = new StringSerializer();
                break;
            case 19:
            case 20:
            case 21:
                $serializer = new ListSerializer();
                break;
            case 22:
                $serializer = new KeyValueSerializer();
                break;
            case 23:
                $serializer = new ArraySerializer();
                break;
            case 24:
            case 25:
                $serializer = new MapSerializer();
                break;
            case 26:
                $serializer = new SetSerializer();
                break;
            default:
                $serializer = new ObjectSerializer();
        }
        return $serializer;
    }

    private static function getSerializerByType($type)
    {
        $serializer = null;
        switch ($type) {
            case 1:
                $serializer = new NullSerializer();
                break;
            case 2:
                $serializer;
                break;
            case 3:
                $serializer = new BooleanSerializer();
                break;
            case 4:
                $serializer = new CharSerializer();
                break;
            case 5:
            case 6:
                $serializer = new ByteSerializer();
                break;
            case 7:
            case 8:
                $serializer = new Int16Serializer();
                break;
            case 9:
            case 10:
                $serializer = new Int32Serializer();
                break;
            case 11:
            case 12:
                $serializer = new Int64Serializer();
                break;
            case 13:
                $serializer = new FloatSerializer();
                break;
            case 14:
                $serializer = new DoubleSerializer();
                break;
            case 15:
                $serializer = new DecimalSerializer();
                break;
            case 16:
                $serializer = new DateTimeSerializer();
                break;
            case 18:
                $serializer = new StringSerializer();
                break;
            case 19:
            case 20:
            case 21:
                $serializer = new ListSerializer();
                break;
            case 22:
                $serializer = new KeyValueSerializer();
                break;
            case 23:
                $serializer = new ArraySerializer();
                break;
            case 24:
            case 25:
                $serializer = new MapSerializer();
                break;
            case 26:
                $serializer = new SetSerializer();
                break;
            default:
                $serializer = new ObjectSerializer();
        }
        return $serializer;
    }
}