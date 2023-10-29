<?php
require_once("db_connect.php");

// 檢查是否有商品名稱搜尋
if (isset($_GET["product_name"])) {
    $product_name = $_GET["product_name"];
} else {
    $product_name = "";
}

// 檢查是否有其他搜尋條件
$category_name = isset($_GET["category_name"]) ? $_GET["category_name"] : "";
$subcategory_name = isset($_GET["subcategory_name"]) ? $_GET["subcategory_name"] : "";
$minPrice = isset($_GET["minPrice"]) ? $_GET["minPrice"] : "";
$maxPrice = isset($_GET["maxPrice"]) ? $_GET["maxPrice"] : "";
$minSpecialPrice = isset($_GET["minSpecialPrice"]) ? $_GET["minSpecialPrice"] : "";
$maxSpecialPrice = isset($_GET["maxSpecialPrice"]) ? $_GET["maxSpecialPrice"] : "";
$minCount = isset($_GET["minCount"]) ? $_GET["minCount"] : "";
$maxCount = isset($_GET["maxCount"]) ? $_GET["maxCount"] : "";
$minSellCount = isset($_GET["minSellCount"]) ? $_GET["minSellCount"] : "";
$maxSellCount = isset($_GET["maxSellCount"]) ? $_GET["maxSellCount"] : "";

// 檢查目前的分頁
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

// 設定每頁顯示的商品數量
$perPage = 10;

// 建立 SQL 查詢
$sql = "SELECT products.*, category.category_name AS category_name, subcategory.subcategory_name AS subcategory_name
FROM products
JOIN category ON category.category_id = products.category_id
JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
WHERE 1=1";

// 商品名稱搜尋
if (!empty($product_name)) {
    $sql .= " AND product_name LIKE '%" . $product_name . "%'";
}

// 分類搜尋
if (!empty($category_name)) {
    $sql .= " AND category_name = '" . $category_name . "'";
}

// 類別搜尋
if (!empty($subcategory_name)) {
    $sql .= " AND subcategory_name = '" . $subcategory_name . "'";
}

// 價錢篩選
if (!empty($minPrice)) {
    $sql .= " AND price > " . $minPrice;
}

if (!empty($maxPrice)) {
    $sql .= " AND price < " . $maxPrice;
}

// 售價篩選
if (!empty($minSpecialPrice)) {
    $sql .= " AND specialoffer > " . $minSpecialPrice;
}

if (!empty($maxSpecialPrice)) {
    $sql .= " AND specialoffer < " . $maxSpecialPrice;
}

// 商品數量篩選
if (!empty($minCount)) {
    $sql .= " AND quantity > " . $minCount;
}

if (!empty($maxCount)) {
    $sql .= " AND quantity < " . $maxCount;
}

// 售出數量篩選
if (!empty($minSellCount)) {
    $sql .= " AND sold > " . $minSellCount;
}

if (!empty($maxSellCount)) {
    $sql .= " AND sold < " . $maxSellCount;
}

// 執行查詢以獲取符合條件的商品總數
$result = $conn->query($sql);
$product_count = $result->num_rows;


// 計算總頁數
$totalPage = ceil($product_count / $perPage);

// 確保目前分頁數在有效範圍內
if ($page < 1) {
    $page = 1;
} elseif ($page > $totalPage) {
    $page = $totalPage;
}


// 計算起始商品索引 若找不到對商品要這樣寫才能正確顯示
$startItem = ($page - 1) * $perPage;
$startItem = max(0, $startItem); // 確保起始索引不為負數


// 新增分頁相關的 SQL 條件
$sql .= " ORDER BY product_id LIMIT " . $startItem . ", " . $perPage;


// 再次執行查詢以取得指定分頁的商品資料
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
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
        table .tabletr {
            white-space: nowrap;
        }

        .dash {
            text-align: center;
            align-items: center;
        }

        tbody .pic {
            width: 150px;
            height: 150px;
        }

        tbody .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        th,
        td {
            width: 5%;
            text-align: center;
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
                <label for="inputprice" class="form-label">價錢篩選</label>
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
                <label for="inputprice" class="form-label">售價篩選</label>
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
                <label for="inputquantity" class="form-label">商品數量</label>
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
                <label for="inputsold" class="form-label">售出數量</label>
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
                <?php if (isset($_GET["product_name"])) : ?>
                    <div>
                        共有<?= $product_count ?>筆符合的資料，
                        共 <?= $totalPage ?> 頁，第<?= $page ?>頁
                    </div>
                <?php endif; ?>
            </div>

            <!-- <div class="btn-group m-2">
                <a href="product-search.php?page=<?= $page ?>&type=1" class="btn btn btn-outline-secondary
                <?php if ($type == 1) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>編號</a>

                <a href="product-search.php?page=<?= $page ?>&type=2" class="btn btn-outline-dark
                <?php if ($type == 2) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>編號</a>
            </div> -->

            <!-- <div class="btn-group m-2">
                <a href="product-search.php?page=<?= $page ?>&type=3" class="btn btn btn-outline-secondary
                <?php if ($type == 3) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>價錢</a>

                <a href="product-search.php?page=<?= $page ?>&type=4" class="btn btn-outline-dark
                <?php if ($type == 4) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>價錢</a>
            </div> -->

            <!-- <div class="btn-group m-2">
                <a href="product-search.php?page=<?= $page ?>&type=5" class="btn btn btn-outline-secondary
                <?php if ($type == 5) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>售價</a>

                <a href="product-search.php?page=<?= $page ?>&type=6" class="btn btn-outline-dark
                <?php if ($type == 6) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>售價</a>
            </div> -->

            <!-- <div class="btn-group m-2">
                <a href="product-search.php?page=<?= $page ?>&type=7" class="btn btn btn-outline-secondary
                <?php if ($type == 7) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>庫存數量</a>

                <a href="product-search.php?page=<?= $page ?>&type=8" class="btn btn-outline-dark
                <?php if ($type == 8) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>庫存數量</a>
            </div> -->

            <!-- <div class="btn-group m-2">
                <a href="product-search.php?page=<?= $page ?>&type=9" class="btn btn btn-outline-secondary
                <?php if ($type == 9) echo "active"; ?>"><i class="fa-solid fa-arrow-up"></i>月銷售量</a>

                <a href="product-search.php?page=<?= $page ?>&type=10" class="btn btn-outline-dark
                <?php if ($type == 10) echo "active"; ?>"><i class="fa-solid fa-arrow-down"></i>月銷售量</a>
            </div> -->

            <a class="btn btn-primary m-2" href="product-list.php">返回我的商品</a>
            <a class="btn btn-primary m-2" href="create-product.php">新增商品</a>
        </div>


        <table class="table table-bordered ">
            <thead>
                <tr class="tabletr">
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
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= $row["product_id"] ?></td>
                        <td>
                            <figure class="ratio ratio-1x1 pic">
                                <img class="object-fit-cover " src="productimages/<?= $row["image"] ?>" alt="">
                            </figure>
                        </td>
                        <td><?= $row["product_name"] ?></td>
                        <td><?= $row["category_name"] ?></td>
                        <td><?= $row["subcategory_name"] ?></td>
                        <td>$<?= $row["price"] ?></td>
                        <td>$<?= $row["specialoffer"] ?></td>
                        <td><?= $row["quantity"] ?></td>
                        <td><?= $row["sold"] ?></td>
                        <td><?= $row["created_at"] ?></td>
                        <td><?= $row["updated_at"] ?></td>
                        <td>
                            <a href="product.php?product_id=<?= $row["product_id"] ?>" class="btn btn-success mt-2">詳細</a>
                            <a href="product-edit.php?product_id=<?= $row["product_id"] ?>" class="btn btn-info">編輯</a>
                            <a href="doProductDelete.php?product_id=<?= $row["product_id"] ?>" class="btn btn-danger">刪除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>



        <div class="col-12 d-flex justify-content-center align-items-center ">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <!-- 需在分頁連結中增加篩選的條件 非常重要！ 不然就會一直出現全部商品的分頁 -->
                            <a class="page-link" href="product-search.php?page=
                            <?php echo $i; ?><?php echo isset($_GET['product_name']) ? '&product_name=' . $_GET['product_name'] : ''; ?><?php echo isset($_GET['category_name']) ? '&category_name=' . $_GET['category_name'] : ''; ?><?php echo isset($_GET['subcategory_name']) ? '&subcategory_name=' . $_GET['subcategory_name'] : ''; ?><?php echo isset($_GET['minPrice']) ? '&minPrice=' . $_GET['minPrice'] : ''; ?><?php echo isset($_GET['maxPrice']) ? '&maxPrice=' . $_GET['maxPrice'] : ''; ?><?php echo isset($_GET['minSpecialPrice']) ? '&minSpecialPrice=' . $_GET['minSpecialPrice'] : ''; ?><?php echo isset($_GET['maxSpecialPrice']) ? '&maxSpecialPrice=' . $_GET['maxSpecialPrice'] : ''; ?><?php echo isset($_GET['minCount']) ? '&minCount=' . $_GET['minCount'] : ''; ?><?php echo isset($_GET['maxCount']) ? '&maxCount=' . $_GET['maxCount'] : ''; ?><?php echo isset($_GET['minSellCount']) ? '&minSellCount=' . $_GET['minSellCount'] : ''; ?><?php echo isset($_GET['maxSellCount']) ? '&maxSellCount=' . $_GET['maxSellCount'] : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>


    </div>

    <!-- Bootstrap JavaScript Libraries -->
   
</body>

</html>