<?php

return [
    [
        'name' => 'Account announcements',
        'flag' => 'announcement.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'announcement.create',
        'parent_flag' => 'announcement.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'announcement.edit',
        'parent_flag' => 'announcement.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'announcement.destroy',
        'parent_flag' => 'announcement.index',
    ],
];
