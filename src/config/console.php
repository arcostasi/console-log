<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Console log nice format
    |--------------------------------------------------------------------------
    |
    | This prints out objects in a nice formatted way and
    | his format is not used on output log by default.
    | This changes the log to the dir method.
    |
    */

    'nice_format' => env('CONSOLE_NICE_FORMAT', false),

    /*
    |--------------------------------------------------------------------------
    | Console output empty
    |--------------------------------------------------------------------------
    |
    | Output default if data parameter is empty or null.
    |
    */

    'output_empty' => env('CONSOLE_OUTPUT_EMPTY', ''),

];