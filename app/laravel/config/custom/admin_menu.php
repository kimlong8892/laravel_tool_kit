<?php
return [
    [
        'title' => 'Dashboard',
        'route' => 'admin.home',
    ],
    [
        'title' => 'Products management',
        'icon' => '<i class="menu-icon tf-icons bx bxs-coupon"></i>',
        'list_child' => [
            [
                'title' => 'List',
                'route' => 'admin.products.index'
            ],
        ]
    ],
    [
        'title' => 'Categories management',
        'icon' => '<i class="menu-icon tf-icons bx bx-category"></i>',
        'list_child' => [
            [
                'title' => 'List',
                'route' => 'admin.categories.index'
            ],
            [
                'title' => 'Create',
                'route' => 'admin.categories.create'
            ],
        ]
    ],
    [
        'title' => 'Posts management',
        'icon' => '<i class="menu-icon tf-icons bx bx-pencil"></i>',
        'list_child' => [
            [
                'title' => 'List',
                'route' => 'admin.posts.index'
            ],
            [
                'title' => 'Create',
                'route' => 'admin.posts.create'
            ],
        ]
    ],
];
