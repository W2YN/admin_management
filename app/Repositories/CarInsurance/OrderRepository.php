<?php
namespace App\Repositories\CarInsurance;

use App\Facades\HelpFacades;
use App\Models\CarInsurance\Order;
use App\Repositories\CommonRepository;
use Illuminate\Support\Facades\Log;

class OrderRepository extends CommonRepository
{
    public static $accessor = 'CarInsurance_order_repository';

    /**
     *
     * @return OrderRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    public function findOrfail($id)
    {
        return $this->model->findOrfail($id);
    }

    public function amountOptions()
    {
        $countOptions = [];
        for ($i = 1; $i <= 24; $i++) {
            $countOptions[$i] = "{$i}期";
        }
        return $countOptions;
    }

    /**
     * @param $where
     * @param $limit
     * @param array $columns
     * @return mixed
     */
    public function joinInstallmentPaginateWhere($where, $limit, $columns = ["*"])
    {
        /*
         * @var Installment
         */
        $model = $this->model;

        $columns = [
            'installment.*',
            'orders.num',//订单号
            'orders.car_owner',//车主
            'orders.owner_mobile',//车主手机号码
        ];
        $model = $model->join('installment', 'orders.id', '=', 'installment.order_id');
        $this->model = $model;

        return parent::paginateWhere($where, $limit, $columns);
    }


    function uuid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand(( double )microtime() * 10000); //optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
            $charid = strtoupper(md5(uniqid(rand(), true))); //根据当前时间（微秒计）生成唯一id.
            $hyphen = chr(45); // "-"
            $uuid = '' . chr(123) .// "{"
                substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12)
                . chr(125);// "}"
            return $uuid;
        }
    }

    /**
     * 补救措施
     * @param $id
     * @return Order
     */
    public function findOrCreate($id)
    {
        if($id == null) {
            return Order::create();
        }else {
            return $this->findOrfail($id);
        }
    }

    public function myOrderPaginateWhere($where, $limit, $columns = ['*'])
    {
        $model = $this->model->orderBy('created_at', 'desc'); //添加时间判断

        try {
            if (!empty($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value)) {
                        if (count($value) == 3) {
                            list($field, $condition, $val) = $value;
                        } else {
                            list($condition, $val) = $value;
                        }
                        if (in_array($condition, ['=', '>', '<', '>=', '<=', '<>', '!='])) {
                            $model = $model->where($field, $condition, $val);
                        } elseif ($condition == 'like') {
                            $model = $model->where($field, $condition, '%' . $val . '%');
                        } elseif ($condition == 'null') {
                            $condition = 'where' . ucfirst($condition);
                            $model = $model->$condition($field);
                        } elseif ($condition == 'not null') {
                            $map = explode(' ', $condition);
                            $condition = 'where' . ucfirst($map[0]) . ucfirst($map[1]);
                            $model = $model->$condition($field);
                        } elseif (in_array($condition, ['between', 'in'])) {
                            $condition = 'where' . ucfirst($condition);
                            $model = $model->$condition($field, $val);
                        } elseif (in_array($condition, ['not between', 'not in'])) {
                            $map = explode(' ', $condition);
                            $condition = 'where' . ucfirst($map[0]) . ucfirst($map[1]);
                            $model = $model->$condition($field, $value);
                        } else {
                            throw new \Exception("请输入正确的查询条件");
                        }
                    } else {
                        $model = $model->where($field, '=', $value);
                    }
                }
            }

        } catch (\Exception $e) {
            Log::debug('paginateWhere 异常：' . $e->getMessage() . ' 参数:' . json_encode($where, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }


        $userId = \Auth::id();
        $model = $model->where(function ($query) use ($userId) {
            $query->where('to_user_id', '=', $userId)->orWhere('recommend_id', '=', $userId);
        });

        return $model->paginate($limit, $columns);
    }

    public function paginateWithOrder($where, $limit, $columns=["*"])
    {
        $this->model = $this->model->orderBy('created_at', 'desc'); //添加时间判断

        return parent::paginateWhere($where, $limit, $columns);
    }
}

