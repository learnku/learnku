<?php
/**
 * Url 解析工具类
 * 用户实例：
 *  $learnkuUrl = new LearnkuUrlHandler(url()->full());
 *      $learnkuUrl->show('');
 *      $learnkuUrl->update([]);
 *      $learnkuUrl->delete([]);
 */

namespace App\Handlers;


class LearnkuUrlHandler
{
    protected $domain = '';
    protected $url = '';
    protected $params = [];

    public function __construct($url)
    {
        // http://learnku.net/xxx.html?a=1&b=2
        $this->url = $url;

        // http://learnku.net/xxx.html?
        $this->domain = substr($this->url, 0, strpos($this->url, '?') + 1);

        // a=1&b=2
        $this->url = str_replace($this->domain, '', $this->url);

        // [ a => 1, b => 2 ]
        $this->params = $this->_convertUrlQuery($this->url);
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
     * 获取 完整 url => http://www.leanku.net/xxx.html?a=1&b=2
     * @return string
     */
    protected function _getUrl()
    {
        return $this->domain . $this->_getUrlQuery($this->params);
    }

    /**
     * 反转 url 参数为 params 数组
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

    /**
     * 获取 url 参数
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
}
