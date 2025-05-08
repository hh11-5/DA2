<?php

use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GeoPlugin\GeoPlugin;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Http\Client\Curl\Client;

return [
    'providers' => [
        \Geocoder\Provider\Nominatim\Nominatim::class => [
            'https://nominatim.openstreetmap.org', // Hoặc URL cục bộ
            'watchstore/0.1a (clone001.wog@gmail.com)', // User-Agent
        ],
    ],
    'cache' => [
        'enabled' => true,
        'duration' => 86400, // Cache 24 giờ
        'store' => 'file', // Lưu cache vào file
    ],
    'timeout' => 5, // Timeout 5 giây
    'locale' => 'vi', // Ngôn ngữ Vietnamese
];
