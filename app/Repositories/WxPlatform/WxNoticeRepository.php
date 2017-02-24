<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;


class WxNoticeRepository extends CommonRepository
{
    public static $accessor = 'wxnotice_repository';

    /**
     *
     * @return WxNoticeRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    public function createWithImage(Request $request)
    {

        $model = $this->model;
        $return_id = $request->get('return_id');
        if ($return_id == 2) {
            $file = $request->file('file');
            if (empty($file)) {
                throw new \Exception('回复图文类信息需要上传图片');
            }
            $img_src = $this->saveImg($file);
            $res = $model::create(array_merge($request->all(), ['image' => $img_src]));
            return $res;
        }
        $res = $model::create($request->all());
        return $res;
    }

    public function updateNotice($id, Request $request)
    {
        $model = $this->model;
        $data = $model->find($id);
        $return_id = $request->get('return_id');
        if ($return_id == 2) {
            $file = $request->file('file');
            if ($file!== null) {
                $img_src = $this->saveImg($file);
            }else{
                $img_src = $data->image;
            }
            $old_path = strstr($data->image, 'storage');
            !file_exists($old_path)? :unlink($old_path);
            $res = $data->update(array_merge($request->all(), ['image' => $img_src]));
            return $res;
        }
        $res = $data->update($request->all());
        return $res;
    }


    public function saveImg($file)
    {

        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            $mimeTye = $file->getMimeType();
            $newName = md5(date('ymdhis') . $clientName) . "." . $entension;
            $movepath = $file->move('storage/wxplatform/' . date('Y-m-d') . '/' . '/', $newName);
            $path = $movepath;
        }
        $img_src = asset($path);
        return $img_src;
    }

}
