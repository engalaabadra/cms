<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [

            'users' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'roles' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'profile' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'countries' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'cities' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'towns' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',

            'adds' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'activites' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'activites-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'articles' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'articles-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'audios' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'audio-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'banners' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'clients' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'constants' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'contacts' => 'r,t,res,r-a,sh,c,e,d,f-d',
            'galleries' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'galleries-albums' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'gallery-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'galleries-imags' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'menus' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'news' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'news-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'newsletters' => 'r,t,res,r-a,sh,c,e,d,f-d',
            'pages' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'page-accordions' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'page-banners' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'programs' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'program-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'projects' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'project-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'questions' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'reports' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'report-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'searches' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'sliders' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
             'staffs' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'staff-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
             'templates' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
              'visits' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
              'videos' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
              'forms' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'video-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            
        ],
        'administrator' => [
                       'adds' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',

            'activites' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'activites-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'articles' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'articles-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'audios' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'audio-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'banners' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'clients' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'constants' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'contacts' => 'r,t,res,r-a,sh,c,e,d,f-d',
            'galleries' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'galleries-albums' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'gallery-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'galleries-imags' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'menus' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'news' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'news-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'newsletters' => 'r,t,res,r-a,sh,c,e,d,f-d',
            'pages' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'page-accordions' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'page-banners' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'programs' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'program-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'projects' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'project-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'questions' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'reports' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'report-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'searches' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'sliders' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
             'staffs' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'staff-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
             'templates' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
                           'visits' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',

              'videos' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            'video-categories' => 'r,t,res,r-a,sh,c,s,e,u,d,f-d',
            
        ],
        'user' => [
            'profile' => 'r,u',
        ]
    ],

    'permissions_map' => [
        'r' => 'read',
        't' => 'trash',
        'res' => 'restore',
        'r-a' => 'restore-all',
        'sh' => 'show',
        'c' => 'create',
        's' => 'store',
        'e' => 'edit',
        'u' => 'update',
        'u' => 'update',
        'd' => 'destroy',
        'f-d' => 'force-destroy',
        

    ]
];
