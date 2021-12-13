<?php

require_once('Places.php');

$places = new Places;

$value = $_POST['value'];
$name = $_POST['name'];

$data = [
    'name' => $name,
    'zameen_id' => $value,
    'parent_id' => 0,
];

$res = $places->add_place($data);
if ($res !== false) {
    // $value = $res->insert_id;
    $curl = curl_init();

    get_data($curl, $value, $places);
    // if(count($places) > 0) {
    //     foreach ($places as $place) {
    //         $places = get_data($curl, $place['']);
    //     }
    // }


    curl_close($curl);

    echo json_encode('meow');
}

function get_data($curl, $value, $places)
{
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $url = 'https://www.zameen.com/add_property_single.html&ajax=1&get_city_childs=' . $value . '&width=242&v=1';
    curl_setopt($curl, CURLOPT_URL, $url);

    $result = curl_exec($curl);
    $array = explode(', ', $result);
    $html = $array[count($array) - 1];
    $place_arr = explode("</option>", $html);
    foreach ($place_arr as $index => $place) {
        if ($index == 0 || $index == count($place_arr) - 1) {
            continue;
        }
        $temp = array();
        $temp2 = array();
        $temp3 = array();
        $temp = explode("<option value=\'", $place);
        $temp2 = explode("\'    >", $temp[1]);
        $name = $temp2[1];
        $index = $temp2[0];
        echo json_encode($temp2);
        if($index != '') {
            get_data($curl, $value, $places);
        } else {
            echo json_encode('hello');
            die();
        }
        // die();

        // $data = [
        //     'name' => $name,
        //     'zameen_id' => $index,
        //     'parent_id' => $value,
        // ];
        // $res = $places->add_place($data);
        // if ($res !== false) {
        //     $value = $res->insert_id;
        //     get_data($curl, $value, $places);
        // }

        // $temp3 = [
        //     'index' => $index,
        //     'place' => $name
        // ];
        // array_push($places, $temp3);
    }
    // return $places;
}

// die();
