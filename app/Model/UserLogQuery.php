<?php

namespace App\Model;

use App\Model\Base\UserLogQuery as BaseUserLogQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'user_log' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UserLogQuery extends BaseUserLogQuery
{

    public static function countActions($action, Array $params = array())
    {
        $query = self::create();
        if (isset($params['user_id'])) {
            $query->filterByUserId($params['user_id']);
        }
        if (isset($params['ip'])) {
            $query->filterByUserLogIp($params['ip']);
        }
        $date_params = array();
        if (isset($params['date_from'])) {
            $date_params['min'] = $params['date_from'];
        }
        if (isset($params['date_to'])) {
            $date_params['min'] = $params['date_to'];
        }
        if (count($date_params) > 0) {
            $query->filterByCreatedAt($date_params);
        }
        return $query->filterByUserLogAction($action)->count();
    }

}

// UserLogQuery
