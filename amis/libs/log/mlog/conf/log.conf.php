<?php

namespace Libs\Log\MLog\Conf;

class MLogConfig {
    // 日志级别
    //  1：打印FATAL
    //  2：打印FATAL和WARNING
    //  4：打印FATAL、WARNING、NOTICE（线上程序正常运行时的配置）
    //  8：打印FATAL、WARNING、NOTICE、TRACE（线上程序异常时使用该配置）
    // 16：打印FATAL、WARNING、NOTICE、TRACE、DEBUG（测试环境配置） 
    public static $level = 16;

    // 是否按小时自动分日志，设置为1时，日志被打在xx.log.2011010101
    public static $auto_rotate = 1;

    // 日志文件路径是否增加一个基于app名称的子目录，例如：log/app1/app1.log
    // 该配置对于default app同样生效
    public static $use_sub_dir = 1;

    // 日志格式 
    public static $format = '%L: %{%y-%m-%d %H:%M:%S}t %{app}x * %{pid}x  client_ip[%a] local_ip[%A] logid[%l] filename[%f] lineno[%N] uri[%U] errno[%{err_no}x] %{encoded_str_array}x  %{err_msg}x';
    public static $format_wf = '%L: %{%y-%m-%d %H:%M:%S}t %{app}x * %{pid}x  client_ip[%a] local_ip[%A] logid[%l] filename[%f] lineno[%N] uri[%U] errno[%{err_no}x] %{encoded_str_array}x  %{err_msg}x';
    public static $format_fatal = '%L: %{%y-%m-%d %H:%M:%S}t %{app}x * %{pid}x  client_ip[%a] local_ip[%A] logid[%l] filename[%f] lineno[%N] uri[%U] errno[%{err_no}x] %{encoded_str_array}x  %{err_msg}x %{backtrace}x';

    // 提供绝对路径，日志存放的默认根目录
    public static $log_path =  LOG_PATH;
    // 提供绝对路径，日志格式数据存放的默认根目录
    public static $data_path = LOG_PATH . '.data';
}
