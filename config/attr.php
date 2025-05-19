<?php

return [
    'sitemap' => '1000',
    'page_limit' => '12',
    'update' => 'update/',
    'poster' => [
        'path' => 'uploads/poster/',
        'subtitle_path' => 'uploads/subtitle/',
        'episode_path' => 'uploads/episode/',
        'size_x' => '300',
        'size_y' => '450',
        'cover_size_x' => '1280',
        'cover_size_y' => '720',
        'episode_size_x' => '240',
        'episode_size_y' => '135',
        'broadcast_size_x' => '256',
        'broadcast_size_y' => '256',
        'broadcast_cover_size_x' => '1280',
        'broadcast_cover_size_y' => '720',
        'story_x' => '200',
        'story_y' => '200',
        'slide_x' => '1920',
        'slide_y' => '800',
        'banner_x' => '400',
        'banner_y' => '250',
    ],
    'favicon' => [
        'path' => 'favicon/',
        'sizes' => [
            '192' => 'android-chrome-192x192',
            '512' => 'android-chrome-512x512',
            '180' => 'apple-touch-icon.',
            '16' => 'favicon-16x16',
            '32' => 'favicon-32x32',
            '150' => 'mstile-150x150'
        ],
    ],
    'manifest' => [
        'name' => '',
        'short_name' => [
            [
                "src" => "/android-chrome-192x192.png",
                "sizes" => "192x192",
                "type" => "image/png"
            ],
            [
                "src" => "/android-chrome-512x512.png",
                "sizes" => "512x512",
                "type" => "image/png"
            ]
        ],
        "theme_color" => "#ffffff",
        "background_color" => "#ffffff",
        "display" => "standalone"
    ],
    'people' => [
        'path' => 'uploads/people/',
        'size_x' => '300',
        'size_y' => '300',
    ],
    'avatar' => [
        'path' => 'uploads/user/',
        'cover_x' => '1536',
        'cover_y' => '256',
        'thumb' => '120',
    ],
    'tinymce' => [
        'path' => 'uploads/tinymce/',
        'large_x' => '860',
    ],
    'article' => [
        'path' => 'uploads/article/',
        'size_x' => '1280',
        'size_y' => '720',
        'thumb_size_x' => '400',
        'thumb_size_y' => '260',
    ],
    'onesignal' => [
        'path' => 'uploads/onesignal/',
        'size_x' => '512',
        'size_y' => '256'
    ],
    'streams' => [
        'embed' => 'Embed link',
        'mp4' => 'Mp4 link',
        'hls' => 'HLS (.m3u8)',
        'download' => 'Download',
    ],
    'lives' => [
        'embed' => 'Embed link',
        'hls' => 'HLS (.m3u8)',
        'youtube' => 'Youtube',
    ],
    'types' => [
        'movie' => 'Movie',
        'tv' => 'TV Show',
    ],
    'quality' => [
        '4K',
        'HD',
        'SD',
        'CAM',
    ],
    'reports' => [
        '1' => 'Wrong video',
        '2' => 'Audio not synced',
        '3' => 'Subtitle not synced',
    ],
    'gender' => [
        '1' => 'Female',
        '2' => 'Male',
        '3' => 'Other',
    ],
    'tmdb' => [
        'sortable' => [
            'popularity.desc' => 'Most popular',
            'primary_release_date.desc' => 'New release',
            'vote_average.desc' => 'Top rated'
        ],
        'type' => [
            'movie' => 'Movie',
            'tv' => 'TV Show',
        ]
    ],
    'sortable' => [
        'created_at' => [
            'title' => 'Newest',
            'type' => 'created_at',
            'order' => 'desc',
        ],
        'view' => [
            'title' => 'Most viewed',
            'type' => 'view',
            'order' => 'desc',
        ],
        'release_date' => [
            'title' => 'Release date',
            'type' => 'release_date',
            'order' => 'desc',
        ],
        'like_count' => [
            'title' => 'Top rated',
            'type' => 'like_count',
            'order' => 'desc',
        ],
        'title' => [
            'title' => 'Name A-Z',
            'type' => 'title',
            'order' => 'asc',
        ],
        'vote_average' => [
            'title' => 'IMDb',
            'type' => 'vote_average',
            'order' => 'desc',
        ]
    ],
    'modules' => [
        'home' => [
            'slider' => 'Slider',
            'movies' => 'Movies',
        ],
    ],
    'payments' => [
        'paypal' => [
            'name' => 'PayPal',
            'type' => 'PayPal account'
        ],
        'stripe' => [
            'name' => 'Stripe',
            'type' => 'Credit card'
        ],
        'coinbase' => [
            'name' => 'Coinbase',
            'type' => 'Cryptocurrency'
        ],
        'bank' => [
            'name' => 'Bank',
            'type' => 'Bank transfer'
        ]
    ],
    'admin' => [
        'admin.index' => [
            'icon' => 'dashboard',
            'nav' => 'dashboard',
            'title' => 'Dashboard',
        ],
        'management' => [
            'header' => 'true',
            'title' => 'Management',
            'class' => 'mt-3',
        ],
        'admin.movie.index' => [
            'icon' => 'movie',
            'nav' => 'movie',
            'title' => 'Movie'
        ],
        'admin.tv.index' => [
            'icon' => 'tv',
            'nav' => 'tv',
            'title' => 'TV Show',
            'menu' => [
                'admin.tv.index' => [
                    'title' => 'TV Show',
                ],
                'admin.episode.index' => [
                    'title' => 'Episode',
                ]
            ],
        ],
        'admin.broadcast.index' => [
            'icon' => 'broadcast',
            'nav' => 'broadcast',
            'title' => 'Live broadcast'
        ],
        'admin.management.index' => [
            'icon' => 'mouse-loading',
            'nav' => 'management',
            'title' => 'Management',
            'menu' => [
                'admin.genre.index' => [
                    'title' => 'Genre',
                ],
                'admin.people.index' => [
                    'title' => 'People',
                ],
            ],
        ],
        'community' => [
            'header' => 'true',
            'title' => 'Community',
            'class' => 'mt-8',
        ],
        'admin.community.index' => [
            'icon' => 'mic',
            'nav' => 'community',
            'title' => 'Community',
            'menu' => [
                'admin.user.index' => [
                    'title' => 'User',
                ],
                'admin.collection.index' => [
                    'title' => 'Collection',
                ],
                'admin.article.index' => [
                    'title' => 'Blog',
                ],
            ],
        ],
        'admin.comment.index' => [
            'icon' => 'chat',
            'nav' => 'comment',
            'title' => 'Comment',
            'subtext' => ':total waiting for approval'
        ],
        'admin.report.index' => [
            'icon' => 'flag',
            'nav' => 'report',
            'title' => 'Report',
            'subtext' => ':total waiting'
        ],
        'admin.request.index' => [
            'icon' => 'refresh',
            'nav' => 'request',
            'title' => 'Request',
            'subtext' => ':total waiting for approval'
        ],
        'system' => [
            'header' => 'true',
            'title' => 'System',
            'class' => 'mt-8',
        ],
        'admin.tool.index' => [
            'icon' => 'magic',
            'nav' => 'tool',
            'title' => 'Tools',
        ],
        'admin.finance.index' => [
            'icon' => 'dollar',
            'nav' => 'finance',
            'title' => 'Finance',
            'menu' => [
                'admin.plan.index' => [
                    'title' => 'Plan',
                ],
                'admin.payment.index' => [
                    'title' => 'Subscriber',
                ],
                'admin.tax.index' => [
                    'title' => 'Tax',
                ],
                'admin.coupon.index' => [
                    'title' => 'Coupon',
                ],
            ],
        ],
        'admin.advertisement.index' => [
            'icon' => 'dollar',
            'nav' => 'advertisement',
            'title' => 'Advertisement'
        ],
        'admin.settings.index' => [
            'icon' => 'settings',
            'nav' => 'settings',
            'title' => 'Settings',
            'menu' => [
                'admin.settings.index' => [
                    'title' => 'General',
                ],
                'admin.customize.index' => [
                    'title' => 'Customize',
                ],
                'admin.menu.index' => [
                    'title' => 'Menu',
                ],
                'admin.language.index' => [
                    'title' => 'Language',
                ],
                'admin.page.index' => [
                    'title' => 'Page',
                ],
                'admin.country.index' => [
                    'title' => 'Country',
                ]
            ],
        ],
    ],
    'colors' => [
        'zinc' => [
            50 => '#fafafa',
            100 => '#f4f4f5',
            200 => '#e4e4e7',
            300 => '#d4d4d8',
            400 => '#a1a1aa',
            500 => '#71717a',
            600 => '#52525b',
            700 => '#3f3f46',
            800 => '#27272a',
            900 => '#18181b',
            950 => '#09090b',
        ],
        'slate' => [
            50 => '#f8fafc',
            100 => '#f1f5f9',
            200 => '#e2e8f0',
            300 => '#cbd5e1',
            400 => '#94a3b8',
            500 => '#64748b',
            600 => '#475569',
            700 => '#334155',
            800 => '#1e293b',
            900 => '#0f172a',
            950 => '#020617',
        ],
        'gray' => [
            50 => '#f9fafb',
            100 => '#f3f4f6',
            200 => '#e5e7eb',
            300 => '#d1d5db',
            400 => '#9ca3af',
            500 => '#6b7280',
            600 => '#4b5563',
            700 => '#374151',
            800 => '#1f2937',
            900 => '#111827',
            950 => '#030712',
        ],
        'neutral' => [
            50 => '#fafafa',
            100 => '#f5f5f5',
            200 => '#e5e5e5',
            300 => '#d4d4d4',
            400 => '#a3a3a3',
            500 => '#737373',
            600 => '#525252',
            700 => '#404040',
            800 => '#262626',
            900 => '#171717',
            950 => '#0a0a0a',
        ],
        'stone' => [
            50 => '#fafaf9',
            100 => '#f5f5f4',
            200 => '#e7e5e4',
            300 => '#d6d3d1',
            400 => '#a8a29e',
            500 => '#78716c',
            600 => '#57534e',
            700 => '#44403c',
            800 => '#292524',
            900 => '#1c1917',
            950 => '#0c0a09',
        ],
    ]
];
