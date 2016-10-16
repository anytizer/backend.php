<?php
// https://github.com/dtrenz/laravel-model-demo

error_reporting(E_ALL|E_STRICT);

$columns_sql = "
SELECT
	TABLE_NAME,
	COLUMN_NAME,
	DATA_TYPE,
	COLUMN_TYPE,
	COLUMN_COMMENT
FROM INFORMATION_SCHEMA.`COLUMNS`
WHERE
	TABLE_SCHEMA = 'mysql'
ORDER BY
	TABLE_NAME,
	ORDINAL_POSITION
;";
$database = "mysql";
$connection = new mysqli("localhost", "root", "toor", "test");
$rs = $connection->query($columns_sql);

$dtos = array();
while($row = $rs->fetch_assoc())
{
    #print_r($row);

    $dtos[$row['TABLE_NAME']][] = property($row);
}

#print_r($dtos);

foreach($dtos as $class => $dto)
{
  classify($class, $dto);
}

class PropertyDTO
{
    public $accessor;
    public $field_name;
    public $datatype;
    public $comment;
}

function property($row)
{
    $PropertyDTO = new PropertyDTO();
    $PropertyDTO->accessor="public";
    $PropertyDTO->field_name = $row['COLUMN_NAME'];
    $PropertyDTO->datatype = $row['DATA_TYPE'];
    $PropertyDTO->comment = $row['COLUMN_COMMENT'];

    if($row['COLUMN_COMMENT'])
        return "public \${$row['COLUMN_NAME']}; // {$row['DATA_TYPE']}: {$row['COLUMN_COMMENT']}";
    else
        return "public \${$row['COLUMN_NAME']}; // {$row['DATA_TYPE']}";
}

function classify($class, $properties)
{
    $namespace = 'dtos';

    $classes = preg_split("/_+/", $class);
    array_unshift($classes, $namespace);
    #print_r($classes);
    array_splice($classes, -1, 1);
    #print_r($classes);
    $namespace = implode("\\", $classes);

    $properties = implode("\r\n    ", $properties);

    $template = file_get_contents("templates/php/class.template.inc.php");

    file_put_contents("classes/class.{$class}.inc.php", $template);
    return $template;
}
