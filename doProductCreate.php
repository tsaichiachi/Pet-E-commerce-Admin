<?php
if (!isset($_POST["product_name"])) {
    die("請依正常管道到此頁");
}

require_once("db_connect.php");

$product_name = $_POST["product_name"]; // 從表單中取得商品名稱
$category_id = $_POST["category_id"]; // 從表單中取得分類 ID
$subcategory_id = $_POST["subcategory_id"]; // 從表單中取得類別 ID
$description = $_POST["description"]; // 從表單中取得商品描述
$price = $_POST["price"]; // 從表單中取得價錢
$specialoffer = $_POST["specialoffer"]; // 從表單中取得售價
$quantity = $_POST["quantity"]; // 從表單中取得數量
$image = $_FILES["image"]["name"]; // 從表單中取得上傳的圖片檔名

// 處理圖片檔名，可使用 mysqli_real_escape_string 函式或者準備陳述式來處理特殊字元
$image = mysqli_real_escape_string($conn, $image);

// 移動上傳的圖片到指定目錄
$targetDirectory = "productimages/"; // 定義存儲圖片的目錄
$targetFile = $targetDirectory . basename($_FILES["image"]["name"]); // 組合目標檔案路徑

if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) { // 移動上傳的圖片檔案到目標位置
    echo "上傳成功, 檔名為" . $image;

    // 假設 vendor_id 欄位為必填欄位，且存在有效的 vendor_id 值
    $vendor_id = 80; // 假設 vendor_id 的值為 80
    $sold = 0; // 假設 sold 的值為 0
    $created_at = date('Y-m-d H:i:s'); // 取得當前時間，格式為年-月-日 時:分:秒
    $updated_at = date('Y-m-d H:i:s'); // 取得當前時間，格式為年-月-日 時:分:秒

    $sql = "INSERT INTO products (product_name, category_id, subcategory_id, description, price, specialoffer, quantity, image, vendor_id, sold, created_at, updated_at) VALUES ('$product_name', '$category_id', '$subcategory_id', '$description', '$price', '$specialoffer', '$quantity', '$image', '$vendor_id', '$sold', '$created_at', '$updated_at')";

    if ($conn->query($sql) === TRUE) { // 執行 SQL 插入語句
        $latestId = $conn->insert_id; // 取得最後插入的資料 ID
        echo "資料表 products 新增資料完成，id為 $latestId";
        header("location: product-list.php"); // 重定向到商品列表頁面
    } else {
        echo "新增資料錯誤: " . $conn->error;
    }
} else {
    echo "上傳失敗";
}

$conn->close();
