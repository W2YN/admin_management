<?php

namespace App\Http\Controllers\Backend;

/**
 * 引入日志事件
 */
use App\Events\Log\OperationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Form\WaterSaleCreateForm;
use App\Repositories\WaterSaleRepository;
use Illuminate\Http\Request;


class WaterSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('search', ['only' => ['index']]);
        $this->middleware('logger.operation'); //引入添加操作日志记录功能中间件
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discountType = config('water.saleDiscountType');
        $data = WaterSaleRepository::getInstance()->paginateWhere($request->get('where'), config('repository.page-limit'));
        return view('backend.water.sale.index', compact('data', 'discountType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['discountType'] = config('water.saleDiscountType');
        return view('backend.water.sale.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WaterSaleCreateForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(WaterSaleCreateForm $request)
    {
        try {
            if ($sale = WaterSaleRepository::getInstance()->create($request->all())) {
                //return $this->successRoutTo("backend.water.sale.store", "添加业务员成功");
                $sale->code = WaterSaleRepository::getInstance()->createCode($sale->id);
                WaterSaleRepository::getInstance()->updateById($sale->id, $sale->toArray());
                \Event::fire(new OperationEvent("添加业务员"));
                return view('backend.water.sale.store');
            }
        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = WaterSaleRepository::getInstance()->find($id);
        $data['discountType'] = config('water.saleDiscountType');
        return view('backend.water.sale.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = WaterSaleRepository::getInstance()->find($id);
            $data->update($request->all());
            \Event::fire(new OperationEvent("业务员资料编辑"));
            return view('backend.carInsurance.store');
        } catch (\Exception $e) {
            \Event::fire(new OperationEvent("更新订单失败:" . $e->getMessage()));
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (WaterSaleRepository::getInstance()->destroy($id)) {
                \Event::fire(new OperationEvent("业务员删除"));
                return response('成功删除');
                //return $this->successBackTo('删除用户成功');
            }
        } catch (\Exception $e) {
            return response('删除失败,' . $e->getMessage(), 500);
            //return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }
}
