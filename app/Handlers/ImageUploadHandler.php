<?php
namespace App\Handlers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{

    /**
     * 允许上传的图片扩展名
     * @var array
     */
    protected $allow_ext = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * 保存图片
     * @param \Illuminate\Http\File $file
     * @param string $folder
     * @param string $file_prefix
     * @return array
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        $folder_name = 'uploads/images/folder/' . date('Ymd', time());
        $upload_path  = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        if (!in_array($extension, $this->allow_ext)) {
            return false;
        }

        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        $file->move($upload_path, $filename);

        // 调整图片大小
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename",
        ];

    }

    /**
     * 调整图片大小
     * @param string $file_path
     * @param int $max_width
     */
    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);
        
        // 调整图片大小
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }
}