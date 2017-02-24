<?php

namespace App\Repositories\Rbcx;

use App\Facades\HelpFacades;
use App\Models\Rbcx\CardInfo;
use App\Models\Rbcx\Order;
use App\Repositories\CommonRepository;
use Intervention\Image\Facades\Image;
use PHPExcel_Cell;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;

class RbcxCardInfoRepository extends CommonRepository
{
    public static $accessor = 'cardinfo_repository';

    /**
     *
     * @return RbcxCardInfoRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    /**
     * getSignature获取签名图片
     */
    public function getSignature($id, $signature_id)
    {

        switch ($signature_id) {
            case 1:
                $signature_pic = 'static/rbcx/images/signature1.png';
                break;
            case 2:
                $signature_pic = 'static/rbcx/images/signature2.png';
                break;
            case 3:
                $signature_pic = 'static/rbcx/images/signature3.png';
                break;
            case 4:
                $signature_pic = 'static/rbcx/images/signature4.png';
                break;
            case 5:
                $signature_pic = 'static/rbcx/images/signature5.png';
                break;
        }

        $cardInfo = CardInfo::find($id);
        $order = Order::where('id', $cardInfo->order_id)->first();


        $save_path = storage_path() . '/rbcx/' . date('Y-m-d', strtotime($order->datetime));

        if (!file_exists($save_path)) {
            mkdir($save_path);
        }
        $img_pth = $save_path . '/' . $order->id;
        if (!file_exists($img_pth)) {
            mkdir($img_pth);
        }
        $image_file = $img_pth . '/signature' . $signature_id . '.png';

        if (!file_exists($image_file)) {
            $img_text = str_replace("data:image/png;base64,", "", base64_decode(str_replace("data:image/png;base64,", "", $cardInfo->signature)));
            $signature = $img_text;

            $img = Image::make($signature_pic)->resize(1785, 2562);
            $signature = Image::make($signature)->resize(500, 300);
            $img->insert($signature, 'bottom-left', 1000, 100);

            $img->save($image_file);
        }

        if (file_exists($image_file)) {
            return file_get_contents($image_file);
        } else {
            return false;
        }
    }


    /**
     * makeSignature
     */
    public function makeSignature($id, $signature_id)
    {

        switch ($signature_id) {
            case 1:
                $signature_pic = public_path() . '/static/rbcx/images/signature1.png';
                break;
            case 2:
                $signature_pic = public_path() . '/static/rbcx/images/signature2.png';
                break;
            case 3:
                $signature_pic = public_path() . '/static/rbcx/images/signature3.png';
                break;
            case 4:
                $signature_pic = public_path() . '/static/rbcx/images/signature4.png';
                break;
            case 5:
                $signature_pic = public_path() . '/static/rbcx/images/signature5.png';
                break;
        }

        $cardInfo = CardInfo::find($id);
        $order = Order::where('id', $cardInfo->order_id)->first();

        $save_path = storage_path() . '/rbcx/' . date('Y-m-d', strtotime($order->datetime));


        if (!file_exists($save_path)) {
            mkdir($save_path);
        }
        $img_pth = $save_path . '/' . $order->id;
        if (!file_exists($img_pth)) {
            mkdir($img_pth);
        }
        $image_file = $img_pth . '/signature' . $signature_id . '.png';

        if (!file_exists($image_file)) {
            $img_text = str_replace("data:image/png;base64,", "", base64_decode(str_replace("data:image/png;base64,", "", $cardInfo->signature)));
            $signature = $img_text;

            $img = Image::make($signature_pic)->resize(1785, 2562);
            $signature = Image::make($signature)->resize(500, 300);
            $img->insert($signature, 'bottom-left', 1000, 100);
            $img->save($image_file);

        }


    }

    /**
     * 临时人保车险导出
     * @param bool $downLoad
     */
    public function exportExcell($downLoad = false)
    {

        $objPHPExcel = new \PHPExcel();

        // 设置文件属性
        $objPHPExcel->getProperties()->setCreator("Kwin")
            ->setLastModifiedBy("Kwin")
            ->setTitle("The user information")
            ->setSubject("The user information")
            ->setDescription("The user information")
            ->setKeywords("The user information")
            ->setCategory("The user information");

        $cardCount = \DB::connection('mysql_rbcx')->select('SELECT card_info.`name`, card_info.card,count(card) FROM card_info GROUP BY card_info.card ASC order by count(card) desc');


//边框样式
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        $data = [];
        $i = 0;
        foreach ($cardCount as $v) {

            $cardGetOrderId = \DB::connection('mysql_rbcx')->select('SELECT order_id from card_info where card=' . $v->card);
            if (!$cardGetOrderId) {
                continue;
            }
            $j = 0;
            foreach ($cardGetOrderId as $vv) {
                $order = \DB::connection('mysql_rbcx')->select('select car_owner,license_plate,amount,(force_money+travel_tax+business_money)/100 as money from `order` where is_delete=0 and enable=1 and id=' . $vv->order_id);
                if (!$order) {
                    continue;
                }
                $order = $order[0];
                $installments = \DB::connection('mysql_rbcx')->select('SELECT * from  installment where `status`=0 and order_id=' . $vv->order_id);

                if (!$installments) {
                    continue;
                }

                foreach ($installments as $installmentKey => $installment) {
                    $data[$i]['installment'][$j][$installmentKey] = $installment;
                }

                $data[$i]['orderInfo'][$j] = (object)[
                    'car_owner' => $order->car_owner,
                    'license_plate' => $order->license_plate,
                    'money' => $order->money,
                    'amount' => $order->amount
                ];

                $j++;

            }

            $data[$i]['cardInfo'] = (object)['name' => $v->name, 'card' => $v->card];
            $i++;


        }


        $row = 1;
        foreach ($data as $v) {
            if (!isset($v['orderInfo'])) continue;
            $column = 0;
            $cardInfo = $v['cardInfo'];
            $orderInfo = $v['orderInfo'];
            $installments = $v['installment'];

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '卡主')
                ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '卡号');

            $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2F75B5');

            $column = 0;
            $row++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $cardInfo->name)
                ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $cardInfo->card);

            //边框
            // $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);


            foreach ($orderInfo as $orderKey => $order) {

                $column = 2;
                $row += 1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '车主')
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '车牌')
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '总额')
                    ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '总期数');

                $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');


                $column = 2;
                $row += 1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->car_owner)
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->license_plate)
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->money . '元')
                    ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->amount);

                //边框
                $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);


                $column = 2;
                $row += 1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '')
                    ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '金额')
                    ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '扣款时间');

                $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');

                foreach ($installments[$orderKey] as $installment) {
                    $column = 2;
                    $row += 1;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '未扣款')
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, ($installment->money / 100) . '元')
                        ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $installment->opertiontime);
                }

                //边框
                $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);


                $row += 1;
            }

            $row += 1;
        }


// 添加内容
        /*
        $row = 1;
        foreach ($cardCount as $v) {
            $column = 0;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '车主')
                ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '卡号');

            $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('2F75B5');

            $column = 0;
            $row++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $v->name)
                ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $v->card);

            //边框
            // $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);


            $cardGetOrderId = \DB::connection('mysql_rbcx')->select('SELECT order_id from card_info where card=' . $v->card);

            foreach ($cardGetOrderId as $vv) {
                $order = \DB::connection('mysql_rbcx')->select('select car_owner,license_plate,amount,(force_money+travel_tax+business_money)/100 as money from `order` where is_delete=0 and enable=1 and id=' . $vv->order_id);

                if ($order) {
                    $order = $order[0];
                    $column = 2;
                    $row += 1;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '车主')
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '车牌')
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '总额')
                        ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '总期数');

                    $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');

                    $column = 2;
                    $row += 1;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->car_owner)
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->license_plate)
                        ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->money . '元')
                        ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $order->amount);


                    //边框
                    $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);

                    $installments = \DB::connection('mysql_rbcx')->select('SELECT * from  installment where `status`=0 and order_id=' . $vv->order_id);

                    if ($installments) {
                        $column = 2;
                        $row += 1;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($startColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '')
                            ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '金额')
                            ->setCellValue($endColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '扣款时间');

                        $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $endColumn)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');

                        foreach ($installments as $installment) {
                            $column = 2;
                            $row += 1;
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, '未扣款')
                                ->setCellValue(PHPExcel_Cell::stringFromColumnIndex($column++) . $row, ($installment->money / 100) . '元')
                                ->setCellValue($lastColumn = PHPExcel_Cell::stringFromColumnIndex($column++) . $row, $installment->opertiontime);
                        }
                        //边框
                        $objPHPExcel->getActiveSheet()->getStyle($startColumn . ':' . $lastColumn)->applyFromArray($styleArray);
                        $row += 1;
                    }

                }
            }

            $row += 2;
        }
*/
        //设置列宽
        $column = 0;
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column++))->setWidth(10);

        $fileName = 'renbaochexiandaikou_' . date('YhdHis') . '.xls';

// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)

        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        if ($downLoad) {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName);
            $objWriter->save('php://output');//文件通过浏览器下载
        } else {
            $fileName = storage_path() . DIRECTORY_SEPARATOR . $fileName;
            $objWriter->save($fileName); //脚本方式运行，保存在当前目录
        }

        exit;

    }

}
