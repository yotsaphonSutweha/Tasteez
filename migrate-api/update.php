<?php


ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$app->get('/update', function (Request $request, Response $response, array $args) {
  $data = file_get_contents('../migrate-api/meals.json');

  $meals = json_decode($data);

  foreach ($meals as $meal) {
    $meal_id = $meal->id;
    $name = $meal->name;
    $cat = $meal->cat;
    $instructions = addslashes($meal->instructions);
    $area = $meal->area;
    $thumbnail = $meal->thumbnail;
    $video = $meal->video;
    $source = $meal->source;
    $dateModified = $meal->dateModified;

    $query = "INSERT INTO meals (
      `id`, `name`, `cat`, `instructions`, `area`, `thumbnail`, `video`, `source`, `dateModified`
    ) VALUES (\"${meal_id}\", \"${name}\", \"${cat}\", \"${instructions}\", \"${area}\", \"${thumbnail}\", \"${video}\", \"${source}\", \"${dateModified}\");
    ";

    $this->db->query($query);

  }
  var_dump($query . " \n");

    return $response->withJson(1);
});
