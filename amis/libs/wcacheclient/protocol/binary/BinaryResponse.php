<?php

/**
 *
 Byte/     0       |       1       |       2       |       3       |
 /              |               |               |               |
 |0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|
 +---------------+---------------+---------------+---------------+
 0| Magic         | Opcode        | Key Length                    |
 +---------------+---------------+---------------+---------------+
 4| Extras length | Data type     | Status                        |
 +---------------+---------------+---------------+---------------+
 8| Total body length                                             |
 +---------------+---------------+---------------+---------------+
 12| Opaque                                                        |
 +---------------+---------------+---------------+---------------+
 16| CAS                                                           |
 |                                                               |
 +---------------+---------------+---------------+---------------+
 Total 24 bytes
 *
 */

namespace wcacheclient\protocol\binary;
use wcacheclient\exception\WcacheException;
use wcacheclient\common\Constant;
class BinaryResponse
{

    private $HEADER_LENGTH = 24;

    private $magic;

    private $dataType;
    // byte
    private $status;
    // 16����
    private $opAque;
    // int
    private $opCode;
    // int
    private $keyLength;
    // short
    private $extrasLength;
    // byte
    private $totalBodyLength;
    // int
    private $cas;
    // long
    private $bufKey;
    // byte[]
    private $bufExtra;
    // byte[]
    private $bufBody;
    // byte[]
    private $key;
    // String
    public  function fromByte($buf)
    {
        if ($buf == null) {
            throw new WcacheException("data received from server is null , or the operation maybe canceled .");
        }
        if (strlen($buf) < $this->HEADER_LENGTH) {
            throw new WcacheException( "protocol length( strlen($buf) ) less than header length(  $this->HEADER_LENGTH ) .");
        }
        $br = new BinaryResponse();

        $magicArr = unpack('c', $buf);
        $this->magic = $magicArr[1];
        if ($this->magic !== - 127) {
            throw new WcacheException("magic illegal receive magic= $this->magic Magic.RESPONSE_MAGIC=0x81");
        }
        $idx = 1;

        $opCode = substr($buf, $idx, 1);
        $opCodeArr = unpack('c', $opCode);
        $this->opCode = $opCodeArr[1];
        $idx ++;

        $keyLength = substr($buf, $idx, 2);
        $keyLengthArr = unpack('n', $keyLength);
        $this->keyLength = $keyLengthArr[1];
        $idx += 2;

        $extrasLength = substr($buf, $idx, 1);
        $extrasLengthArr = unpack('c', $extrasLength);
        $this->extrasLength = $extrasLengthArr[1];
        $idx ++;

        $dataType = substr($buf, $idx, 1);
        $dataTypeArr = unpack('c', $dataType);
        $this->dataType = $dataTypeArr[1];
        $idx ++;

        $status = substr($buf, $idx, 2);
        $statusArr = unpack('n', $status);
        $this->status = $statusArr[1];
        $idx += 2;

        $totalBodyLength = substr($buf, $idx, 4);
        $totalBodyLengthArr = unpack('N', $totalBodyLength);
        $this->totalBodyLength = $totalBodyLengthArr[1];
        $idx += 4;

        $opAque = substr($buf, $idx, 4);
        $opAqueArr = unpack('N', $opAque);
        $this->opAque = $opAqueArr[1];
        $idx += 4;

        $cas = substr($buf, $idx, 8);
        $casArr = unpack('d', $cas);
        $this->cas = $casArr[1];
        $idx += 8;

        if ($this->extrasLength > 0) {
            $bufextra = substr($buf, $idx, $this->extrasLength);
            $bufextraArr = unpack('a*', $bufextra);
            $this->bufExtra = $bufextraArr[1];
            $idx += $this->extrasLength;
        }

        if ($this->keyLength > 0) {
            $bufKey = substr($buf, $idx, $this->keyLength);
            $bufKeyArr = unpack('a*', $bufKey);
            $this->bufKey = $bufKeyArr[1];
            $idx += $this->keyLength;
        }

        $bodyLen = $this->totalBodyLength - $this->extrasLength - $this->keyLength;
        if ($bodyLen > 0) {
            $bufBody = substr($buf, $idx, $bodyLen );
            $bufBodyArr = unpack('a*', $bufBody);
            $this->bufBody = $bufBodyArr[1];
        }
    }
    
    public  static  function getPacketLen($buf)
    {
        if ($buf == null) {
            throw new WcacheException("data received from server is null , or the operation maybe canceled .");
        }
        if (strlen($buf) != Constant::packet_head) {
            throw new WcacheException( "protocol length( strlen($buf) ) !=  header length(  $this->HEADER_LENGTH ) .");
        }
       
        $magicArr = unpack('c', $buf);
        $magic = $magicArr[1];
        if ($magic !== - 127) {
            throw new WcacheException("magic illegal receive magic= $this->magic Magic.RESPONSE_MAGIC=0x81");
        }
        $idx = 8;
        $totalBodyLength = substr($buf, $idx, 4);
        $totalBodyLengthArr = unpack('N', $totalBodyLength);
        $len = $totalBodyLengthArr[1];
        return $len;
    }
    
    
    
    
    
    /**
     * @return the $HEADER_LENGTH
     */
    public function getHEADER_LENGTH()
    {
        return $this->HEADER_LENGTH;
    }

    /**
     * @return the $magic
     */
    public function getMagic()
    {
        return $this->magic;
    }

    /**
     * @return the $dataType
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return the $opAque
     */
    public function getOpAque()
    {
        return $this->opAque;
    }

    /**
     * @return the $opCode
     */
    public function getOpCode()
    {
        return $this->opCode;
    }

    /**
     * @return the $keyLength
     */
    public function getKeyLength()
    {
        return $this->keyLength;
    }

    /**
     * @return the $extrasLength
     */
    public function getExtrasLength()
    {
        return $this->extrasLength;
    }

    /**
     * @return the $totalBodyLength
     */
    public function getTotalBodyLength()
    {
        return $this->totalBodyLength;
    }

    /**
     * @return the $cas
     */
    public function getCas()
    {
        return $this->cas;
    }

    /**
     * @return the $bufKey
     */
    public function getBufKey()
    {
        return $this->bufKey;
    }

    /**
     * @return the $bufExtra
     */
    public function getBufExtra()
    {
        return $this->bufExtra;
    }

    /**
     * @return the $bufBody
     */
    public function getBufBody()
    {
        return $this->bufBody;
    }

    /**
     * @return the $key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param number $HEADER_LENGTH
     */
    public function setHEADER_LENGTH($HEADER_LENGTH)
    {
        $this->HEADER_LENGTH = $HEADER_LENGTH;
    }

    /**
     * @param mixed $magic
     */
    public function setMagic($magic)
    {
        $this->magic = $magic;
    }

    /**
     * @param mixed $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $opAque
     */
    public function setOpAque($opAque)
    {
        $this->opAque = $opAque;
    }

    /**
     * @param mixed $opCode
     */
    public function setOpCode($opCode)
    {
        $this->opCode = $opCode;
    }

    /**
     * @param mixed $keyLength
     */
    public function setKeyLength($keyLength)
    {
        $this->keyLength = $keyLength;
    }

    /**
     * @param mixed $extrasLength
     */
    public function setExtrasLength($extrasLength)
    {
        $this->extrasLength = $extrasLength;
    }

    /**
     * @param mixed $totalBodyLength
     */
    public function setTotalBodyLength($totalBodyLength)
    {
        $this->totalBodyLength = $totalBodyLength;
    }

    /**
     * @param mixed $cas
     */
    public function setCas($cas)
    {
        $this->cas = $cas;
    }

    /**
     * @param mixed $bufKey
     */
    public function setBufKey($bufKey)
    {
        $this->bufKey = $bufKey;
    }

    /**
     * @param mixed $bufExtra
     */
    public function setBufExtra($bufExtra)
    {
        $this->bufExtra = $bufExtra;
    }

    /**
     * @param mixed $bufBody
     */
    public function setBufBody($bufBody)
    {
        $this->bufBody = $bufBody;
    }

    /**
     * @param field_type $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
    
}