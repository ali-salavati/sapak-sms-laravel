<?php

/**
 * Sapak SMS Configuration File.
 *
 * This file is published to config/sapak.php
 *
 * How to get API Key:
 * @see https://docs.sapak.me/
 */
return [

    /**
     * Your Sapak API Key.
     * This is retrieved from your .env file.
     */
    'api_key' => env('SAPAK_API_KEY'),

    /**
     * (Optional) Guzzle HTTP client options.
     * You can pass any valid Guzzle configuration here.
     * @see https://docs.guzzlephp.org/en/stable/request-options.html
     */
    'guzzle_config' => [
        // e.g., 'timeout' => 10.0,
    ],

];