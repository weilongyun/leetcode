<?php
namespace Thrift\Packages\Hive;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


interface TCLIServiceIf {
  /**
   * @param \Thrift\Packages\Hive\TOpenSessionReq $req
   * @return \Thrift\Packages\Hive\TOpenSessionResp
   */
  public function OpenSession(\Thrift\Packages\Hive\TOpenSessionReq $req);
  /**
   * @param \Thrift\Packages\Hive\TCloseSessionReq $req
   * @return \Thrift\Packages\Hive\TCloseSessionResp
   */
  public function CloseSession(\Thrift\Packages\Hive\TCloseSessionReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetInfoReq $req
   * @return \Thrift\Packages\Hive\TGetInfoResp
   */
  public function GetInfo(\Thrift\Packages\Hive\TGetInfoReq $req);
  /**
   * @param \Thrift\Packages\Hive\TExecuteStatementReq $req
   * @return \Thrift\Packages\Hive\TExecuteStatementResp
   */
  public function ExecuteStatement(\Thrift\Packages\Hive\TExecuteStatementReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetTypeInfoReq $req
   * @return \Thrift\Packages\Hive\TGetTypeInfoResp
   */
  public function GetTypeInfo(\Thrift\Packages\Hive\TGetTypeInfoReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetCatalogsReq $req
   * @return \Thrift\Packages\Hive\TGetCatalogsResp
   */
  public function GetCatalogs(\Thrift\Packages\Hive\TGetCatalogsReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetSchemasReq $req
   * @return \Thrift\Packages\Hive\TGetSchemasResp
   */
  public function GetSchemas(\Thrift\Packages\Hive\TGetSchemasReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetTablesReq $req
   * @return \Thrift\Packages\Hive\TGetTablesResp
   */
  public function GetTables(\Thrift\Packages\Hive\TGetTablesReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetTableTypesReq $req
   * @return \Thrift\Packages\Hive\TGetTableTypesResp
   */
  public function GetTableTypes(\Thrift\Packages\Hive\TGetTableTypesReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetColumnsReq $req
   * @return \Thrift\Packages\Hive\TGetColumnsResp
   */
  public function GetColumns(\Thrift\Packages\Hive\TGetColumnsReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetFunctionsReq $req
   * @return \Thrift\Packages\Hive\TGetFunctionsResp
   */
  public function GetFunctions(\Thrift\Packages\Hive\TGetFunctionsReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetOperationStatusReq $req
   * @return \Thrift\Packages\Hive\TGetOperationStatusResp
   */
  public function GetOperationStatus(\Thrift\Packages\Hive\TGetOperationStatusReq $req);
  /**
   * @param \Thrift\Packages\Hive\TCancelOperationReq $req
   * @return \Thrift\Packages\Hive\TCancelOperationResp
   */
  public function CancelOperation(\Thrift\Packages\Hive\TCancelOperationReq $req);
  /**
   * @param \Thrift\Packages\Hive\TCloseOperationReq $req
   * @return \Thrift\Packages\Hive\TCloseOperationResp
   */
  public function CloseOperation(\Thrift\Packages\Hive\TCloseOperationReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetResultSetMetadataReq $req
   * @return \Thrift\Packages\Hive\TGetResultSetMetadataResp
   */
  public function GetResultSetMetadata(\Thrift\Packages\Hive\TGetResultSetMetadataReq $req);
  /**
   * @param \Thrift\Packages\Hive\TFetchResultsReq $req
   * @return \Thrift\Packages\Hive\TFetchResultsResp
   */
  public function FetchResults(\Thrift\Packages\Hive\TFetchResultsReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetDelegationTokenReq $req
   * @return \Thrift\Packages\Hive\TGetDelegationTokenResp
   */
  public function GetDelegationToken(\Thrift\Packages\Hive\TGetDelegationTokenReq $req);
  /**
   * @param \Thrift\Packages\Hive\TCancelDelegationTokenReq $req
   * @return \Thrift\Packages\Hive\TCancelDelegationTokenResp
   */
  public function CancelDelegationToken(\Thrift\Packages\Hive\TCancelDelegationTokenReq $req);
  /**
   * @param \Thrift\Packages\Hive\TRenewDelegationTokenReq $req
   * @return \Thrift\Packages\Hive\TRenewDelegationTokenResp
   */
  public function RenewDelegationToken(\Thrift\Packages\Hive\TRenewDelegationTokenReq $req);
  /**
   * @param \Thrift\Packages\Hive\TGetLogReq $req
   * @return \Thrift\Packages\Hive\TGetLogResp
   */
  public function GetLog(\Thrift\Packages\Hive\TGetLogReq $req);
}