<?php
/**
 * HttpClient.php
 * Date: 2017/1/5
 */

namespace App\Services;

use Tools\RequestClient;
/**
 * Class HttpClient 基础的http请求, 而已!
 * @package App\Services
 */
class HttpClient
{
    /**
     * @var RequestClient
     */
    private $client;

    /**
     * HttpClient constructor.
     * @param string $uri 需要请求的URL地址
     */
    public function __construct($uri='')
    {
        $this->client = new RequestClient($uri);
    }

    /**
     * 设置请求参数
     * @param array $config
     */
    public function config($config=[])
    {
        $this->client->withConfig($config);
        return $this;
    }

    /**
     * 设置请求url
     * @param string $uri
     */
    public function url($uri='')
    {
        $this->client->withURL($uri);
        return $this;
    }

    /**
     * 发起请求
     */
    public function doRequest()
    {
        return $this->client->doRequest();
    }
}