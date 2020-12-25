<?php

/**
 *
 Request header:
 
 Byte/     0       |       1       |       2       |       3       |
 /              |               |               |               |
 |0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|0 1 2 3 4 5 6 7|
 +---------------+---------------+---------------+---------------+
 0| Magic         | Opcode        | Key length                    |
 +---------------+---------------+---------------+---------------+
 4| Extras length | Data type     | Reserved                      |
 +---------------+---------------+---------------+---------------+
 8| Total body length                                             |
 +---------------+---------------+---------------+---------------+
 12| Opaque                                                        |
 +---------------+---------------+---------------+---------------+
 16| CAS                                                           |
 |                                                               |
 +---------------+---------------+---------------+---------------+
 Total 24 bytes
 
 
 Header fields:
 Magic               Magic number.
 Opcode              Command code.
 Key length          Length in bytes of the text key that follows the
 command extras.
 Status              Status of the response (non-zero on error).
 Extras length       Length in bytes of the command extras.
 Data type           Reserved for future use (Sean is using this
 soon).
 Reserved            Really reserved for future use (up for grabs).
 Total body length   Length in bytes of extra + key + value.
 Opaque              Will be copied back to you in the response.
 CAS                 Data version check.
 */

namespace wcacheclient\protocol\binary;

class BinaryRequest
{

    private $HEADER_LENGTH = 24;

    private $magic = '0x80';
    // byte 1
    private $opCode = '0x60';
    // byte 1
    private $keyLength;
    // short 2
    private $extrasLength;
    // byte 1
    private $dataType;
    // byte 1
    private $reserved;
    // short 2
    private $totalBodyLength;
    // int 4
    private $opAque;
    // int 4
    private $cas;
    // long 8
    private $bufKey;
    // byte[]
    private $bufExtra;
    // byte[]
    private $bufBody = '0.0.1.php';
    // byte[]
    private $key;
    // string
    private $isAsync = false;

    private $totalLen;

    public  function toBytes($clusterId)
    {
        $this->key = $clusterId;
        $this->bufKey = $this->key;
        $this->keyLength = $this->bufKey == null ? 0 : strlen($this->bufKey);
        
        $this->extrasLength = $this->bufExtra == null ? 0 : strlen($this->bufExtra);
        
        $this->totalBodyLength = $this->bufBody == null ? ($this->keyLength + $this->extrasLength) : ($this->keyLength + $this->extrasLength + strlen($this->bufBody) + 1);
        
        $this->totalLen = $this->HEADER_LENGTH + $this->totalBodyLength;
        
        $buf = '';
        $magic_int = base_convert($this->magic, 16, 10);
        $buf = pack('c', $magic_int);
        
        $opCode_int = base_convert($this->opCode, 16, 10);
        $buf .= pack('c', $opCode_int);
        
        $data = pack('n', $this->keyLength);
        $buf .= $data;
        
        $buf .= pack('c', $this->extrasLength);
        
        $buf .= pack('c', $this->dataType);
        
        $buf .= pack('n', $this->reserved);
        
        $buf .= pack('N', $this->totalBodyLength);
        
        $buf .= pack('N', $this->opAque);
        
        $buf .= pack('d', $this->cas);
        
        if ($this->bufExtra != null) {
            $buf .= pack('a*', $this->bufExtra);
        }
        
        if ($this->bufKey != null) {
            $buf .= pack('a*', $this->bufKey);
        }
        
        if ($this->bufBody != null) {
            $buf .= pack('c', strlen($this->bufBody));
            $buf .= pack('a*', $this->bufBody);
        }
        
        return $buf;
    }
}
