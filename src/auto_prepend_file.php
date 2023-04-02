<?php

ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('Asia/Shanghai');
//define
const WEB_ROOT = '/data/wwwroot/';
const CONFIG_ROOT = '/data/config/';
const LOGS_ROOT = '/data/logs/';
const XHPROF_LIB_ROOT = '/data/xhprof/xhprof_lib/';
const CORE_LIB_ROOT = WEB_ROOT . 'core/';

//include
require_once WEB_ROOT . 'package/vendor/autoload.php';
if (function_exists('core_autoloader')) spl_autoload_register('core_autoloader');
if (function_exists('xhprofRegister')) register_shutdown_function('xhprofRegister');//先进先出

//global
$experiment = new CoreExperiment();
$anticipated = 2;

if (extension_loaded('xhprof')) xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);








