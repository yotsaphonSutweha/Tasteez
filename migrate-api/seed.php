<?php

$data = file_get_contents('./meals.json');

$meals = json_decode($data);

foreach ($meals as $meal) {
  // $meal_id = $meal->id;
  $name = $meal->name;
  $cat = $meal->cat;
  $instructions = $meal->instructions;
  $area = $meal->area;
  $thumbnail = $meal->thumbnail;
  $video = $meal->video;
  $source = $meal->source;
  $dateModified = $meal->dateModified;

  $query = "
  INSERT INTO meals (
    name, cat, instructions, area, thumbnail, video, source, dateModified
  ) VALUES ('${name}', '${cat}', '${instructions}', '${area}', '${thumbnail}', '${video}', '${source}', '${dateModified}');
  ";

  var_dump($query);

}
