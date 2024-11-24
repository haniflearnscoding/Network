<?php 

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/vendor/autoload.php';
//put into try catch clause
try {
 
//1: connect to mongodb atlas
$client = new MongoDB\Client($_ENV['MONGO_URI']);

echo("valid connection");
echo("<br>");
 
//2: connect to collection (that exists):
$collection = $client->CART351->plantItems;

$collection->insertMany([
['owner_name' => 'Sarah',
'plant_name' => 'Snake Plant',
'birthDate' =>  new MongoDB\BSON\UTCDateTime(strtotime('2002-06-12')*1000),
'geoLoc'=> 'Montreal',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/one.png'
],
[
'owner_name' => 'Sarah',
'plant_name' => 'Cactus',
'birthDate' => new MongoDB\BSON\UTCDateTime(strtotime('2005-06-13')*1000),
'geoLoc'=> 'Toronto',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/seven.png'
],
 
 
[
'owner_name' => 'Sarah',
'plant_name' => 'Agapanthus',
'birthDate' => new MongoDB\BSON\UTCDateTime(strtotime('2003-03-19')*1000),
'geoLoc'=> 'Halifax',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/seventeen.png'
],
 
 
[
'owner_name' => 'Stephen',
'plant_name' => 'Baby Rubber Plant',
'birthDate' => new MongoDB\BSON\UTCDateTime(strtotime('1999-07-18')*1000),
'geoLoc'=> 'Edinborough',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/ten.png'
],
 
[
'owner_name' => 'Stephen',
'plant_name' => 'Dahlia',
'birthDate' =>new MongoDB\BSON\UTCDateTime(strtotime('2000-05-06')*1000),
'geoLoc'=> 'London',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/thirteen.png'
],
 
[
'owner_name' => 'Harold',
'plant_name' => 'Daphne',
'birthDate' => new MongoDB\BSON\UTCDateTime(strtotime('2012-10-21')*1000),
'geoLoc'=> 'New York',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/three.png'
],
[
'owner_name' => 'Martha',
'plant_name' => 'Daylily',
'birthDate' => new MongoDB\BSON\UTCDateTime(strtotime('2017-08-21')*1000),
'geoLoc'=> 'Paris',
'descript'=> 'Description for the plant',
'imagePath'=> 'images/nine.png'
]
]);
echo("succsessful insertions :)");
 
//NOW WE INSERT :)

}
 
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
