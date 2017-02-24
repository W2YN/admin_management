
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        *{padding:0;margin:0;}
        body{font:12pt/24pt "simson";}
        h1{text-align: center;padding:20px 0;font-size:22pt;}
        .table{text-align: center;font:12pt/32pt "simson";border-collapse:collapse;width:100%;}
        .table td{border:1px solid #666;padding:0 20px;}
        .row{margin:0 auto;width:85%;}
        .tips{font:14pt/28pt "simson";/*text-indent:2em;*/}
        .bold{font:bold 14pt/28pt "simson";margin:20px 0;}
        .right{text-align: right;font-size:14pt;}
        .tableHead{text-align:center;font-size:12pt;}
        .tableNumber{font-size:10.5pt;}
        .border{border-bottom:1px solid #000;}
    </style>
</head>
<body>
<div class="row">
    <h1><strong>收款确认函</strong></h1>
    <p class="tableHead">
        <b>投资项目名称：</b><b class="border">车险宝</b>&nbsp;&nbsp;&nbsp;&nbsp;
        <b>投资期限：</b><b class="border"><?php echo $data->count;?>个月</b>&nbsp;&nbsp;&nbsp;&nbsp;
        <b>合同编号：</b><b class="border"><?php echo $data->number;?></b>
    </p>
    <table class="table" style="font-size:12pt;">
        <tr>
            <td><b>客户姓名</b></td>
            <td><b><?php echo $data->name;?></b></td>
            <td><b>身份证号码</b></td>
            <td class="tableNumber" colspan="2"><?php echo $data->id_number;?></td>
        </tr>
        <tr>
            <td><b>认购金额</b></td>
            <td class="tableNumber" style="text-align:left;" colspan="2">大写：<span class="border"><?php echo Tools\MathTools::numToCNMoney($data->amount/100)?></span> （￥：<span class="border"><?php echo number_format($data->amount/100, 2)?></span>元）</td>
            <td><b>预计年化</b></td>
            <td class="tableNumber"><?php echo config('contract.interestOptions')[$data->interest]?></td>
        </tr>
        <tr>
            <td><b>收益方式</b></td>
            <td class="tableNumber">按月付息</td>
            <td><b>购买日期</b></td>
            <td class="tableNumber" colspan="2"><?php echo $data->buy_date?></td>
        </tr>
        <tr>
            <td><b>起息日</b></td>
            <td class="tableNumber"><?php echo $data->buy_date?></td>
            <td><b>到期日</b></td>
            <td class="tableNumber" colspan="2"><?php echo $data->expiry_date?></td>
        </tr>
    </table>
    <p class="bold">尊敬的客户：</p>
    <p class="tips">&nbsp;&nbsp;您已向我公司申购上述投资，并签署了相关的投资协议。</p>
    <p class="tips">&nbsp;&nbsp;我公司已收到您所签署或出具的投资合同、相关证件复印件、银行卡复印件等文件资料。</p>
    <p class="bold">声明：</p>
    <p class="tips">（1）本回执为客户已提出申购并与我司签约、且我司收到相关资料的指定凭证；</p>
    <p class="tips">（2）客户必须在指定的时间内足额缴纳申购资金，否则已签署的投资文件自动失效；</p>
    <p class="tips">（3）如发现客户所提供的资料信息不实，我司有权拒绝客户的申请，并退还已交付的资金。</p>
    <br><br>
    <p class="right">杭州热讯电子商务有限公司</P>
    <p class="right">（公章）</P>
    <p class="right"><?php echo $data->buy_date?></P>
</div>
</body>
</html>