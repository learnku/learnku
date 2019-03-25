<?php
/**
 * Created by PhpStorm.
 * User: GucciLee
 * Date: 2019/3/25
 * Time: 16:40
 */

namespace App\Http\Controllers\Traits;


trait Markdown
{
    /**
     * markdown -> html
     * @param $markdown
     * @return mixed
     */
    public function markdownToHtml($markdown)
    {
        // markdown to html
        $convertedHmtl = app('Parsedown')->setBreaksEnabled(true)->text($markdown);

        /** XSS 防注入 */
        $convertedHmtl = clean($convertedHmtl, 'markdown');

        // 代码高亮展示优化
        $convertedHmtl = str_replace("<pre><code>", '<pre><code class=" language-php">', $convertedHmtl);

        // 移除 {{}}
        // $convertedHmtl = remove_vue($convertedHmtl);

        // 返回 html
        return $convertedHmtl;
    }
}
