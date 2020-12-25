<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

use com\bj58\spat\scf\protocol\utility\ByteConverter;
class SSMReqProtocol
{
    private static $HEADLEN = 9;//int
    private $version = 1;//byte
    private $totalLen;//int
    private $type;//int
    private $body = null;//byte[]

    public function dataCreate($recv)
    {
        $len = strlen($recv);
        $data = '';
        $this->body = $recv;
        try {
            if (null !== $recv) {
                $dataLen = SSMReqProtocol::$HEADLEN + $len;
                $data = ByteConverter::intToBytesBigEndian($dataLen);
            } else {
                $data = ByteConverter::intToBytesBigEndian(SSMReqProtocol::$HEADLEN);
            }
            $ver = pack('c', self::getVersion());
            $data = $data . $ver;
            $data = $data . ByteConverter::intToBytesBigEndian(self::getType());

            if (null !== $this->body) {
                $data = $data . $this->body;
            }
            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
        return null;
    }

    public static function fromBytes($buf)
    {
        try {
            $rp = new SSMReqProtocol();
            $index = 0;
            $totalLen = substr($buf, 0, 4);
            $totalLen = ByteConverter::bytesToIntBigEndian($totalLen);
            $rp->setTotalLen($totalLen);
            $index = $index + 4;

            $version = substr($buf, $index, 1);
            $version = unpack('c', $version);
            $rp->setVersion($version);
            $index = $index + 1;

            $type = substr($buf, $index, 4);
            $type = ByteConverter::bytesToIntBigEndian($type);
            $rp->setType($type);
            $index = $index + 4;

            $body = substr($buf, $index);
            $rp->setBody($body);

            return $rp;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function getTotalLen()
    {
        return $this->totalLen;
    }

    public function setTotalLen($totalLen)
    {
        $this->totalLen = $totalLen;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}

?>