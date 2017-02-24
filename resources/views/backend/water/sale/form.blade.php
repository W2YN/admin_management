{{csrf_field()}}
<div class="row cl">
    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>业务员：</label>
    <div class="formControls col-xs-8 col-sm-9">
        {!!Form::text('name',null,[ 'class'=>"input-text"])!!}
    </div>
</div>

<div class="row cl">
    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠类型：</label>
    <div class="formControls col-xs-8 col-sm-9">
        {!!Form::select('discount_type',$discountType,null,[ 'class'=>"input-text"])!!}
    </div>
</div>

<div class="row cl">
    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠值：</label>
    <div class="formControls col-xs-8 col-sm-9">
        {!!Form::text('discount_value',null,[ 'class'=>"input-text"])!!}
    </div>
</div>

<div class="row cl">
    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
    </div>
</div>
