<?php
namespace Thrift\Packages\Fb303;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


interface FacebookServiceIf {
  /**
   * Returns a descriptive name of the service
   * 
   * @return string
   */
  public function getName();
  /**
   * Returns the version of the service
   * 
   * @return string
   */
  public function getVersion();
  /**
   * Gets the status of this service
   * 
   * @return int Common status reporting mechanism across all services
   * 
   */
  public function getStatus();
  /**
   * User friendly description of status, such as why the service is in
   * the dead or warning state, or what is being started or stopped.
   * 
   * @return string
   */
  public function getStatusDetails();
  /**
   * Gets the counters for this service
   * 
   * @return array
   */
  public function getCounters();
  /**
   * Gets the value of a single counter
   * 
   * @param string $key
   * @return int
   */
  public function getCounter($key);
  /**
   * Sets an option
   * 
   * @param string $key
   * @param string $value
   */
  public function setOption($key, $value);
  /**
   * Gets an option
   * 
   * @param string $key
   * @return string
   */
  public function getOption($key);
  /**
   * Gets all options
   * 
   * @return array
   */
  public function getOptions();
  /**
   * Returns a CPU profile over the given time interval (client and server
   * must agree on the profile format).
   * 
   * @param int $profileDurationInSec
   * @return string
   */
  public function getCpuProfile($profileDurationInSec);
  /**
   * Returns the unix time that the server has been running since
   * 
   * @return int
   */
  public function aliveSince();
  /**
   * Tell the server to reload its configuration, reopen log files, etc
   * 
   */
  public function reinitialize();
  /**
   * Suggest a shutdown to the server
   * 
   */
  public function shutdown();
}