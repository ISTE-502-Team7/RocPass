<?php namespace App\Lib;

     use Monolog\ErrorHandler;
     use Monolog\Handler\StreamHandler;

     class Logger extends \Monolog\Logger
     {
         private static $loggers = [];

         private static $LOG_PATH;
         private static $data;

         public function __construct($key='app', $config=null)
         {
            parent::__construct($key);

            if(empty($config)) {
                $LOG_PATH = Config::get('LOG_PATH', __DIR__.'/../../logs');
                $config = [
                    'logFile' => "{$LOG_PATH}/{$key}.log",
                    'logLevel' => \Monolog\Logger::DEBUG
                ];
                $data = [
                    $_SERVER,
                    $_REQUEST,
                    trim(file_get_contents("php://input"))
                ];
            }

            $this->pushHandler(new StreamHandler($config['logFile'], $config['logLevel']));

         }

         public static function getInstance($key = 'app', $config=null)
         {
             if(empty(self::$loggers[$key])) {
                 self::$loggers[$key] = new Logger($key, $config);
             }

             return self::$loggers[$key];
         }

         public static function enableSystemLogs()
         {
             $LOG_PATH = Config::get('LOG_PATH', __DIR__.'/../../logs');

             self::$loggers['error'] = new Logger('errors');
             self::$loggers['error']->pushHandler(new StreamHandler("{$LOG_PATH}/errorslog"));
             ErrorHandler::register(self::$loggers['error']);

             self::$loggers['request'] = new Logger('request');
             self::$loggers['request']->pushHandler(new StreamHandler("{$LOG_PATH}/request.log"));
             self::$loggers['request']->info("REQUEST", self::$data);
         }

         public static function potentialAttacks()
         {
            $LOG_PATH = Config::get('LOG_PATH', __DIR__.'/../../logs');

            self::$loggers['request'] = new Logger('request');
            self::$loggers['request']->pushHandler(new StreamHandler("{$LOG_PATH}/potentialAttacks.log"));
            self::$loggers['request']->info("REQUEST", self::$data);

         }
     }
?>