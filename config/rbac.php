<?php

return [
    // Main
    'layout' => 'adminlte::page',
    'userModelClass' => App\User::class,
    'adminUserId' => 1,
    'routesMainPermission' => Itstructure\LaRbac\Models\Permission::ADMINISTRATE_PERMISSION,
    'memberNameAttributeKey' => 'name',
    'paginate' => [
        'main' => 2,
    ],

    // Messages
    'deleteConfirmation' => 'Are you sure you want to delete?',
    'deleteRequired' => 'Select items before delete.'
];
