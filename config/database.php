<?php
return [
   'default' => env('DB_CONNECTION'),
   'migrations' => 'migrations',
   'connections' => [
      'pgsql' => [
         'driver' => env('DB_CONNECTION'),
         'host' => env('DB_HOST'),
         'database' => env('DB_DATABASE'),
         'username' => env('DB_USERNAME'),
         'password' => env('DB_PASSWORD'),
         'timezone' => env('DB_TIMEZONE'),
         'charset'   => 'utf8',
         'collation' => 'utf8_unicode_ci',
      ],
      'pgsql2' => [
         'driver' => env('DB2_CONNECTION'),
         'host' => env('DB2_HOST'),
         'database' => env('DB2_DATABASE'),
         'username' => env('DB2_USERNAME'),
         'password' => env('DB2_PASSWORD'),
         'timezone' => env('DB2_TIMEZONE'),
         'charset'   => 'utf8',
         'collation' => 'utf8_unicode_ci',
      ],
   ]
];
