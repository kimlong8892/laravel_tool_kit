<?php
    return [
        [
            'title' => 'Coupon',
            'icon' => '<i class="menu-icon tf-icons bx bxs-coupon"></i>',
            'list_child' => [
                [
                    'title' => 'List coupon',
                    'route' => 'web.home'
                ]
            ]
        ],
        [
            'title' => 'Download video',
            'icon' => '<i class="menu-icon tf-icons bx bx-download"></i>',
            'list_child' => [
                [
                    'title' => 'Youtube',
                    'route' => 'web.download_video_youtube',
                ]
            ]
        ],
    ];
