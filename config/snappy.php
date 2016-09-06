<?php

return array(

    'pdf' => array(
        'enabled' => true,
        'binary'  => env('PDF_PATH', '/usr/local/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => false,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    )

);
