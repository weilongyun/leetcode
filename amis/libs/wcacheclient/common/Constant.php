<?php
namespace wcacheclient\common;

/**
 * @author 58
 * libmemcached result code : 
 * libmemcached doc : http://docs.libmemcached.org/
 */
class Constant
{
    const packet_head = 24;

    const min_result_index = 0;

    const max_reult_index = 49;

    public static  $memcached_result =  array(
        0 => "MEMCACHED_SUCCESS",
        1 => "MEMCACHED_FAILURE",
        2 => "MEMCACHED_HOST_LOOKUP_FAILURE",
        3 => "MEMCACHED_CONNECTION_FAILURE",
        4 => "MEMCACHED_CONNECTION_BIND_FAILURE",
        5 => "MEMCACHED_WRITE_FAILURE",
        6 => "MEMCACHED_READ_FAILURE",
        7 => "MEMCACHED_UNKNOWN_READ_FAILURE", /*An unknown read failure only occurs when either there is a bug in the server, or in rare cases where an ethernet nic is reporting dubious information.*/
        8 => "MEMCACHED_PROTOCOL_ERROR",
        9 => "MEMCACHED_CLIENT_ERROR",
        10 => "MEMCACHED_SERVER_ERROR",
        11 => "MEMCACHED_ERROR",
        12 => "MEMCACHED_DATA_EXISTS",
        13 => "MEMCACHED_DATA_DOES_NOT_EXIST",
        14 => "MEMCACHED_NOTSTORED",
        15 => "MEMCACHED_STORED",
        16 => "MEMCACHED_NOTFOUND",
        17 => "MEMCACHED_MEMORY_ALLOCATION_FAILURE",
        18 => "MEMCACHED_PARTIAL_READ",
        19 => "MEMCACHED_SOME_ERRORS",
        20 => "MEMCACHED_NO_SERVERS",
        21 => "MEMCACHED_END",
        22 => "MEMCACHED_DELETED",
        23 => "MEMCACHED_VALUE",
        24 => "MEMCACHED_STAT",
        25 => "MEMCACHED_ITEM",
        26 => "MEMCACHED_ERRNO",
        27 => "MEMCACHED_FAIL_UNIX_SOCKET",
        28 => "MEMCACHED_NOT_SUPPORTED",
        29 => "MEMCACHED_NO_KEY_PROVIDED",
        30 => "MEMCACHED_FETCH_NOTFINISHED",
        31 => "MEMCACHED_TIMEOUT",
        32 => "MEMCACHED_BUFFERED",
        33 => "MEMCACHED_BAD_KEY_PROVIDED", /*The key provided is not a valid key.*/
        34 => "MEMCACHED_INVALID_HOST_PROTOCOL",
        35 => "MEMCACHED_SERVER_MARKED_DEAD",
        36 => "MEMCACHED_UNKNOWN_STAT_KEY",
        37 => "MEMCACHED_E2BIG", /*Item is too large for the server to store.*/
        38 => "MEMCACHED_INVALID_ARGUMENTS",
        39 => "MEMCACHED_KEY_TOO_BIG",
        40 => "MEMCACHED_AUTH_PROBLEM",
        41 => "MEMCACHED_AUTH_FAILURE",
        42 => "MEMCACHED_AUTH_CONTINUE",
        43 => "MEMCACHED_PARSE_ERROR",
        44 => "MEMCACHED_PARSE_USER_ERROR",
        45 => "MEMCACHED_DEPRECATED",
        46 => "MEMCACHED_IN_PROGRESS",
        47 => "MEMCACHED_SERVER_TEMPORARILY_DISABLED",
        48 => "MEMCACHED_SERVER_MEMORY_ALLOCATION_FAILURE",
        49 => "MEMCACHED_MAXIMUM_RETURN"
    );
}

