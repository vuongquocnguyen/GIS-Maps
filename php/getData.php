<?php
ini_set('display_errors', 1); 

//database login info
$host = 'localhost';
$port = '5432';
$dbname = 'busroute';
$user = 'postgres';
$password = 'postgres';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
	echo "Not connected : " . pg_error();
	exit;
}

//get the table and fields data
$table = $_GET['rels'];
$fields = $_GET['fields'];

//turn fields array into formatted string
$fieldstr = "";
foreach ($fields as $i => $field){
	$fieldstr = $fieldstr . "l.$field, ";
}

//get the geometry as geojson in WGS84
$fieldstr = $fieldstr . "ST_AsGeoJSON(ST_Transform(l.geom,4326))";

//if a query, add those to the sql statement
if (isset($_GET['from-point'])){
	$frompoint = $_GET['from-point'];
	$topoint = $_GET['to-point']; 
	$frompoint= mb_strtoupper($frompoint,"UTF-8");
	//join for spatial query - table geom is in EPSG:26916
	$sql = 'select a.lat,a.lon,b.name,b.ref from rels as a,"export-line" as b where a.id=b.id and UPPER(b.name)'."like '%$frompoint%' limit 1 ";
	$sql1 = 'select b."@relations",b.name ,a.lat,a.lon from "export-line" as b, rels as a where a.id=b.id; ';
}

// echo $sql;

//send the query
if (!$response = pg_query($conn, $sql)) {
	echo "A query error occured.\n";
	exit;
}
if (!$response2 = pg_query($conn, $sql1)) {
	echo "A query error occured.\n";
	exit;
}
//echo the data back to the DOM
while ($row = pg_fetch_row($response)) {
	//foreach ($row as $i => $attr){
	//	echo $attr.", ";
	//}
		while ($row2 = pg_fetch_row($response2)) {
			if($row2[0]!=NULL){
					$dt=json_decode($row2[0]);
					$dt=$dt[0]->reltags;
						if($row[3]!=NULL && $row[3]==$dt->ref){
							echo $row2[2].", ";
							echo $row2[3].", ";
							echo ";";
			}		}
		}
	
}


?>