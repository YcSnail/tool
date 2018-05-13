<?php
namespace app\index\controller;
use think\Controller;
use vendor\phpqrcode;

class Index{
    public function index()
    {

        // https://github.com/davidshimjs/qrcodejs
        return view(__FUNCTION__);
    }


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

        // 直接调用生成二维码类


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
    private function showQrcode($url='',$isSave=false,$size = 4,$level='Q',$pointSize=8){

        vendor('phpqrcode.phpqrcode');
        //实例化
        $qr = new \QRcode();
        // 输出二维码

        // 为了 ajax 调用 可返回 base64
        //会清除缓冲区的内容，并将缓冲区关闭，但不会输出内容。
        $saveFile = $qr::png($url, $isSave, $level,$size, $pointSize);

        // 返回类型
        // 1.base64
        // 2.文件路径
        // 判断是否 返回base64
        // 如过不保存为 文件,为了友好体验 则只能返回 base64

        if (!$isSave){
            ob_start();
            $imageString = base64_encode(ob_get_contents());
            ob_end_clean();
            $this->returnQrcode($imageString,1);
        }
        $this->returnQrcode($saveFile);
    }


    private function returnQrcode($str,$type=0){

        if (empty($str)){
            ajaxRes(-1,'生成二维码失败!');
        }

        $qrcodeArr = array();
        $qrcodeArr['type']= 'url';
        $qrcodeArr['str']= $str;

        if ($type){
            $qrcodeArr['type']= 'base64';
        }

        ajaxRes(0,$qrcodeArr);
    }


}
