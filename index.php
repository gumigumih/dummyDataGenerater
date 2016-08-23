<?php
require_once './Faker/src/autoload.php';

$faker = Faker\Factory::create('ja_JP');

$rows = 300000;

$data = array();

$data[] = array(
    "応募日時",
    "オーダー番号",
    "商品コード",
    "応募口数",
    "名前",
    "郵便番号",
    "住所",
    "TEL",
    "管理番号",
    "メルアド",
);


for($i=0; $i<$rows; $i++) {
    $data[] = array(
        $faker->dateTimeThisYear->format('Ymd'),
        $faker->regexify('[A-Z]{1}[1-9]{4}'),
        $faker->regexify('AP[1-9]{5}'),
        $faker->numberBetween($min = 1, $max = 100),
        $faker->lastName,
        $faker->postcode1."-".$faker->postcode2,
        $faker->city,
        $faker->phoneNumber,
        $faker->numberBetween($min = 10000, $max = 99999999999),
        $faker->email,
    );

    echo arr2csv($data);
    $data = array();
}


function arr2csv($fields) {
    $fp = fopen('php://temp', 'r+b');
    foreach($fields as $field) {
        fputcsv($fp, $field);
    }
    rewind($fp);
    $tmp = str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));
    return mb_convert_encoding($tmp, 'SJIS-win', 'UTF-8');
}
