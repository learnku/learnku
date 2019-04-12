<?php

if (!function_exists('route_class')) {
    /**
     * 根据当前路由 生成 class
     * @return mixed
     */
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if (!function_exists('assert_images')) {
    /**
     * 七牛 images 镜像空间
     * @param $path
     * @param null $test
     * @return mixed
     */
    function assert_images($path, $test = null)
    {
        if (substr($path, 0, 1) != '/') {
            $path = '/' . $path;
        }
        if ($test) {
            return env('APP_IMAGES_URL') . $path;
        }
        return config('app.images_url') . $path;
    }
}

if (!function_exists('assert_cdns')) {
    /**
     * 七牛 cdns 镜像空间
     * @param $path
     * @param null $secure
     * @return mixed
     */
    function assert_cdns($path, $secure = null)
    {
        if (substr($path, 0, 1) != '/') {
            $path = '/' . $path;
        }
        return config('app.cdns_url') . $path;
    }
}

if (!function_exists('default_img')) {
    function default_img($img = null)
    {
        if (empty($img)) {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQMAAAEDBAMAAADD/3z4AAAAMFBMVEW8vsDR09TFxsi/wcPn6OnX2NrMztDc3d7Hycve4OHKy83Bw8XP0NIAAAAAAAAAAAC0F+PNAAAACXBIWXMAAAsTAAALEwEAmpwYAAACt0lEQVR4Ae3av27TbBTHcdfBSUs6uCISQmXokJHBEl0qFgi/xHHaoYMH2BgqsUZQqWuHSqxIzdINpFwAQy8gErkwYruH10nsWg2vzxn6+wwk6YC+OrYf58/jEBERERERERERERERUaVXz18e2BZ8AxBeWhZsIfHOMqGD1KldwVNkRnYJT3DHLmEqCZ+sTwXLk+FcEsb2CW+ZYHog5pLgmyXcSsIv01tEou+YaUyQeu/Y6SJl9Y7hTTKG9Jr4mjwLDBJukn+2Y+BD8qR1rV/gLV+J81A/IcYg92rb4FblLd+iuwZXZgzgxBFNgzu2h4UokJc7BgtUvLwiNSbqY/BWV6RDGYPuEHq5P7hInNoNQZbqvskQhKv7vmFXhrA2hoFWwpkMIc/V/EDRlCHYjWEqQygaww/nESAi92JzX/6fhG1sbsgEJjCBCUx4DAnRxYPUkfDA/00tgQlMYEL7BaJ924QOFp5ZJnhIRIFhQgep73YJctM6sUto4Y5dwqEkXJolXEmCb5ZwZp8wLUxoBeYHojO2OB0Plr5zHBlelNIV6CW4yAxWdpSM9Rfo8crmopH6bSoMlo7DQqCVICuDv7abw1dMaHyehL/XfyIZKiRUbSEIDBMmslaZJWwhMzRIeL2yZAfqCY2bIH2A8NUTWrjOHsRQPSHO3kZP8VegnLALJGNo4z++YoIskmF2HMRQN0F+q5/nEiLNBFkS+y7yfM0EuRQ/Iq+nmXCEIpFmwjkK+XoJHor19BI6KBapJTRRxtdKuEKZnlKCi1KRUsItyvkqCY0Jyh2rJOzgHqFKQoz7zBQStnCvY61PU+XC+hOaqDCrPaGLCscK3y9UCOtOOEKlWc0JP/cq1ZbAX2WYwAQm2O9f4EYSJjCBCUxgQrX23ub2HSIiIiIiIiIiIiIiIiIiIiIiIiKif/MHRAD9DcnwUkAAAAAASUVORK5CYII=";
        } else {
            return assert_images($img);
        }
    }
}


if (!function_exists('make_excerpt')) {
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return str_limit($excerpt, $length);
    }
}


if (!function_exists('markdownToHtml')) {
    /**
     * markdown 转 html
     * @param string $markdown markdown文本
     * @param string $rule markdownNoH1_6 markdown 规则
     * @param null $limit   限制大小
     * @return mixed
     */
    function markdownToHtml($markdown, $rule = 'markdownNoH1_6', $limit = null)
    {
        // 截取大小
        if ($limit) {
            if (is_numeric($limit)) {
                $markdown = substr($markdown, 0, $limit);
            } else {
                $markdown = substr($markdown, 0, strlen($markdown) / 3);
            }
        }

        // markdown to html
        $convertedHmtl = app('Parsedown')->setBreaksEnabled(true)->text($markdown);

        /** XSS 防注入 */
        $convertedHmtl = clean($convertedHmtl, $rule);

        // 代码高亮展示优化
        $convertedHmtl = str_replace("<pre><code>", '<pre><code class=" language-php">', $convertedHmtl);

        // 移除 {{}}
        // $convertedHmtl = remove_vue($convertedHmtl);

        // 返回 html
        return $convertedHmtl;
    }
}
