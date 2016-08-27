<?php

Git::$repositories['slate-assets'] = [
    'remote' => 'https://github.com/SlateFoundation/slate-assets.git',
    'originBranch' => 'master', //'builds/v1',
    'workingBranch' => 'master', //builds/v1',
    'trees' => [
        'php-classes/Slate/Assets',
        'php-classes/Emergence/Activity',
        'php-config/Git.config.d/slate-assets.php',
        'php-config/Slate/UI/Tools.config.d/assets.php'
    ]
];