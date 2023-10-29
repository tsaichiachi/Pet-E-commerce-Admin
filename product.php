<?php
require_once("db_connect.php");

// if (!isset($_GET["product_id"])) {
//     die("資料不存在");
// }

$product_id = $_GET["product_id"];

$sql = "SELECT products.*, category.category_name AS category_name, subcategory.subcategory_name AS subcategory_name
FROM products
JOIN category ON category.category_id = products.category_id
JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
WHERE product_id = '$product_id' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);

?>

<!doctype html>
<html lang="en">

<head>
    <title>product</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .ratio {
            width: 250px;
            height: 250px;
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        dialog {
            padding: 55px 80px 55px 80px;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
    <h1 class="text-center my-3"><i class="fa-solid fa-paw"></i>&nbsp;商品介紹&nbsp;<i class="fa-solid fa-paw"></i></h1>
        <div class="py-2">
            <a class="btn btn-primary" href="product-list.php">回我的商品列表</a>
        </div>
        <table class="table table-bordered ">

            <tr>
                <td colspan="2">
                    <h3>第<?= $row["product_id"] ?>項商品</h3>
                </td>
            </tr>
            <tr>
                <th>商品圖片</th>
                <td>
                    <figure class="ratio ratio-1x1 ">
                        <img class="object-fit-cover" src="productimages/<?= $row["image"] ?>" alt="">
                    </figure>
                </td>
            </tr>
            <tr>
                <th>商品名稱</th>
                <td><?= $row["product_name"] ?></td>
            </tr>
            <tr>
                <th>分類</th>
                <td><?= $row["category_name"] ?></td>

            </tr>
            <tr>
                <th>類別</th>
                <td><?= $row["subcategory_name"] ?></td>
            </tr>
            <tr>
                <th>價錢</th>
                <td class="d-flex align-items-center"><span>$</span>
                    <?= $row["price"] ?></td>
            </tr>
            <tr>
                <th>售價</th>
                <td class="d-flex align-items-center"><span>$</span>
                    <?= $row["specialoffer"] ?></td>
            </tr>
            <tr>
                <th>庫存數量</th>
                <td><?= $row["quantity"] ?></td>
            </tr>
            <tr>
                <th>月銷售量</th>
                <td><?= $row["sold"] ?></td>
            </tr>
            <tr>
                <th>商品介紹</th>
                <td><?= $row["description"] ?></td>
            </tr>
            <tr>
                <th>建立時間</th>
                <td><?= $row["created_at"] ?></td>
            </tr>
            <tr>
                <th>上次更新時間</th>
                <td><?= $row["updated_at"] ?></td>
            </tr>
        </table>
        <div class=" py-2">
            <a class="btn btn-info" href="product-edit.php? product_id=<?= $row["product_id"] ?>">編輯</a>
            <!-- <a href="doProductDelete.php?product_id=<?= $row["product_id"] ?>" class="btn btn-danger ">刪除</a> -->

            <a href="#" class="btn btn-danger" id="delete">刪除</a>

            <dialog id="infoModal" d-flex text-align-center>
                <p>確認刪除嗎？</p>
                <button class="btn btn-info" id="cancel">取消</button>
                <a href="doProductDelete.php?product_id=<?= $row["product_id"] ?>" class="btn btn-danger" id="confirm">確認</a>

            </dialog>

            <script>
                let a = document.querySelector("#delete");
                let infoModal = document.querySelector("#infoModal");
                let confirmButton = document.querySelector("#confirm");
                let cancelButton = document.querySelector("#cancel");

                a.addEventListener("click", function() {
                    infoModal.showModal();
                });

                cancelButton.addEventListener("click", function() {
                    infoModal.close();
                });

                confirmButton.addEventListener("click", function() {
                    // 在這裡執行確認刪除的相應操作
                    // 可以使用 JavaScript 或發送到 doProductDelete.php 的請求來執行刪除
                });
            </script>
        </div>

    </div>









    <!-- Bootstrap JavaScript Libraries -->
    
</body>

</html>