<?php
return [
    [
        'title' => 'Dashboard',
        'route' => 'admin.home',
    ],
    //        [
    //            'title' => 'Campaigns',
    //            'icon' => '<i class="menu-icon tf-icons bx bx-shopping-bag"></i>',
    //            'list_child' => [
    //                [
    //                    'title' => 'List Campaign',
    //                    'route' => 'admin.campaigns.index'
    //                ],
    //                [
    //                    'title' => 'Create Campaign',
    //                    'route' => 'admin.campaigns.create'
    //                ],
    //            ]
    //        ],
    //        [
    //            'title' => 'Categories',
    //            'icon' => '<i class="menu-icon tf-icons bx bx-category-alt"></i>',
    //            'list_child' => [
    //                [
    //                    'title' => 'List Category',
    //                    'route' => 'admin.categories.index'
    //                ],
    //                [
    //                    'title' => 'Create Category',
    //                    'route' => 'admin.categories.create'
    //                ],
    //            ]
    //        ],
    [
        'title' => 'Products',
        'icon' => '<i class="menu-icon tf-icons bx bxs-coupon"></i>',
        'list_child' => [
            [
                'title' => 'List Coupon',
                'route' => 'admin.coupons.index'
            ],
            [
                'title' => 'Create Coupon',
                'route' => 'admin.coupons.create'
            ],
        ]
    ],
];
