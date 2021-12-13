<?php

$value = $_POST['value'];

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// foreach ($cities as $value => $city) {
$url = 'https://www.zameen.com/add_property_single.html&ajax=1&get_city_childs=' . $value . '&width=242&v=1';

curl_setopt($curl, CURLOPT_URL, $url);

$result = curl_exec($curl);

$filename =  'city.json';
$fp = fopen($filename, 'w');
$array = explode(', ', $result);
$html = $array[count($array) - 1];
$place_arr = explode("</option>", $html);
$places = array();
foreach ($place_arr as $index => $place) {
    if ($index == 0 || $index == count($place_arr) - 1) {
        continue;
    }
    $temp = array();
    $temp2 = array();
    $temp3 = array();
    $temp = explode("<option value=\'", $place);
    $temp2 = explode("\'    >", $temp[1]);
    $temp3 = [
        'index' => $temp2[0],
        'place' => $temp2[1]
    ];
    array_push($places, $temp3);
}
$written = fwrite($fp, json_encode($places, JSON_PRETTY_PRINT));
$close = fclose($fp);
// }
curl_close($curl);

if ($close) {
    $response = [
        'status' => 1,
        'result' => $places
    ];
} else {
    $response = [
        'status' => 0
    ];
}
echo json_encode($response);
