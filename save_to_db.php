<?php

require_once('Places.php');

$places_obj = new Places;

$parent_id = $_POST['parent_id'];
$places = $_POST['places'];
foreach ($places as $place) {
    $data = [
        'name' => $place['place'],
        'zameen_id' => $place['index'],
        'parent_id' => $parent_id,
    ];
    $res = $places_obj->add_place($data);
}

?>