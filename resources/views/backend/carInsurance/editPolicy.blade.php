<div class="tabCon skin-minimal" id="policy">

    @if($policy)
        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">机动车交通事故责任强制保险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    <input type="checkbox" id="checkbox-disabled-checked" checked disabled/>
                    <label>(注：代收车船税)</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">机动车损失险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[damage_insurance]',1,$policy->damage_insurance,['id'=>'damage_insurance'])!!}
                    &nbsp;
                    {!! Form::text('policy[new_car_price]',$policy->new_car_price,['id'=>'new_car_price','class'=>"input-text",'style'=>'width:192px;'])!!}
                    &nbsp;元(新车购置价)

                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">第三者责任险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[third_insurance]',1,$policy->third_insurance,['id'=>'third_insurance'])!!}
                    &nbsp;
                    {!! Form::select('policy[third_insurance_money]',$third_insurance_money,$policy->third_insurance_money,['id'=>'third_insurance_money','class'=>"input-text",'style'=>'width:192px;']) !!}
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">车上人员责任险（司机）：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[drivers_insurance]',1,$policy->drivers_insurance,['id'=>'drivers_insurance'])!!}
                    &nbsp;
                    {!! Form::select('policy[drivers_insurance_money]',$drivers_insurance_money,$policy->drivers_insurance_money,['id'=>'drivers_insurance_money','class'=>"input-text",'style'=>'width:192px;']) !!}
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">车上人员责任险（乘客）：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[passenger_insurance]',1,$policy->passenger_insurance,['id'=>'passenger_insurance'])!!}
                    &nbsp;
                    {!! Form::select('policy[passenger_insurance_money]',$passenger_insurance_money,$policy->passenger_insurance_money,['id'=>'drivers_insurance_money','class'=>"input-text",'style'=>'width:88px;']) !!}
                    /
                    {!! Form::select('policy[passenger_insurance_amount]',$passenger_insurance_amount,$policy->passenger_insurance_amount,['id'=>'passenger_insurance_amount','class'=>"input-text",'style'=>'width:88px;']) !!}
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">机动车盗抢险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[theft_insurance]',1,$policy->theft_insurance,['id'=>'theft_insurance'])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">附加玻璃单独破碎险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[glass_insurance]',1,$policy->glass_insurance,['id'=>'glass_insurance'])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">附加自燃损失险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[selfcombustion_insurance]',1,$policy->selfcombustion_insurance,['id'=>'selfcombustion_insurance'])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li">附加发动机损失险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[engine_insurance]',1,$policy->engine_insurance,['id'=>'engine_insurance'])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li"><b>不计免赔：</b></label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择机动车损失险'
                   for="nd_damage_insurance">不计免赔机动车损失险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_damage_insurance]',1,$policy->nd_damage_insurance,['id'=>'nd_damage_insurance','class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择第三者责任险'
                   for="nd_third_insurance">不计免赔第三者责任险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_third_insurance]',1,$policy->nd_third_insurance,['id'=>'nd_third_insurance','class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择车上人员责任险（司机）' for="nd_drivers_insurance">不计免赔车上人员责任险（司机）：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_drivers_insurance]',1,$policy->nd_drivers_insurance,['id'=>'nd_drivers_insurance','class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择车上人员责任险（乘客）' for="nd_passenger_insurance">不计免赔车上人员责任险（乘客）：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_passenger_insurance]',1,$policy->nd_drivers_insurance,['id'=>'nd_passenger_insurance' ,'class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择机动车盗抢险'
                   for="nd_theft_insurance">不计免赔机动车盗抢险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_theft_insurance]',1,$policy->nd_theft_insurance,['id'=>'nd_theft_insurance','class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-6 col-sm-4 text-li" title='请先选择附加发动机损失险' for="nd_engine_insurance">不计免赔发动机损失险：</label>
            <div class="formControls col-xs-4 col-sm-6">
                <div class="check-box">
                    {!! Form::checkbox('policy[nd_engine_insurance]',1,$policy->nd_engine_insurance,['id'=>'nd_engine_insurance','class'=>"CheckType"])!!}
                    &nbsp;
                </div>
            </div>
        </div>
    @endif

</div>

<script type="text/javascript">
    $(document).ready(function () {
        CheckType();

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });


        $(document).on('change', '#policy input:checkbox', function () {
            CheckType();
        });

        $(document).on('click', '.check-box .disabled', function () {
            var val = $(this).parents('.row').children('label').attr('title');
            alert(val);
        });

        function CheckType() {
            if ($('#damage_insurance').is(':checked') && $('#third_insurance').is(':checked')
                    && ($('#drivers_insurance').is(':checked') || $('#passenger_insurance').is(':checked'))
            ) {
                $('.CheckType').attr("disabled", false);
                $('.CheckType').parent('div').removeClass('disabled');
            } else {
                $('.CheckType').attr("disabled", true).css("cursor", "default").attr("checked", false);
                $('.CheckType').parent('div').addClass('disabled').removeClass('checked');

            }

            //不计免赔车上人员责任险（司机）
            if ($('#drivers_insurance').is(':checked')) {
                $('#nd_drivers_insurance').parent('div').removeClass('disabled');
                $('#nd_drivers_insurance').attr("disabled", false);
            } else {
                $('#nd_drivers_insurance').attr("disabled", true).css("cursor", "default").attr("checked", false);
                $('#nd_drivers_insurance').parent('div').addClass('disabled').removeClass('checked');
            }


            //不计免赔车上人员责任险（乘客）
            if ($('#passenger_insurance').is(':checked')) {
                $('#nd_passenger_insurance').parent('div').removeClass('disabled');
                $('#nd_passenger_insurance').attr("disabled", false);
            } else {
                $('#nd_passenger_insurance').attr("disabled", true).css("cursor", "default").attr("checked", false);
                $('#nd_passenger_insurance').parent('div').addClass('disabled').removeClass('checked');
            }


            //不计免赔机动车盗抢险
            if ($('#theft_insurance').is(':checked')) {
                $('#nd_theft_insurance').parent('div').removeClass('disabled');
                $('#nd_theft_insurance').attr("disabled", false);
            } else {
                $('#nd_theft_insurance').attr("disabled", true).css("cursor", "default").attr("checked", false);
                $('#nd_theft_insurance').parent('div').addClass('disabled').removeClass('checked');
            }


            //不计免赔发动机损失险
            if ($('#engine_insurance').is(':checked')) {
                $('#nd_engine_insurance').parent('div').removeClass('disabled');
                $('#nd_engine_insurance').attr("disabled", false);
            } else {
                $('#nd_engine_insurance').attr("disabled", true).css("cursor", "default").attr("checked", false);
                $('#nd_engine_insurance').parent('div').addClass('disabled').removeClass('checked');
            }

        };


    });
</script>