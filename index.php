
<?php
// echo "row count";
include "connect.php";
$stmt = $con->prepare("SELECT * FROM users");
$stmt->execute();
$category =$stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
echo "<pre>";
print_r($category);
echo "</pre>";
// echo "row count : ".$count;
?>