<!-- 搜索栏 开始 -->
<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
<form class="form-inline" action="{{route($search['route'])}}" method="GET">
    <div class="text-c">
        @forelse ($search['inputs'] as $input)
            <div class="form-group">
                @if($input['type'] == 'text')
                    <input type="text" name="{{$input['name']}}" id="{{$input['name']}}" style="width:180px"
                           class="input-text" value="{{old($input['name'])}}" placeholder="{{$input['placeholder']}}">
                @elseif($input['type'] == 'select')
                    {{$input['placeholder'] or ''}}
                    <span class="select-box inline">
                        <select class="select" name="{{$input['name']}}" style="width: 100%">
                            @forelse ($input['options'] as $value => $title)
                                <option
                                        value="{{$value}}"
                                        @if( old($input['name']) === 'NULL' || old($input['name']) === null )
                                            @if( $value === old($input['name']) )
                                            selected
                                            @endif
                                        @else
                                            @if( $value == old($input['name']) )
                                            selected
                                            @endif
                                        @endif
                                >
                                    {{trans($title)}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </span>
                @elseif($input['type'] == 'date')
                    {{$input['placeholder'] or '日期范围'}}：
                    <input type="text"
                           onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'{{$input['name']}}Max\')}',dateFmt:'yyyy-MM-dd 00:00:00'})"
                           id="{{$input['name']}}Min" name="{{$input['name']}}Min"
                           value="{{old($input['name'].'Min')}}"
                           class="input-text Wdate" style="width:120px;">
                    -
                    <input type="text"
                           onfocus="WdatePicker({minDate:'#F{$dp.$D(\'{{$input['name']}}Min\')}',dateFmt:'yyyy-MM-dd 23:59:59'})"
                           id="{{$input['name']}}Max" name="{{$input['name']}}Max"
                           value="{{old($input['name'].'Max')}}"
                           class="input-text Wdate" style="width:120px;">
                @endif
            </div>
        @empty
        @endforelse
        <div class="form-group">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 筛选
            </button>
        </div>
    </div>
</form>
<!-- 搜索栏 结束 -->