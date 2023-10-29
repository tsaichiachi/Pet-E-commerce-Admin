<?php
require_once("db_connect.php");


$page = $_GET["page"] ?? 1;
$type = $_GET["type"] ?? 1;

$sqlTotal = "SELECT product_id FROM products ";
$resultTotal = $conn->query($sqlTotal);
$totalProduct = $resultTotal->num_rows;

$perPage = 10;
$startItem = ($page - 1) * $perPage;

$totalPage = ceil($totalProduct / $perPage);

if ($type == 1) {
    $orderBy = "ORDER BY product_id ASC";
} elseif ($type == 2) {
    $orderBy = "ORDER BY product_id DESC";
} elseif ($type == 3) {
    $orderBy = "ORDER BY price ASC";
} elseif ($type == 4) {
    $orderBy = "ORDER BY price DESC";
} elseif ($type == 5) {
    $orderBy = "ORDER BY specialoffer ASC";
} elseif ($type == 6) {
    $orderBy = "ORDER BY specialoffer DESC";
} elseif ($type == 7) {
    $orderBy = "ORDER BY quantity ASC";
} elseif ($type == 8) {
    $orderBy = "ORDER BY quantity DESC";
} elseif ($type == 9) {
    $orderBy = "ORDER BY sold ASC";
} elseif ($type == 10) {
    $orderBy = "ORDER BY sold DESC";
} else {
    header("location: 404.php");
}

// $sql = "SELECT * FROM products WHERE product_id $orderBy  LIMIT $startItem,$perPage";
// $result = $conn->query($sql);

$sql = "SELECT products.*, category.category_name AS category_name, subcategory.subcategory_name AS subcategory_name 
FROM products
JOIN category ON category.category_id = products.category_id
JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id

WHERE products.product_id $orderBy
LIMIT $startItem, $perPage";
$result = $conn->query($sql);

?>

<!doctype html>
<html lang="en">

<head>
    <title>我的商品</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        th {
            white-space: nowrap;
        }

        .dash {

            text-align: center;
            align-items: center;
        }

        .ratio {
            width: 150px;
            height: 150px;
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        th,
        td {
            width: 5%;
            text-align: center;
        }

        dialog {
            padding: 55px 80px 55px 80px;
        }
    </style>


</head>

<body>
    <div class="container-fluid">
    <h1 class="text-center my-3"><i class="fa-solid fa-paw"></i>&nbsp;我的商品&nbsp;<i class="fa-solid fa-paw"></i></h1>
        <form class="row g-3 p-2" action="product-search.php">

            <div class="col-12 mb-3 ">
                <label for="inputname" class="form-label">商品名稱</label>
                <input type="text" class="form-control" id="inputname" placeholder="請輸入關鍵字" name="product_name">
            </div>
            <hr>

            <div class="col-md-6">
                <label for="inputCategory" class="form-label">分類</label>
                <select id="inputCategory" class="form-select" name="category_name">
                    <option selected></option>
                    <?php
                    $sqlCategory = "SELECT category_name FROM category";
                    $resultCategory = $conn->query($sqlCategory);
                    while ($rowCategory = $resultCategory->fetch_assoc()) {
                        echo "<option>" . $rowCategory["category_name"] . "</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="col-md-6">
                <label for="inputsubCategory" class="form-label">類別</label>
                <select id="inputsubCategory" class="form-select" name="subcategory_name">
                    <option selected></option>
                    <?php
                    $sqlSubcategory = "SELECT subcategory_name FROM subcategory";
                    $resultSubcategory = $conn->query($sqlSubcategory);
                    while ($rowSubcategory = $resultSubcategory->fetch_assoc()) {
                        echo "<option>" . $rowSubcategory["subcategory_name"] . "</option>";
                    }
                    ?>
                </select>
            </div>



            <div class="col-md-6">
                <label for="inputprice" class="form-label">價錢</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="minPrice" value="">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="maxPrice" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputprice" class="form-label">售價</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="minSpecialPrice" value="">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="maxSpecialPrice" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputquantity" class="form-label">庫存數量</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="minCount" value="">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="maxCount" value="">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="inputsold" class="form-label">月銷售量</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="minSellCount" value="">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="maxSellCount" value="">
                    </div>
                </div>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn-primary">搜尋</button>
                <button type="reset" class="btn  btn-outline-secondary">重設</button>
            </div>

        </form>
        <hr>


        <!-- <?php echo date('Y-m-d H:i:s') ?> -->

        <div class="col-12 d-flex justify-content-end align-items-center p-2">

            <div class=" p-2">
                <?php
                $products_count = $result->num_rows;
                ?>
                共<?= $totalProduct ?> 件商品，共 <?= $totalPage ?> 頁，第 <?= $page ?> 頁

            </div>

            <div class="btn-group m-2">
                <a href="product-list.php?page=<?= $page ?>&type=1" class="btn btn btn-outline-secondary
                <?php if ($type == 1) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>編號</a>

                <a href="product-list.php?page=<?= $page ?>&type=2" class="btn btn-outline-dark
                <?php if ($type == 2) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>編號</a>
            </div>

            <div class="btn-group m-2">
                <a href="product-list.php?page=<?= $page ?>&type=3" class="btn btn btn-outline-secondary
                <?php if ($type == 3) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>價錢</a>

                <a href="product-list.php?page=<?= $page ?>&type=4" class="btn btn-outline-dark
                <?php if ($type == 4) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>價錢</a>
            </div>

            <div class="btn-group m-2">
                <a href="product-list.php?page=<?= $page ?>&type=5" class="btn btn btn-outline-secondary
                <?php if ($type == 5) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>售價</a>

                <a href="product-list.php?page=<?= $page ?>&type=6" class="btn btn-outline-dark
                <?php if ($type == 6) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>售價</a>
            </div>

            <div class="btn-group m-2">
                <a href="product-list.php?page=<?= $page ?>&type=7" class="btn btn btn-outline-secondary
                <?php if ($type == 7) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>庫存數量</a>

                <a href="product-list.php?page=<?= $page ?>&type=8" class="btn btn-outline-dark
                <?php if ($type == 8) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>庫存數量</a>
            </div>

            <div class="btn-group m-2">
                <a href="product-list.php?page=<?= $page ?>&type=9" class="btn btn btn-outline-secondary
                <?php if ($type == 9) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>月銷售量</a>

                <a href="product-list.php?page=<?= $page ?>&type=10" class="btn btn-outline-dark
                <?php if ($type == 10) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>月銷售量</a>
            </div>
            <a class="btn btn-primary m-2" href="create-product.php">新增商品</a>
        </div>


        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>圖片</th>
                    <th>商品名稱</th>
                    <!-- <th>廠商</th> -->
                    <th>分類</th>
                    <th>類別</th>
                    <!-- <th>描述</th> -->
                    <th>價錢</th>
                    <th>售價</th>
                    <th>庫存數量</th>
                    <th>月銷售量</th>
                    <th>建立時間</th>
                    <th>更新時間</th>
                    <th class="text-nowrap ">操作</th>
                    <!-- <th>created_at</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row["product_id"] ?></td>
                        <td>
                            <!-- <?= $row["image"] ?> -->
                            <figure class="ratio ratio-1x1 ">
                                <img class="object-fit-cover" src="productimages/<?= $row["image"] ?>" alt="">
                            </figure>
                        </td>
                        <td><?= $row["product_name"] ?></td>
                        <!-- <td><?= $row["vendor_id"] ?></td> -->
                        <td><?= $row["category_name"] ?></td>
                        <td><?= $row["subcategory_name"] ?></td>
                        <!-- <td><?= $row["description"] ?></td> -->
                        <td>$<?= $row["price"] ?></td>
                        <td>$<?= $row["specialoffer"] ?></td>
                        <td><?= $row["quantity"] ?></td>
                        <td><?= $row["sold"] ?></td>
                        <td><?= $row["created_at"] ?></td>
                        <td><?= $row["updated_at"] ?></td>
                        <td>
                            <a href="product.php?product_id=<?= $row["product_id"] ?>" class="btn btn-success mt-2">詳細</a>
                            <a href="product-edit.php?product_id=<?= $row["product_id"] ?>" class="btn btn-info ">編輯</a>

                            <!-- <a href="doProductDelete.php?product_id=<?= $row["product_id"] ?>" class="btn btn-danger ">刪除</a> -->

                            <a href="#" class="btn btn-danger" id="delete">刪除</a>

                            <dialog id="infoModal">
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
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="col-12 d-flex justify-content-center align-items-center ">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                        <li class="page-item 
                        <?php
                        if ($i == $page) echo "active"; ?>"><a class="page-link " href="product-list.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>


    </div>

    <!-- Bootstrap JavaScript Libraries -->
    
</body>

</html>