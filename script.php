<?php

$token = 'Your token';
$keyWord = 'Your keyword'; // for example = Sport
$locale = 'Your locale';  // ru_RU

$url = "https://graph.facebook.com/search?type=adinterest&q=[{$keyWord}]&limit=10000&locale={$locale}&access_token={$token}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept:application/json, Content-Type:application/json']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$completeResult = \json_decode($result, true);
$data = $completeResult['data'];
curl_close($ch);

$results = [];

if (!empty($result)) {
    foreach ($data as $key => $item) {
        if (empty($item['topic'])) {
            unset($data[$key]);
            continue;
        }
        $results [] = $item['topic'].PHP_EOL;
    }
}

file_put_contents('interests.txt', array_unique($results), true);
print_r(array_unique($results));
