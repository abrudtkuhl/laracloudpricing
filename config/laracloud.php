<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Cloud Pricing Configuration
    |--------------------------------------------------------------------------
    |
    | Stores pricing data for various Laravel Cloud resources and plans.
    | Prices are generally based on the us-ohio region unless specified.
    |
    */

    'plans' => [
        'sandbox' => ['price_monthly' => 0, 'label' => 'Sandbox'],
        'production' => ['price_monthly' => 20, 'label' => 'Production'],
        'business' => ['price_monthly' => 200, 'label' => 'Business'],
    ],

    'compute' => [
        'us-ohio' => [
            // Flex
            'flex-1c-256m' => ['cpu' => 1, 'ram_gb' => 0.25, 'price_monthly' => 4.89, 'price_hourly' => 0.0067, 'label' => 'Flex: 1 vCPU / 256MB RAM'], // Added hourly rate
            'flex-1c-512m' => ['cpu' => 1, 'ram_gb' => 0.5, 'price_monthly' => 6.42, 'label' => 'Flex: 1 vCPU / 512MB RAM'],
            'flex-1c-1g' => ['cpu' => 1, 'ram_gb' => 1, 'price_monthly' => 10.15, 'label' => 'Flex: 1 vCPU / 1GB RAM'],
            'flex-2c-1g' => ['cpu' => 2, 'ram_gb' => 1, 'price_monthly' => 12.85, 'label' => 'Flex: 2 vCPU / 1GB RAM'],
            'flex-2c-2g' => ['cpu' => 2, 'ram_gb' => 2, 'price_monthly' => 20.29, 'label' => 'Flex: 2 vCPU / 2GB RAM'],
            // Pro (Example Sizes)
            'pro-1c-2g' => ['cpu' => 1, 'ram_gb' => 2, 'price_monthly' => 25.70, 'label' => 'Pro: 1 vCPU / 2GB RAM'],
            'pro-2c-4g' => ['cpu' => 2, 'ram_gb' => 4, 'price_monthly' => 51.39, 'label' => 'Pro: 2 vCPU / 4GB RAM'],
            'pro-4c-8g' => ['cpu' => 4, 'ram_gb' => 8, 'price_monthly' => 102.78, 'label' => 'Pro: 4 vCPU / 8GB RAM'],
        ]
        // Add other regions here...
    ],

    'database' => [
        'us-ohio' => [
            'mysql' => [
                'sizes' => [
                    'mysql-flex-1c-512m' => ['cpu' => 1, 'ram_gb' => 0.5, 'price_monthly' => 5.47, 'label' => 'MySQL Flex: 1 vCPU / 512MB RAM'],
                    'mysql-flex-1c-1g' => ['cpu' => 1, 'ram_gb' => 1, 'price_monthly' => 10.95, 'label' => 'MySQL Flex: 1 vCPU / 1GB RAM'],
                    'mysql-flex-1c-2g' => ['cpu' => 1, 'ram_gb' => 2, 'price_monthly' => 21.90, 'label' => 'MySQL Flex: 1 vCPU / 2GB RAM'],
                    'mysql-pro-1c-4g' => ['cpu' => 1, 'ram_gb' => 4, 'price_monthly' => 49.35, 'label' => 'MySQL Pro: 1 vCPU / 4GB RAM'],
                    'mysql-pro-2c-8g' => ['cpu' => 2, 'ram_gb' => 8, 'price_monthly' => 98.70, 'label' => 'MySQL Pro: 2 vCPU / 8GB RAM'],
                ],
                'storage_price_gb_month' => 0.20,
            ],
            'postgres' => [
                'cpu_price_per_hour' => 0.16, // Per vCPU hour
                'storage_price_gb_month' => 1.50,
                'min_cpu' => 0.25,
            ]
        ]
        // Add other regions here...
    ],

    'kv' => [
        '250mb' => ['storage_mb' => 250, 'price_monthly' => 7, 'label' => '250MB'],
        '1gb' => ['storage_mb' => 1000, 'price_monthly' => 20, 'label' => '1GB'],
        '2.5gb' => ['storage_mb' => 2500, 'price_monthly' => 40, 'label' => '2.5GB'],
        '5gb' => ['storage_mb' => 5000, 'price_monthly' => 77, 'label' => '5GB'],
        '12gb' => ['storage_mb' => 12000, 'price_monthly' => 180, 'label' => '12GB'],
        '50gb' => ['storage_mb' => 50000, 'price_monthly' => 280, 'label' => '50GB'],
        '100gb' => ['storage_mb' => 100000, 'price_monthly' => 680, 'label' => '100GB'],
    ],

    'object_storage' => [
        'storage_price_gb_month' => 0.02,
        'class_a_price_per_thousand' => 0.005,
        'class_b_price_per_thousand' => 0.0005,
    ],

    'usage_allowances' => [
        'data_transfer' => [
            'sandbox' => 10,    // GB
            'production' => 100, // GB
            'business' => 1000, // GB (1 TB)
            'price_per_gb' => 0.10,
        ],
        'requests' => [
            'sandbox' => 1,     // Millions
            'production' => 10,    // Millions
            'business' => 100,   // Millions
            'price_per_million' => 1.00, // $1 per additional million
        ],
        'custom_domains' => [
            'sandbox' => 0,
            'production' => 3,
            'business' => 10,
            // No price for additional domains mentioned
        ],
        'users' => [
            'sandbox' => 3,
            'production' => 3,
            'business' => 10,
            'additional_user_price' => 10.00,
        ],
    ],

    'hours_per_month' => 730, // Average hours in a month for estimations
]; 