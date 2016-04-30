<?php

namespace Emergence\Activity;

use ActiveRecord;

class Delta extends AbstractActivity
{

    public static function publish(ActiveRecord $Object, $verb, ActiveRecord $Actor = null, $data = [])
    {

        //check if activity has a merge threshold
        if (static::$activityMergeHours) {
            $conditions = [
                'ActorID' => $Actor ? $Actor->ID : null,
                'ObjectID' => $Object->ID,
                'ObjectClass' => $Object->Class,
                'Verb' => $verb,
                sprintf('Created >= "%s"', date("Y-m-d H:i:a", time() - (3600 * static::$activityMergeHours)))
            ];

            if ($recentPublish = static::getByWhere($conditions, ['order' => 'ID DESC'])) {
                $publishData = $recentPublish->Data;
                $merged = 0;

                foreach ($data as $fieldName => $changes) {
                    if (!empty($publishData[$fieldName])) {
                        $merged++;
                        $publishData[$fieldName] = array_merge($data[$fieldName], ['before' => $publishData[$fieldName]['before']]);
                    } else {
                        $publishData[$fieldName] = $changes;
                    }
                }

                if ($merged) {
                    $recentPublish->Created = null;
                }

                $recentPublish->Data = $publishData;
                $recentPublish->save();
                return $recentPublish;
            }
        }

        //create new delta activity
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
        $data = parent::getData();
        $parentChanges = parent::getChanges();

        if ($this->Verb == 'update') {

            if (!is_array($parentChanges) || empty($parentChanges)) {
                $changes = [];
            } else {
                //filter out incompatable / "data" objects;
                $changes = array_filter($parentChanges, function($datum) {
                    return is_object($datum) && $datum->property != 'Data';
                });
            }

            //loop through and add data objects
            foreach ($data['Data'] as $key => &$value) {
                if ($key == 'Data') {

                    $ba = $value['before'];
                    $aa = $value['after'];

                    if ($ba != $aa && (is_array($ba) && is_array($aa))) {
                        foreach ( array_diff_assoc($aa, $ba) as $k => $v) {
                            $b = $ba[$k];
                            $a = $aa[$k];

                            if ($b != $a) {
                                $c = [
                                    'before' => ['value' => $b],
                                    'after' => ['value' => $a],
                                    'property' => 'Data - ' .$k
                                ];

                                $changes[] = $c;
                            }
                        }
                    }
                }
                else if (!array_key_exists($key, $changes)){
                    $changes[] = $this->formatChanges($key, $value);
                }
            }
        }

        return array_values(array_filter($changes));
    }

    protected function formatChanges($key, $value)
    {
        $className = $this->ObjectClass;

        if (!$className::$deltaRelationFields || !$relationField = $className::$deltaRelationFields[$key]) {
#            JSON::respond([$className::$deltaRelationFields, $key, $value], 'skipped');
            return false;
        }
        //instantiate change array as object.
        $change = (object) $value;
        $change->property = $relationField['displayKey'];

        $relatedClass = $relationField['class'];
        $relatedDisplayField = $relationField['displayField'];

        $beforeObject = $relatedClass::getByField('ID', $change->before);
        $afterObject = $relatedClass::getByField('ID', $change->after);

        $change->before = [
            'value' => $change->before,
            'displayValue' => $beforeObject->$relatedDisplayField
        ];

        $change->after = [
            'value' => $change->after,
            'displayValue' => $afterObject->$relatedDisplayField
        ];

        return $change;
    }
}