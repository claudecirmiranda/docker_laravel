<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Mostra os caminhos onde as views compiladas serão armazenadas.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | Este é o caminho onde as views compiladas serão armazenadas.
    | Certifique-se de que esta pasta exista e seja gravável.
    |
    */

    'compiled' => storage_path('framework/views'),

];