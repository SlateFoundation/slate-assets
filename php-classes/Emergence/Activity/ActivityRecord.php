<?php

namespace Emergence\Activity;

use DB;

abstract class ActivityRecord extends \ActiveRecord
{
    static public $deltaRelationFields = [];
    static public $searchConditions = [];

    public static $dynamicFields = [
        'Stories' => [
            'getter' => 'getStories'
        ]
    ];


    public function destroy()
    {
        $Activity = Delta::create([
            'Object' => $this,
            'Actor' => $this->getUserFromEnvironment(),
            'Verb' => 'delete',
            'Data' => $this->getData(),
        ], true);
        return parent::destroy();
    }

    public function save($deep = true)
    {
        $wasPhantom = $this->isPhantom;
        $wasDirty = $this->isDirty;

        parent::save($deep);

        $this->saveDeltaActivity($wasPhantom, $wasDirty);

    }

    public function saveDeltaActivity($wasPhantom = false, $wasDirty = false)
    {
        if ($wasPhantom) {
            $Activity = Delta::publish($this, 'create', $this->getUserFromEnvironment(), $this->getData());
        } else if ($wasDirty) {
            $delta = array();

            foreach ($this->_originalValues as $key => $value) {
                $delta[$key]['before'] = $value;
                $delta[$key]['after'] = $this->getValue($key);
            }

            if (!empty($delta)) {
                $Activity = Delta::publish($this, 'update', $this->getUserFromEnvironment(), $delta);
            }
        }
    }

    public function getStories($from = null, $to = null, $options = [], $conditions = [])
    {

        $conditions = $conditions + ['ObjectClass' => $this->Class, 'ObjectID' => $this->ID];

        if ($from || $from = $_REQUEST['from']) {
            $from = strtotime($from);
            $conditions[] = sprintf('Created > %s', date("U", DB::escape($from)));
        }

        if ($to || $to = $_REQUEST['to']) {
            $to = strtotime($to);
            $conditions[] = sprintf('Created < %s', date("U", DB::escape($to)));
        }

        if ($limit = $_REQUEST['limit']) {
            $options['limit'] = DB::escape($limit);
        }

        if (empty($options['order'])) {
            $options['order'] = ['ID' => 'DESC'];
        }

        $stories = Activity::getAllByWhere($conditions, $options);

        return JSON::translateObjects($stories, false, ['Media', 'Actor', 'changes']);
    }
}