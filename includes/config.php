<?php 
// DB credentials. running on my sql server, default, user root with no password
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','vehiclepurchase');
// Establish database connection.
$link = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>