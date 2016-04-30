<?php

namespace Emergence\Activity;

use ActiveRecord;

abstract class AbstractActivity extends \ActiveRecord
{
    // ActiveRecord configuration
    public static $tableName = 'activity';
    public static $singularNoun = 'activity';
    public static $pluralNoun = 'activities';

    // the lowest-level class in your table requires these lines,
    // they can be manipulated via config files to plug in same-table subclasses
    public static $rootClass = __CLASS__;
    public static $defaultClass = __CLASS__;
    public static $subClasses = [Delta::class, Comment::class];

    public static $activityMergeHours = 1;

    public static $fields = [
        'CreatorID' => null,
        'ActorClass' => [
            'type' => 'string',
            'notnull' => false
        ],
        'ActorID' => [
            'type' => 'uint',
            'notnull' => false
        ],
        'Verb' => 'string',
        'ObjectClass' => 'string',
        'ObjectID' => 'uint',
        'Data' => [
            'type' => 'json',
            'notnull' => false
        ]
    ];

    public static $relationships = [
        'Actor' => [
            'type' => 'context-parent',
            'local' => 'ActorID',
            'classField' => 'ActorClass'
        ],
        'Object' => [
            'type' => 'context-parent',
            'local' => 'ObjectID',
            'classField' => 'ObjectClass'
        ]
    ];

    public static $dynamicFields = [
        'Actor',
        'Object',
        'changes' => [
            'getter' => 'getChanges'
        ]
    ];

    public static function getAllByObject(ActiveRecord $Object)
    {
        return static::getAllByWhere([
            'ObjectClass' => $Object->getRootClass(),
            'ObjectID' => $Object->ID
        ],[
            'order' => ['ID' => 'DESC']
        ]);
    }

    public static function publish(ActiveRecord $Object, $verb, ActiveRecord $Actor = null, $data = [])
    {
        return static::create([
            'Actor' => $Actor,
            'Object' => $Object,
            'ObjectClass' => $Object->Class,
            'Verb' => $verb,
            'Data' => $data
        ], true);
    }

    public function getChanges()
    {
        $data = parent::getData(true);

        $className = $this->ObjectClass;
        $relationships = $className::getStackedConfig('relationships');
        $ignoreFields = ['ID', 'Created']; //TODO: add static cfg
        $changes = [];

        foreach ($relationships AS $relationship) {
            if (in_array($relationship['type'],  ['one-one', 'context-parent'])) {
                $ignoreFields[] = $relationship['local'];
            }
        }

        if ($this->Verb == 'update') {
            foreach ($data['Data'] as $key => &$change) {
                if ($change['keyName']) {
                    $keyName = $change['keyName'];
                    unset($change['keyName']);
                } else {
                    $keyName = false;
                }

                if (in_array($key, $ignoreFields) || !$recordFieldOptions = $className::getStackedConfig('fields', $keyName ?: $key) ) {
                    continue;
                }

                //instantiate change as object.
                $change = (object) $change;
                $change->property = $keyName ? $key : $recordFieldOptions['label'];

                $change->before = [
                    'value' => $change->before,
                    'displayValue' => $change->before
                ];

                $change->after = [
                    'value' => $change->after,
                    'displayValue' => $change->after
                ];

                $changes[] = $change;
            }
        }

        return $changes;

    }
}