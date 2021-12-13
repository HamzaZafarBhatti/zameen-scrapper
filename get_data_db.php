<?php

require_once('Places.php');

$places = new Places;

$value = $_POST['value'];
$name = $_POST['name'];
$parent_id = $_POST['parent_id'];


$data = [
    'name' => $name,
    'zameen_id' => $value,
    'parent_id' => $parent_id,
];

$res = $places->add_place($data);
if ($res != false) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $url = 'https://www.zameen.com/add_property_single.html&ajax=1&get_city_childs=' . $value . '&width=242&v=1';

    curl_setopt($curl, CURLOPT_URL, $url);

    $result = curl_exec($curl);

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
    curl_close($curl);
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
