<?php
namespace Thrift;

use Thrift\Exception\TException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Protocol\TProtocolDecorator;
use Thrift\Type\TMessageType;


class TMultiplexedProcessor
{
    private $serviceProcessorMap_;

    /**
     * 'Register' a service with this <code>TMultiplexedProcessor</code>.  This
     * allows us to broker requests to individual services by using the service
     * name to select them at request time.
     *
     * @param serviceName Name of a service, has to be identical to the name
     * declared in the Thrift IDL, e.g. "WeatherReport".
     * @param processor Implementation of a service, usually referred to
     * as "handlers", e.g. WeatherReportHandler implementing WeatherReport.Iface.
     */
    public function registerProcessor($serviceName, $processor)
    {
        $this->serviceProcessorMap_[$serviceName] = $processor;
    }

    /**
     * This implementation of <code>process</code> performs the following steps:
     *
     * <ol>
     *     <li>Read the beginning of the message.</li>
     *     <li>Extract the service name from the message.</li>
     *     <li>Using the service name to locate the appropriate processor.</li>
     *     <li>Dispatch to the processor, with a decorated instance of TProtocol
     *         that allows readMessageBegin() to return the original Message.</li>
     * </ol>
     *
     * @throws TException If the message type is not CALL or ONEWAY, if
     *                    the service name was not found in the message, or if the service
     *                    name was not found in the service map.
     */
    public function process(TProtocol $input, TProtocol $output)
    {
        /*
            Use the actual underlying protocol (e.g. TBinaryProtocol) to read the
            message header. This pulls the message "off the wire", which we'll
            deal with at the end of this method.
        */
        $input->readMessageBegin($fname, $mtype, $rseqid);

        if ($mtype !== TMessageType::CALL && $mtype != TMessageType::ONEWAY) {
            throw new TException("This should not have happened!?");
        }

        // Extract the service name and the new Message name.
        if (strpos($fname, TMultiplexedProtocol::SEPARATOR) === false) {
            throw new TException("Service name not found in message name: {$fname}. Did you " .
                "forget to use a TMultiplexProtocol in your client?");
        }
        list($serviceName, $messageName) = explode(':', $fname, 2);
        if (!array_key_exists($serviceName, $this->serviceProcessorMap_)) {
            throw new TException("Service name not found: {$serviceName}.  Did you forget " .
                "to call registerProcessor()?");
        }