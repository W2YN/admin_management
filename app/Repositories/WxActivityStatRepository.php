<?php
/**
 * Created by PhpStorm.
 * User: HONDA
 * Date: 2016/10/11
 * Time: 10:45
 */

namespace App\Repositories;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use DB;
use Illuminate\Support\Facades\Cookie;

class WxActivityStatRepository extends CommonRepository
{
    public static $accessor = "wx_activity_stat_repository";
    public $today;

    /**
     * @return WxPrizeOrderRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

   
    public function dayData($actType = 1, $start_date, $end_date)
    {
        $db = \DB::connection('mysql_wx_official_accounts');


        while ($start_date <= $end_date) {
            $lastDayFormat = date('Y-m-d', $start_date);
            $dateRange[$lastDayFormat] = 0;
            $categories[] = $lastDayFormat;
            $start_date = strtotime("+1 day", $start_date);
        }

        $data = $db->select('SELECT `type`,date_format(datetime,"%Y-%m-%d") as datetime,sum(`count`) as count  FROM wx_activity_stat where actType=' . $actType . ' and datetime between "' . reset($categories) . '" and "' . end($categories) . '"  GROUP BY `datetime`,`type` order by datetime');


        $type = config('wxActivityStat.type');

        foreach ($type as $k => $v) {
            $res[$k][$lastDayFormat] = 0;
        }

        foreach ($data as $v) {
            $res[$v->type][$v->datetime] = (int)$v->count;
        }

        foreach ($categories as $v) {

            if (isset($res[5][$v]) && isset($res[2][$v])) {
                if ($res[5][$v] == 0 || $res[2][$v] == 0) {
                    $res[8][$v] = $res[9][$v] = 0;

                } else {
                    $res[8][$v] = (float)sprintf('%.2f', ($res[5][$v] / $res[1][$v]) * 100);
                    $res[9][$v] = (float)sprintf('%.2f', ($res[3][$v] / $res[1][$v]) * 100);
                }

            }

        }


        $data = ['categories' => $categories];

        foreach ($res as $k => $v) {

            $data['series'][] = [
                'name' => $type[$k],
                'data' => array_values(array_merge($dateRange, $v))
            ];

        }

        $data['title'] = '微信分享活动统计';
        $data['subtitle'] = $actType == 1 ? '净水器活动' : '车险分期活动';

        return $data;


    }

    public function weekData($actType = 1, $start_date, $end_date)
    {
        $db = \DB::connection('mysql_wx_official_accounts');

        $type = config('wxActivityStat.type');


        //   $lastDay = strtotime('-' . $cycle . ' week');

        $i = 0;
        while ($start_date <= $end_date) {
            $curDay = date('Y-m-d', $start_date);
            $diff = (int)(7 - date('w', $start_date));
            $start_date = strtotime($diff . " day", $start_date);


            $nextDate = date('Y-m-d', $start_date);
            $data['categories'][$i] = $curDay . '——' . $nextDate;

            $dateRange = $db->select('select type,sum(count) as count from wx_activity_stat where actType=' . $actType . ' and dateTime between "' . $curDay . '" and "' . $nextDate . '"  GROUP BY type');


            foreach ($type as $k => $v) {
                $res[$k]['name'] = $v;
                $res[$k]['data'][$i] = 0;
            }


            foreach ($dateRange as $k => $v) {
                $res[$v->type]['data'][$i] = (int)$v->count;
            }


            if ($res[5]['data'][$i] == 0 || $res[5]['data'][$i] == 0) {
                $res[8]['data'][$i] = $res[9]['data'][$i] = 0;

            } else {
                $res[8]['data'][$i] = (float)sprintf('%.2f', ($res[5]['data'][$i] / $res[1]['data'][$i]) * 100);
                $res[9]['data'][$i] = (float)sprintf('%.2f', ($res[3]['data'][$i] / $res[1]['data'][$i]) * 100);
            }


            $i++;
            $data['series'] = array_values($res);

            $start_date = strtotime("+1 day", $start_date);
        }


        $data['title'] = '微信分享活动统计';
        $data['subtitle'] = $actType == 1 ? '净水器活动' : '车险分期活动';
        return $data;


    }


    public function monthData($actType = 1, $start_date, $end_date)
    {
        $db = \DB::connection('mysql_wx_official_accounts');

        $type = config('wxActivityStat.type');


        $i = 0;


        while ($start_date <= $end_date) {
            $curDay = strtotime(date('Y-m', $start_date));
            $start_date = strtotime("+1 months", $curDay);
            $nextDay = date('Y-m-d', $start_date - 1);
            $data['categories'][$i] = date('m', $curDay) . '月';
            $curDay = date('Y-m-d', $curDay);


            $dateRange = $db->select('select type,sum(count) as count from wx_activity_stat where actType=' . $actType . ' and dateTime between "' . $curDay . '" and "' . $nextDay . '"  GROUP BY type');


            foreach ($type as $k => $v) {
                $res[$k]['name'] = $v;
                $res[$k]['data'][$i] = 0;
            }


            foreach ($dateRange as $k => $v) {
                $res[$v->type]['data'][$i] = (int)$v->count;
            }

            if ($res[5]['data'][$i] == 0 || $res[5]['data'][$i] == 0) {
                $res[8]['data'][$i] = $res[9]['data'][$i] = 0;

            } else {
                $res[8]['data'][$i] = (float)sprintf('%.2f', ($res[5]['data'][$i] / $res[1]['data'][$i]) * 100);
                $res[9]['data'][$i] = (float)sprintf('%.2f', ($res[3]['data'][$i] / $res[1]['data'][$i]) * 100);
            }

            $i++;
            $data['series'] = array_values($res);
        }

        $data['title'] = '微信分享活动统计';
        $data['subtitle'] = $actType == 1 ? '净水器活动' : '车险分期活动';
        return $data;


    }


}