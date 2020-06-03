<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/6/3
 * Time: 9:25
 */

//set_time_limit(0);//永不超时

use QL\QueryList;


require __DIR__ . '/func.php';
require __DIR__ . '/vendor/autoload.php';

$db = new PDO('mysql:host=localhost;dbname=zfang;charset=utf8', 'root', '000000');


$rang = range(3, 4);

foreach ($rang as $page) {
    $url = 'https://news.ke.com/bj/baike/0033/pg' . $page . '/';
    $html = http_request($url);

    $list = QueryList::Query($html, [
        "pic" => ['.lj-lazy', 'data-original', '', function ($item) {
            $ext = pathinfo($item, PATHINFO_EXTENSION);

            $filename = md5($item) . '_' . time() . '.' . $ext;
            $filepath = dirname(__DIR__) . '/public/uploads/article' . $filename;

            file_put_contents($filepath, http_request($item));
            return '/uploads/article' . $filename;
        }],
        'title' => ['.item .text .LOGCLICK', 'text'],
        'desn' => ['.item .text .summary', 'text'],
        'url' => ['.item .text > a', 'href']
    ])->data;


    foreach ($list as $v) {

        $sql = "insert into zfw_articles (title,desn,pic,url,body) values(?,?,?,?,'')";

        $stmt = $db->prepare($sql);

        $stmt->execute([$v['title'], $v['desn'], $v['pic'], $v['url']]);
    }


}
