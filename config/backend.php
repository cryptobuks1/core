<?php

return [
    
	/*
    |--------------------------------------------------------------------------
    | General Configuration
    |--------------------------------------------------------------------------
    */
    
	'backendRoute' => env('BACKEND_URI'),
    'template'     => 'backend',
    'cryptKey'     => 'A1Qea1AEX6O1I0AdQLENH92g8A5TC1wHVhnruQpFag0=',
    'licenseKey'   => 'g9Qea1AEX6O1I0JdQLENH92g8A5TF1wHVhnruQpCag0=',
    
    /*
    |--------------------------------------------------------------------------
    | Uploads Configuration
    |--------------------------------------------------------------------------
    |
    | private_uploads: Show that uploaded file remains private and can be seen by respective owners only
    | default_uploads_security: public / private
    | 
    */
    'uploads' => [
        'private_uploads' => false,
        'default_public' => false,
        'allow_filename_change' => true
    ],
];