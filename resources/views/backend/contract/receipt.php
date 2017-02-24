<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        *{padding:0;margin:0;}
        body{font-size:10pt}
        table{border-collapse:collapse;border:none;width:16cm;margin-top:1cm;}
        table td{border:1px solid #fff;width: 1cm;height:1.2cm;}
    </style>
</head>
<body>

<table>
  <tr>
    <td colspan="2"></td>
    <td colspan="13"><div style="padding-top:0.5cm;"><?php echo $data->buy_date?></div></td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td colspan="13"><div style="margin-left:1.5cm;"><?php echo $data->name;?></div></td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td colspan="9"><div style="margin-left:1.5cm;">“车险宝”项目投资款<br><?php echo $data->buy_date?>至<?php echo $data->expiry_date?></div></td>
    <td colspan="4"><span style="float:right;margin-right:1.5cm;">转账</span></td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td colspan="13"><div style="margin-left:1.5cm;"><?php echo Tools\MathTools::numToCNMoney($data->amount/100)?><span style="float:right;margin-right:1.5cm;"><?php echo number_format($data->amount/100, 2)?></span></div></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>