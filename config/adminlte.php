<?php

return [
    'title' => 'Transport Management System',
    'logo' => '<b>MM</b>Transport',
    'logo_img' => asset('images/logo.png'),
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'usermenu_disabled' => true,  
    'layout_topnav' => null,    
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'menu' => [
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        ['header' => 'Management'],
        [
            'text' => 'Companies',
            'route' => 'company',
            'icon' => 'fas fa-building',
        ],
        [
            'text' => 'Truckers',
            'route' => 'truckers',
            'icon' => 'fas fa-user-tie',
        ],
        ['header' => 'Trips'],
        [
            'text' => 'Trip Lists',
            'route' => 'trip.index',
            'icon' => 'fas fa-truck-moving',
        ],
        [
            'text' => 'Pending Trips',
            'route' => 'pendingtrips',
            'icon' => 'fas fa-clipboard-list',
        ],        
        [
            'text' => 'Completed Trips',
            'route' => 'completedtrips',
            'icon' => 'fas fa-clipboard-list',
        ],
        [
            'text' => 'Archived Trips',
            'route' => 'archive',
            'icon' => 'fas fa-check-circle',
        ],
        ['header' => 'Account '],

        [
            'text' => 'Notifications',
            'route' => 'notifications',
            'icon' => 'fas fa-bell',
        ],
        [
            'text' => 'Log History',
            'route' => 'loginhistory',
            'icon' => 'fas fa-history',
        ],
        [
            'text' => 'Logout',
            'route' => 'logout',
            'icon' => 'fas fa-sign-out-alt',
        ],
    ],
    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => true, 'location' => 'vendor/datatables/js/jquery.dataTables.min.js'],
                ['type' => 'css', 'asset' => true, 'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css'],
            ],
        ],
    ],
];
