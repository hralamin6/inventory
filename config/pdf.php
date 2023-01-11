<?php

return [
    'custom_font_dir' => base_path('resources/fonts/'),
    'custom_font_data' => [
        'n' => [
            'R'  => 'Nikosh.ttf',    // regular font
            'useOTL' => 0xFF,
            'useKashida' => 222,
        ],
        'a' => [
            'R'  => 'a.ttf',    // regular font
            'useOTL' => 0xFF,
            'useKashida' => 222,
        ],
        'b' => [
            'R'  => 'b.ttf',    // regular font
            'useOTL' => 0xFF,
            'useKashida' => 222,
        ],
    ],
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'hr alamin',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
//    'tempDir'               => base_path('storage/app/mpdf'),

    'default_font_size'          => '12',
    'default_font'               => 'sans-serif',
    'margin_left'                => 10,
    'margin_right'               => 10,
    'margin_top'                 => 10,
    'margin_bottom'              => 10,
    'margin_header'              => 0,
    'margin_footer'              => 0,
    'orientation'                => 'P',
//    'temp_dir'                   => storage_path('app'),
];
