<?php

if (empty($GLOBALS['Session'])) {
    return;
}

$assetsTools = [
    '_icon' => 'network',
#    'My Assets' => [
#        '_href' => '/assets?set=mine',
#        '_icon' => 'binoculars'
#    ],
#    'Classroom Assets' => [
#        '_href' => '/assets?set=classroom',
#        '_icon' => 'telescope'
#    ]
];

if ($GLOBALS['Session']->hasAccountLevel('Staff')) {
    $assetsTools['Manage'] = '/manage#assets';

    if ($GLOBALS['Session']->hasAccountLevel('Administrator')) {
        $assetsTools['Exports'] = [
            '_icon' => 'export',
            'All Assets' => '/exports/assets.csv',
        ];
    }
}

Slate\UI\Tools::$tools['Assets'] = $assetsTools;