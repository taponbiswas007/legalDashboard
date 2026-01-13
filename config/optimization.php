<?php

/**
 * ========================================
 * VPS OPTIMIZATION CONFIGURATION
 * ========================================
 *
 * Optimized for: 2 Core CPU, 2GB RAM, 40GB SSD
 * Purpose: Maximize performance and reduce loading times
 */

return [
    /*
    |--------------------------------------------------------------------------
    | DATABASE OPTIMIZATION
    |--------------------------------------------------------------------------
    */
    'database' => [
        // Connection pool size (for 2GB RAM, keep conservative)
        'pool_size' => 5,
        'pool_timeout' => 30,

        // Query optimization
        'query_cache_enabled' => true,
        'query_cache_size' => '32M', // MySQL query cache

        // Indexes to add
        'indexes_to_add' => [
            'addcases' => [
                'file_number',
                'client_id',
                'court_id',
                'branch_id',
                'status',
                'filing_or_received_date',
                'next_hearing_date',
            ],
            'addclients' => ['email', 'phone', 'name'],
            'courts' => ['name'],
            'users' => ['email'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CACHING STRATEGY
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'driver' => 'redis', // or 'file' if Redis not available
        'ttl' => 3600, // Cache for 1 hour

        // Cache frequently accessed data
        'cache_lists' => [
            'courts' => 3600,
            'clients' => 1800,
            'branches' => 3600,
            'statuses' => 7200,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | LARAVEL OPTIMIZATION
    |--------------------------------------------------------------------------
    */
    'laravel' => [
        // Optimize autoloader
        'optimize_autoloader' => true,

        // Cache configuration
        'cache_config' => true,
        'cache_routes' => true,

        // Eager loading
        'eager_load_relations' => true,

        // Pagination
        'default_per_page' => 15,
        'max_per_page' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | SESSION OPTIMIZATION
    |--------------------------------------------------------------------------
    */
    'session' => [
        'driver' => 'cookie', // Stateless, faster for small VPS
        'lifetime' => 120, // 2 hours
        'gc_divisor' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | QUEUE OPTIMIZATION
    |--------------------------------------------------------------------------
    */
    'queue' => [
        'driver' => 'sync', // Use sync for small operations, database for heavy
        'heavy_operations_driver' => 'database',
    ],

    /*
    |--------------------------------------------------------------------------
    | ASSET OPTIMIZATION
    |--------------------------------------------------------------------------
    */
    'assets' => [
        // Minification
        'minify_js' => true,
        'minify_css' => true,

        // Compression
        'gzip_enabled' => true,
        'gzip_level' => 6,

        // Image optimization
        'optimize_images' => true,
        'image_max_width' => 2000,
    ],

    /*
    |--------------------------------------------------------------------------
    | FILE UPLOAD SETTINGS
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'max_size' => 2048, // 2MB
        'allowed_mimes' => [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'image/jpeg',
            'image/png',
            'image/gif',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | FIELD LENGTH STANDARDS
    |--------------------------------------------------------------------------
    */
    'field_lengths' => [
        'email' => 255,
        'phone' => 20,
        'name' => 255,
        'file_number' => 100,
        'case_number' => 100,
        'cin' => 50,
        'section' => 100,
        'step_text' => 255,
        'parties' => 500,
        'description' => 1000,
        'address' => 500,
        'url' => 255,
    ],
];
