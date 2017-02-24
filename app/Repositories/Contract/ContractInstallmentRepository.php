<?php

namespace App\Repositories\Contract;


use App\Facades\HelpFacades;
use App\Models\Water\Purifier as WaterPurifier;
use App\Presenters\ContractPaymentPresenter;
use App\Repositories\CommonRepository;

class ContractInstallmentRepository extends CommonRepository
{
    public static $accessor = 'contract_installment_repository';

    /**
     *
     * @return ContractInstallmentRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    public function paginateWhere($where, $limit, $columns = ['*'])
    {
        $this->model = $this->model->orderBy('opertion_time', 'asc');
        $this->model = $this->model->join('contracts', 'contracts.id', '=', 'contract_installments.contract_id');
        $columns = [
            'contract_installments.*',
            'contracts.number',
            'contracts.name'
        ];
        return parent::paginateWhere($where, $limit, $columns );
    }

    public function getByWhere(array $where, $columns = ['*'])
    {
        $this->model = $this->model->orderBy('opertion_time', 'asc');
        $this->model = $this->model->join('contracts', 'contracts.id', '=', 'contract_installments.contract_id');
        $columns = [
            'contract_installments.*',
            'contracts.number',
            'contracts.name',
            'contracts.bank_province',
            'contracts.bank_city',
            'contracts.bank_area',
            'contracts.bank_code',
            'contracts.bank_card',
            'contracts.bank_name',
            'contracts.bank_type',
        ];
        return parent::getByWhere($where, $columns );
    }

    public function getByWhereWithMany(array $where, $columns = ['*'])
    {
        $this->model = $this->model->orderBy('opertion_time', 'asc');
        $this->model = $this->model->join('contracts', 'contracts.id', '=', 'contract_installments.contract_id');
        $columns = [
            'contract_installments.*',
            'contracts.number',
            'contracts.buy_date',
            'contracts.expiry_date',
            'contracts.payment_day',
            'contracts.amount',
            'contracts.name',
            'contracts.bank_province',
            'contracts.bank_city',
            'contracts.bank_area',
            'contracts.bank_code',
            'contracts.bank_card',
            'contracts.bank_name',
            'contracts.bank_type',
        ];
        return parent::getByWhere($where, $columns );
    }

    public function createInstallments( $contractId )
    {
        $data = ContractRepository::getInstance()->find($contractId);
        if( !$data ){
            throw new \Exception('合同信息不存在啊');
        }

        if( $data->is_confirm != 0 ){
            throw new \Exception('已确认的合同不能创建分期信息');
        }

        $amount = $data['amount'];
        $count = $data['count'];
        $interest = $data['interest']/1000;
        $buy_date = $data['buy_date'];
        $count = 6;
        //总利率
        $totalInterest = $interest * $count / 12;
        //计算总利息额
        $totalMoney = round($amount * $totalInterest);
        //月息
        $monthMoney = round($totalMoney/$count);//401.
        //计算付款日
        $payment_day = strtotime( $buy_date );
        $payment_day = strtotime( "+2 day", $payment_day );
        ContractRepository::getInstance()->updateById( $contractId, ['payment_day'=>date('d',$payment_day)]);
        //Log::error("【合同管理】生成分期 合同ID：" . $contractId . " 手机号码：" . $contract->mobile );
        //先搞利息
        $total = 0;
        for( $i=1; $i<=$count; $i++ ){

            if( $i == $count ){
                //如果是最后一期，修正差额
                $monthMoney = $totalMoney - $total;
            }
            $total += intval($monthMoney);

            $day = strtotime( "+{$i} month", $payment_day );
            $data = [
                'opertion_time'=>date('Y-m-d H:i:s', $day),
                'money'=>$monthMoney,
                'status'=>1,
                'type'=>0,
                'remark'=>"第{$i}期"
            ];
            $this->createInstalment( $contractId, $data);
        }
        //然后本金
        $data = [
            'opertion_time'=>date('Y-m-d H:i:s', $day),
            'money'=>$amount,
            'status'=>1,
            'type'=>1,
            'remark'=>"本金"
        ];
        $this->createInstalment( $contractId, $data);

    }

    public function createInstalment( $contractId, $data )
    {
        $data['contract_id'] = $contractId;
        $this->create( $data );
    }

    public function exportExcel( $data ){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '合同编码');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '借款人');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '省份');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '城市');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '支付时间');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '支付金额');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '类型');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '备注');


        foreach ($data as $key => $value) {
            /* var Check $value */

            /** @var $value CheckCheckdata */
            $key++;
            $key++;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $key, $value['number']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $key, $value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $key, $value['bank_province']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $key, $value['bank_city']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $key, $value['opertion_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $key, $value['money']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $key, ContractPaymentPresenter::formatType( $value['type'] ));
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $key, $value['remark']);
        }

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="导出支付列表' . date('Y-m-d H:i:s') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }
    
    public function exportRemittance( $data )
    {
        $bankCodes = config('contract.bankCodes');
        $lines = [];
        $total = 0;
        $count = 0;
        foreach( $data as $key=>$value ){
            $tmp = mb_substr($value['bank_province'],-1,1,'utf-8');
            if( $tmp == '省' ){
                $value['bank_province'] = mb_substr($value['bank_province'],0,-1,'utf-8');
            }
            $tmp = mb_substr($value['bank_city'],-1,1,'utf-8');
            if( $tmp == '市' ){
                $value['bank_city'] = mb_substr($value['bank_city'],0,-1,'utf-8');
            }

            $row = [];
            $row[] = sprintf("%06d",$key+1);
            $row[] = '';
            $row[] = $value['bank_code'];
            $row[] = '';
            $row[] = $value['bank_card'];
            $row[] = $value['name'];
            $row[] = $value['bank_province'];
            $row[] = $value['bank_city'];
            $row[] = $bankCodes[$value['bank_code']] . $value['bank_name'];
            $row[] = $value['bank_type'];
            $row[] = $value['money'];
            for( $i=0;$i<=12;$i++)$row[] = '';
            $total += $value['money'];
            $count ++;
            $lines[] = implode( ',', $row );
        }

        $content = "F,000191400205495,00000000,{$count},{$total},05100,,,,,,,,,,,,,,,,,,\r\n" .
            implode( "\r\n", $lines );
        // 输出
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment;filename="导出汇款文档' . date('Y-m-d H:i:s') . '.txt"');
        header('Cache-Control: max-age=0');
        echo $content;
        exit;
    }

    public function exportCapitalBills($data)
    {
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '还本金额');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '购买日期');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '到期日期');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '还本日');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '利息支付账号');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '开户行');


        foreach ($data as $key => $value) {
            /* var Check $value */

            /** @var $value CheckCheckdata */
            $key++;
            $key++;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $key, $value['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $key, $value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $key, number_format($value['amount']/100, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $key, $value['buy_date']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $key, $value['expiry_date']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $key, $value['payment_day']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $key, $value['bank_card']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $key, config('contract.bankCodes')[$value['bank_code']] . $value['bank_name']);
        }

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="理财还本明细单' . date('Y-m-d H:i:s') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }

    public function exportInterestBills( $data )
    {
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '金额');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '期限');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '年化利率');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '购买日期');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '到期日期');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '利息支付日');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '本期支付利息');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '剩余未支付利息');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '剩余期限');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '利息支付账号');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '开户行');


        foreach ($data as $key => $value) {
            /* var Check $value */
            $value = (array)$value;
            /** @var $value CheckCheckdata */
            $key++;
            $key++;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $key, $value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $key, (string)number_format($value['amount']/100, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $key, $value['count']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $key, config('contract.interestOptions')[$value['interest']]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $key, $value['buy_date']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $key, $value['expiry_date']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $key, $value['payment_day']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $key, (string)number_format($value['money']/100, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $key, (string)number_format((int)$value['_money']/100, 2));
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $key, $value['_count']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $key, $value['bank_card']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $key, config('contract.bankCodes')[$value['bank_code']] . $value['bank_name']);
        }

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="理财利息支付明细单' . date('Y-m-d H:i:s') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }
}
