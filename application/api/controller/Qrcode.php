<?php
// +----------------------------------------------------------------------
// |  [ 我的梦想是星辰大海 ]
// +----------------------------------------------------------------------
// | Author: yc  yc@yuanxu.top
// +----------------------------------------------------------------------
// | Date: 2018/5/16 Time: 22:03
// +----------------------------------------------------------------------
namespace app\api\controller;

class Qrcode{

    public function getQrcode(){


        $post = input('post.');

        if (empty($post)){
            ajaxRes(-1,'提交内容不能为空!');
        }

        // 获取 提交类型
        $type = !empty($post['style']) ? $post['style'] : 'text';

        switch ($type){
            case 'text';
                $this->text($post);
                break;

            case 'file';
                $this->file($post);
                breaK;

        }

        return view(__FUNCTION__);
    }

    /**
     * 生成二维码
     * 文字类型
     */
    private function text($post){

        if (!isset($post['text'])){
            ajaxRes(-1,'文字信息不能为空!');
        }

        // 直接调用生成二维码类
        $this->showQrcode($post['text']);

    }

    /**
     * 生成二维码
     * 文件类型
     */
    private function file($post){


        // 获取文件信息

        //上传七牛云


        // 获取返回地址


        // 调用生成二维码方法

    }

    /**
     * 生成二维码方法
     * @param string $url 文字信息
     * @param bool $isSave 是否保存为文件
     * @param int $size     图片大小
     * @param string $level 图片等级
     * @param int $pointSize 点大小
     */
    private function showQrcode($url='',$isSave=true,$size = 4,$level='Q',$pointSize=8){

        vendor('phpqrcode.phpqrcode');
        //实例化
        $qr = new \QRcode();
        // 输出二维码

        // 为了 ajax 调用 可返回 base64
        //会清除缓冲区的内容，并将缓冲区关闭，但不会输出内容。

        // 判断文件夹是否存在

        $dir = 'qrcode';
        if (!is_dir($dir)) {
            @mkdir($dir);
            chmod($dir,0777);
        }

        $fileName = $dir.'/'.date("YmdHis").'.png';

        $qr::png($url, $fileName, $level,$size, $pointSize);

        // 返回类型
        // 1.base64
        // 2.文件路径
        // 判断是否 返回base64
        // 如过不保存为 文件,为了友好体验 则只能返回 base64
        if (file_exists($fileName)){
            ajaxRes(0,$fileName);
        }
        ajaxRes(-1,'生成二维码失败!');
    }

}