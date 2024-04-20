<?php
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
$sql = 'SELECT b.lat,b.lon, a.id, a.ref FROM "export-point" as a,"rels" as b where a.id=b.id and a.ref<> '."'NULL';";
if (!$response = pg_query($conn, $sql)) {
	echo "- A query error occured.\n";
	exit;
}
while ($row = pg_fetch_row($response)) {			
		echo $row[0].", ";
		echo $row[1].", ";
		echo $row[2].", ";
		echo $row[3].", ";
		echo ";";

}
	