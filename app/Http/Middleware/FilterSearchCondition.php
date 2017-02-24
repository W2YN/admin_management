<?php

namespace App\Http\Middleware;

use Closure;

class FilterSearchCondition
{
    protected $betweenFields = ['created_at', 'updated_at','datetime','opertiontime','opertion_time','buy_date'];
    //protected $betweenFields = ['created_at', 'updated_at','datetime','opertiontime'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $array = [];

        $params = $request->all();

        foreach ($this->betweenFields as $betweenField) {
            $minKey = $betweenField . "Min";
            $maxKey = $betweenField . "Max";
            $min = isset($params[$minKey]) ? $params[$minKey] : false;
            $max = isset($params[$maxKey]) ? $params[$maxKey] : false;
            unset($params[$minKey]);
            unset($params[$maxKey]);
            if ($min && $max) {
                $params[$betweenField] = $min . ' - ' . $max;
            }
        }
        //var_dump($params);die;
        foreach ($params as $field => $value) {
            if($value === 'NULL') { //就是不需要的东西了
                continue;
            }
            if ((!empty($value) || $value === '0')) {
                if ($field === 'page') {
                    $array['page'] = $value;
                    continue;
                }

                if (in_array($field, $this->betweenFields)) {
                    $array['where'][] = [$field, 'between', $this->formatBetweentField($value)];
                    continue;
                }

                $field = explode('-', $field);

                if (!isset($field[1])) $field[1] = $field[0];

                switch ($field[0]) {
                    case "lt":
                        $array['where'][] = [$field[1], '<', $value];
                        break;
                    case "lte":
                        $array['where'][] = [$field[1], '<=', $value];
                        break;
                    case "gt":
                        $array['where'][] = [$field[1], '>', $value];
                        break;
                    case "gte":
                        $array['where'][] = [$field[1], '>=', $value];
                        break;
                    case "eq":
                        $array['where'][] = [$field[1], '=', $value];
                        break;
                    case "nq":
                        $array['where'][] = [$field[1], '<>', $value];
                        break;
                    default:
                        $array['where'][] = [$field[1], 'like', '%' . $value . '%'];
                        break;
                }


            }
        }

        // var_export($array['where']);die;
        //$request->flash();
        //$request->session()->reflash();
        $request->replace($array);

        return $next($request);
    }

    /**
     * format string time to array time
     *
     * @param  mixed $value
     *
     * @return array
     */
    public function formatBetweentField($value)
    {
        $string = str_replace('/', '-', $value);
        $array = explode(' - ', $string);

        return $array;
    }
}
