@extends('backend.layout.frame')
@section('content')
    <article class="page-container">
        <form action="{{route('backend.contract.store')}}" method="post" class="form form-horizontal" id="form-member-add">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('name')}}" placeholder="" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">身份证号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('id_number')}}" placeholder="" id="id_number" name="id_number">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>移动电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('mobile')}}" placeholder="" id="mobile" name="mobile">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>合同编号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('number')}}" placeholder="" id="number" name="number">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>合同金额：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('amount')}}" placeholder="单位：元" id="amount" name="amount">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>期数：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select" name="count" id="count" style="width: 200px">
                        @forelse ($countOptions as $key => $value)
                            <option
                                    value="{{$key}}"
                                    @if($key == old('count'))
                                    selected
                                    @endif
                            >
                                {{trans($value)}}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>年利率：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select" name="interest" id="interest"  style="width: 200px">
                        @forelse ($interestOptions as $key => $value)
                            <option
                                    value="{{$key}}"
                                    @if($key == old('interest'))
                                    selected
                                    @endif
                            >
                                {{trans($value)}}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>购买日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                           id="buy_date" name="buy_date"
                           value="{{old('buy_date')}}"
                           class="input-text Wdate" style="width:200px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>来源：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select" name="source" id="source" style="width: 200px;">
                        @forelse ($sourceOptions as $key => $value)
                            <option
                                    value="{{$key}}"
                                    @if($key == old('source'))
                                    selected
                                    @endif
                            >
                                {{trans($value)}}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>到期日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                           id="expiry_date" name="expiry_date"
                           value="{{old('expiry_date')}}"
                           class="input-text Wdate" style="width:200px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>银行账户：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('bank_card')}}" placeholder="" id="bank_card" name="bank_card">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>银行账户类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select" name="bank_type" id="bank_type" style="width: 200px;">
                        @forelse ($bankTypes as $key => $value)
                            <option
                                    value="{{$key}}"
                                    @if($key == old('bank_type'))
                                    selected
                                    @endif
                            >
                                {{trans($value)}}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开户行所在地：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select  class="select" name="bank_province" id="bank_province"  value="{{old('bank_province')}}" style="width: 200px;"></select>
                    <select class="select" name="bank_city" id="bank_city"  value="{{old('bank_city')}}" style="width: 200px;"></select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开户行代码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select" name="bank_code" id="bank_code" style="width: 200px;">
                        @forelse ($bankCodes as $key => $value)
                            <option
                                    value="{{$key}}"
                                    @if($key == old('bank_code'))
                                    selected
                                    @endif
                            >
                                {{trans($value)}}({{$key}})
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开户行名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('bank_name')}}" placeholder="开户行名称，开户行代码中已经有的银行名称部分不需要写了" id="bank_name" name="bank_name" >
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('after.js')
<script type="text/javascript" src="/lib/PCASClass/PCASClass.js"></script>
<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    new PCAS("bank_province={{old('bank_province','浙江省')}}","bank_city={{old('bank_city','杭州市')}}");
</script>
@endsection