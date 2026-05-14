<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

use Illuminate\Support\Str;

class SlugTranslateHandler
{
    public function translate($text)
    {
        // 实例化 HTTP 客户端，完全禁用代理
        $http = new Client([
            'proxy' => null,
            'curl' => [
                CURLOPT_PROXY => null,
            ],
        ]);

        // 临时清除环境变量中的代理设置
        $oldHttpProxy = getenv('http_proxy');
        $oldHttpsProxy = getenv('https_proxy');
        putenv('http_proxy=');
        putenv('https_proxy=');

        // 初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        // 根据文档，生成 sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($appid. $text . $salt . $key);

        // 构建请求参数
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // 发送 HTTP Get 请求
        try {
            $response = $http->get($api . $query);
            $result = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // 请求失败时恢复环境变量并使用拼音方案
            putenv("http_proxy={$oldHttpProxy}");
            putenv("https_proxy={$oldHttpsProxy}");
            return $this->pinyin($text);
        }

        // 恢复环境变量
        putenv("http_proxy={$oldHttpProxy}");
        putenv("https_proxy={$oldHttpsProxy}");

        // 尝试获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return Str::slug($result['trans_result'][0]['dst']);
        } else {
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return Str::slug(app(Pinyin::class)->permalink($text));
    }
}