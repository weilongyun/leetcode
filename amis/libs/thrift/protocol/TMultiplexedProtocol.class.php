<?php
namespace Thrift\Protocol;

use Thrift\Type\TMessageType;


class TMultiplexedProtocol extends TProtocolDecorator
{
    /**
     * Separator between service name and function name.
     * Should be the same as used at multiplexed Thrift server.
     *
     * @var string
     */
    const SEPARATOR = ":";

    /**
     * The name of service.
     *
     * @var string
     */
    private $serviceName_;

    /**
     * Constructor of <code>TMultiplexedProtocol</code> class.
     *
     * Wrap the specified protocol, allowing it to be used to communicate with a
     * multiplexing server.  The <code>$serviceName</code> is required as it is
     * prepended to the message header so that the multiplexing server can broker
     * the function call to the proper service.
     *
     * @param TProtocol $protocol
     * @param string    $serviceName The name of service.
     */
    public function __construct(TProtocol $protocol, $serviceName)
    {
        parent::__construct($protocol);
        $this->serviceName_ = $serviceName;
    }

    /**
     * Writes the message header.
     * Prepends the service name to the function name, separated by <code>TMultiplexedProtocol::SEPARATOR</code>.
     *
     * @param string $name  Function name.
     * @param int    $type  Message type.
     * @param int    $seqid The sequence id of this message.
     */
    public function writeMessageBegin($name, $type, $seqid)
    {
        if ($type == TMessageType::CALL || $type == TMessageType::ONEWAY) {
            $nameWithService = $this->serviceName_ . self::SEPARATOR . $name;
            parent::writeMessageBegin($nameWithService, $type, $seqid);
        } else {
            parent::writeMessageBegin($name, $type, $seqid);
        }
    }
}