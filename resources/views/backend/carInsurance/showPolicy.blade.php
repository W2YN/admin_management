 <div class="tabCon">
@if($policy)
    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">机动车交通事故责任强制保险(注：代收车船税)：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->compulsory_insurance ? '是' : '否'}}
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">机动车损失险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->damage_insurance==1? "新车购置价 ¥".number_format($policy->new_car_price,2): '否'}}
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">第三者责任险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->third_insurance==1? "¥".number_format($policy->third_insurance_money,2): '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">车上人员责任险（司机）：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->drivers_insurance==1? "¥".number_format($policy->drivers_insurance_money,2): '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">车上人员责任险（乘客）：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->passenger_insurance==1? "¥".number_format($policy->passenger_insurance_money, 2)." * ".$policy->passenger_insurance_amount."座": '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">机动车盗抢险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->theft_insurance ? '是' : '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">附加玻璃单独破碎险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->glass_insurance ? '是' : '否'}}

        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">附加自燃损失险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->selfcombustion_insurance ? '是' : '否'}}
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">附加发动机损失险：</label>
        <div class="formControls col-xs-6 col-sm-7">
            {{$policy->engine_insurance ? '是' : '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li"></label>
        <div class="formControls col-xs-6 col-sm-7">

        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔机动车损失险：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_damage_insurance ? '是' : '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔第三者责任险：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_third_insurance ? '是' : '否'}}
        </div>
    </div>


    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔车上人员责任险（司机）：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_drivers_insurance ? '是' : '否'}}
        </div>
    </div>



    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔车上人员责任险（乘客）：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_passenger_insurance ? '是' : '否'}}
        </div>
    </div>



    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔机动车盗抢险：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_theft_insurance ? '是' : '否'}}
        </div>
    </div>



    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-4 text-li">不计免赔发动机损失险：</label>
        <div class="formControls col-xs-6 col-sm-7">
{{$policy->nd_engine_insurance ? '是' : '否'}}
        </div>
    </div>


@endif

</div>

