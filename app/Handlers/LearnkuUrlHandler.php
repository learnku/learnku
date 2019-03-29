<?php
/**
 * Url 解析工具类
 * 用户实例：
 *  $learnkuUrl = new LearnkuUrlHandler(url()->full());
 *      $learnkuUrl->show('');
 *      $learnkuUrl->update([]);
 *      $learnkuUrl->delete([]);
 *      $learnkuUrl->changePath('');
 */

namespace App\Handlers;


class LearnkuUrlHandler
{
    protected $domain = '';
    protected $url = [];
    protected $params = [];

    /**
     *
     * LearnkuUrlHandler constructor.
     * @param string $url http://learnku.net/xxx.html?a=1&b=2
     */
    public function __construct($url)
    {
        // ['query' => 'a=1&b=2']
        $this->url = parse_url($url);

        // http://learnku.net/xxx.html?
        $this->domain = $this->url['path'];

        // [ a => 1, b => 2 ]
        if (isset($this->url['query'])) {
            parse_str($this->url['query'], $this->params);
        }
    }

    /**
     * 获取单个参数
     * @param string $key
     * @return string
     */
    public function show($key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        } else {
            return '';
        }
    }

    /**
     * 修改参数 返回完整 url
     * @param array $item [
     *      'a' => 100,
     *      'b' => 200,
     * ]
     * @return string
     */
    public function update($item = [])
    {
        $this->params = array_merge($this->params, $item);
        return $this->_getUrl();
    }

    /**
     * 删除参数 返回完整 url
     * @param array $item
     * @return string
     */
    public function delete($item = [])
    {
        $this->params = array_diff_key($this->params, $item);
        return $this->_getUrl();
    }

    /**
     * 改变 域名
     * @param $domain
     * @return string
     */
    public function changePath($domain)
    {
        $this->domain = $domain;
        return $this->_getUrl();
    }


    /**
     * 获取 完整 url => http://www.leanku.net/xxx.html?a=1&b=2
     * @return string
     */
    protected function _getUrl()
    {
        return $this->domain . '?' . http_build_query($this->params);
    }

    /**
     * 使用 http_build_query 代替
     * 获取 url 参数 【 使用 http_build_query 代替 】
     * @param $array_query
     * @return string => a=1&b=2
     */
    protected function _getUrlQuery($array_query)
    {
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }

    /**
     * 使用 parse_str 代替
     * 反转 url 参数为 params 数组 【 使用 parse_str 代替 】
     * @param $query
     * @return array
     */
    protected function _convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
}
