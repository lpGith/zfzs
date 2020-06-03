<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/6/3
 * Time: 10:16
 */

use QL\QueryList;

require __DIR__ . '/func.php';
require __DIR__ . '/vendor/autoload.php';

$db = new PDO('mysql:host=localhost;dbname=zfang;charset=utf8', 'root', '000000');


$sql = "select id,url from zfw_articles where body=''";


$rows = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $v) {
    $id = $v['id'];
    $url = $v['url'];

    $html = http_request($url);

    $ret = QueryList::Query($html, [
        "body" => ['.bd', 'html']
    ])->data;

    $body = $ret[0]['body'];

    $sql = "update zfw_articles set body=? where id=?";

    $stmt = $db->prepare($sql);

    $stmt->execute([$body, $id]);
}
