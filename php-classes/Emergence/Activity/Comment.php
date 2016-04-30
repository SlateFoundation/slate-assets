<?php

namespace Emergence\Activity;

class Comment extends AbstractActivity
{

    public static $relationships = [
        'Media' => [
            'type' => 'context-children',
            'class' => \PhotoMedia::class,
            'contextClass' => __CLASS__
        ]
    ];

    public static $dynamicFields = [
        'Media'
    ];

    public function getChanges()
    {
        if ($this->Verb == 'update') {
            return $this->Data;
        }
    }
}