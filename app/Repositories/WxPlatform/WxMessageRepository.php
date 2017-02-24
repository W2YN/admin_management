<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;
use App\Models\Message;
use App\Models\Wxplat\WxMultiMessage;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;


class WxMessageRepository extends CommonRepository
{
    public static $accessor = 'wxmessage_repository';

    /**
     *
     * @return WxMessageRepository
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
        if ($return_id == 3) {
            $message = $model::create($request->all());
            $message_id = $message->id;
            $count = $request->get('messagecount');
            $i = 0;
            while ($i < $count) {
                $title = 'title' . $i;
                $content_url = 'content_url' . $i;
                $res = WxMultiMessage::create(['message_id' =>$message_id , 'title' => $request->get($title), 'content_url' => $request->get($content_url)]);
                $i++;
            }
            return $message;
        }

        $res = $model::create($request->all());
        return $res;
    }


    public function updateMessage($id, Request $request)
    {
        $model = $this->model;
        $data = $model->find($id);
        $return_id = $request->get('return_id');
        if ($return_id == 2) {
            $file = $request->file('file');
            if ($file !== null) {
                $img_src = $this->saveImg($file);
            } else {
                $img_src = $data->image;
            }
            $old_path = strstr($data->image, 'storage');
            !file_exists($old_path) ?: unlink($old_path);

            $res = $data->update(array_merge($request->all(), ['image' => $img_src]));
            return $res;
        }
        if ($return_id == 3) {
            $basecount = $data->mulitmessage()->count();
            $i = 0;
            while ($i < $basecount) {
                $title = 'title' . $i;
                $content_url = 'content_url' . $i;
                $description = 'description' . $i;
                $mulitid = 'mulitid' . $i;

                $modify = WxMultiMessage::find($request->get($mulitid));

                $res = $modify->update(['title' => $request->get($title), 'content_url' => $request->get($content_url), 'description' => $request->get($description)]);
                $i++;
            }

            $count = $request->get('messagecount');

            while ($basecount < $count) {
                $title = 'title' . $basecount;
                $content_url = 'content_url' . $basecount;

                $res = WxMultiMessage::create(['message_id' => $id, 'title' => $request->get($title), 'content_url' => $request->get($content_url)]);
                $basecount++;
            }
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
