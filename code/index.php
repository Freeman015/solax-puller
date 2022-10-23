<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_DATABASE');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$sql = "CREATE TABLE IF NOT EXISTS data (id int(11) NOT NULL AUTO_INCREMENT, inverterSN varchar(255) NOT NULL, sn varchar(255) NOT NULL, acpower varchar(255) NOT NULL, yieldtoday varchar(255) NOT NULL, yieldtotal varchar(255) NOT NULL, feedinpower varchar(255) NOT NULL, feedinenergy varchar(255) NOT NULL, consumeenergy varchar(255) NOT NULL, feedinpowerM2 varchar(255) NOT NULL, soc varchar(255) NOT NULL, peps1 varchar(255) NOT NULL, peps2 varchar(255) NOT NULL, peps3 varchar(255) NOT NULL, inverterType varchar(255) NOT NULL, inverterStatus varchar(255) NOT NULL, uploadTime varchar(255) NOT NULL, batPower varchar(255) NOT NULL, powerdc1 varchar(255) NOT NULL, powerdc2 varchar(255) NOT NULL, powerdc3 varchar(255) NOT NULL, powerdc4 varchar(255) NOT NULL, batStatus varchar(255) NOT NULL, PRIMARY KEY (`id`));";

$conn->query($sql);

$url = getenv('URL');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36");
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json'
));
$output = curl_exec($ch);
curl_close($ch);

$data = json_decode($output, true);
$data = $data['result'];
$conn->query("INSERT INTO `data` (`inverterSN`, `sn`, `acpower`, `yieldtoday`, `yieldtotal`, `feedinpower`, `feedinenergy`, `consumeenergy`, `feedinpowerM2`, `soc`, `peps1`, `peps2`, `peps3`, `inverterType`, `inverterStatus`, `uploadTime`, `batPower`, `powerdc1`, `powerdc2`, `powerdc3`, `powerdc4`, `batStatus`) VALUES ('".$data['inverterSN']."', '".$data['sn']."', '".$data['acpower']."', '".$data['yieldtoday']."', '".$data['yieldtotal']."', '".$data['feedinpower']."', '".$data['feedinenergy']."', '".$data['consumeenergy']."', '".$data['feedinpowerM2']."', '".$data['soc']."', '".$data['peps1']."', '".$data['peps2']."', '".$data['peps3']."', '".$data['inverterType']."', '".$data['inverterStatus']."', '".$data['uploadTime']."', '".$data['batPower']."', '".$data['powerdc1']."', '".$data['powerdc2']."', '".$data['powerdc3']."', '".$data['powerdc4']."', '".$data['batStatus']."')");

echo "Data inserted successfully<br>";


?>