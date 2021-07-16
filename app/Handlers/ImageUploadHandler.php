<?php
/**
 *User:ywn
 *Date:2021/7/16
 *Time:13:37
 */

namespace App\Handlers;

Use Illuminate\Support\Str;

class ImageUploadHandler
{
    //只允许以下后缀名图片上传
    protected $allowed_ext=['png','jpg','gif','jpeg'];

    public function save($file,$floder,$file_prefix){
        $floder_name="uploads/images/$floder/".date("Ym/d",time());

        $upload_path=public_path().'/'.$floder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension=strtolower($file->getClientOriginalExtension())?:'png';

        //拼接文件名，前缀可以是相关模型的ID
        //如:1_1493521050_7BVc9v9ujP.png
        $filename=$file_prefix.'_'.time().'_'.Str::random(10).'.'.$extension;

        //如果上传的不是图片终止操作
        if(!in_array($extension,$this->allowed_ext)){
            return false;
        }

        //将图片移动到目标存储路径中
        $file->move($upload_path,$filename);

        return [
            'path'=>config('app.url')."/$floder_name/$filename"
        ];
    }
}
