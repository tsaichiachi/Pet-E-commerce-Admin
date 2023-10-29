<?php
require_once("db_connect.php");

$product_id = $_GET["product_id"];

$sql = "DELETE FROM products WHERE product_id = '$product_id'";

if ($conn->query($sql) === TRUE) {
    header("location: product-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

