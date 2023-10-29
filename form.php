<!doctype html>
<html lang="en">

<head>
    <title>form排版</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .dash {

            text-align: center;
            align-items: center;
        }
    </style>

</head>

<body>
    <div class="container">
        <form class="row g-3">
            <div class="col-12">
                <label for="inputname" class="form-label">商品名稱</label>
                <input type="text" class="form-control" id="inputname" placeholder="請輸入關鍵字">
            </div>

            <div class="col-md-6">
                <label for="inputcategory" class="form-label">種類/類別</label>
                <select id="inputcategory" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputquantity" class="form-label">商品數量</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="min" value="
                            <?php if (isset($_GET["min"])) echo $_GET["min"] ?>">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="max" value="
                        <?php if (isset($_GET["max"])) echo $_GET["max"] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="inputsold" class="form-label">售出數量</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="min" value="
                            <?php if (isset($_GET["min"])) echo $_GET["min"] ?>">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="max" value="
                        <?php if (isset($_GET["max"])) echo $_GET["max"] ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="inputprice" class="form-label">價錢篩選</label>
                <div class="row col-md">
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="min" value="
                            <?php if (isset($_GET["min"])) echo $_GET["min"] ?>">
                    </div>

                    <div class="col-md dash">
                        ~
                    </div>

                    <div class="col-md-5">
                        <input type="number" class="form-control" name="max" value="
                        <?php if (isset($_GET["max"])) echo $_GET["max"] ?>">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">搜尋</button>
                <button type="reset" class="btn btn-danger">重設</button>
            </div>
        </form>

        <!-- 新增商品 -->

        <h1 class="mt-5">新增商品</h1>

        <form class="row g-3">
            <div class="col-12">
                <label for="inputName" class="form-label">商品名稱</label>
                <input type="text" class="form-control" id="inputName" placeholder="">
            </div>

            <div class="col-md-6">
                <label for="inputCategory" class="form-label">種類</label>
                <select id="inputCategory" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputCategory" class="form-label">類別</label>
                <select id="inputCategory" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputPrice" class="form-label">價錢</label>
                <input type="number" class="form-control" name="price" value="">
            </div>
            <div class="col-md-4">
                <label for="inputSpecialoffer" class="form-label">售價</label>
                <input type="number" class="form-control" name="specialoffer" value="">
            </div>
            <div class="col-md-4">
                <label for="inputQuantity" class="form-label">數量</label>
                <input type="number" class="form-control" name="quantity" value="">
            </div>
            <div class="col-12">
                <label for="formFile" class="form-label">上傳圖片</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="col-12">
                <label for="productDecsription" class="form-label">商品描述</label>
                <textarea class="form-control" id="productDecsription" rows="3"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">送出</button>
                <button type="reset" class="btn btn-danger">重設</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
if (isset($_GET["name"])) {
    $name = $_GET["name"];
}

$sql = "SELECT products.*, category.category_name AS category_name, subcategory.subcategory_name AS subcategory_name
FROM products
JOIN category ON category.category_id = products.category_id
JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
WHERE 1=1";

// 商品名稱
if (isset($_GET["product_name"]) && !empty($_GET["product_name"])) {
    $product_name = $_GET["product_name"];
    $sql .= " AND product_name LIKE '%" . $product_name . "%'";
}

// 分類
if (isset($_GET["category_name"]) && !empty($_GET["category_name"])) {
    $category_name = $_GET["category_name"];
    $sql .= " AND category_name = '" . $category_name . "'";
}

// sub分類
if (isset($_GET["subcategory_name"]) && !empty($_GET["subcategory_name"])) {
    $subcategory_name = $_GET["subcategory_name"];
    $sql .= " AND subcategory_name = '" . $subcategory_name . "'";
}

// min價錢篩選
if (isset($_GET["minPrice"]) && !empty($_GET["minPrice"])) {
    $minPrice = $_GET["minPrice"];
    $sql .= " AND price > " . $minPrice;
}

// max價錢篩選
if (isset($_GET["maxPrice"]) && !empty($_GET["maxPrice"])) {
    $maxPrice = $_GET["maxPrice"];
    $sql .= " AND price < " . $maxPrice;
}

// min售價篩選
if (isset($_GET["minSpecialPrice"]) && !empty($_GET["minSpecialPrice"])) {
    $minSpecialPrice = $_GET["minSpecialPrice"];
    $sql .= " AND specialoffer > " . $minSpecialPrice;
}

// max售價篩選
if (isset($_GET["maxSpecialPrice"]) && !empty($_GET["maxSpecialPrice"])) {
    $maxSpecialPrice = $_GET["maxSpecialPrice"];
    $sql .= " AND specialoffer < " . $maxSpecialPrice;
}

// min商品數量
if (isset($_GET["minCount"]) && !empty($_GET["minCount"])) {
    $minCount = $_GET["minCount"];
    $sql .= " AND quantity > " . $minCount;
}

// max商品數量
if (isset($_GET["maxCount"]) && !empty($_GET["maxCount"])) {
    $maxCount = $_GET["maxCount"];
    $sql .= " AND quantity < " . $maxCount;
}

// min售出數量
if (isset($_GET["minSellCount"]) && !empty($_GET["minSellCount"])) {
    $minSellCount = $_GET["minSellCount"];
    $sql .= " AND sold > " . $minSellCount;
}

// max售出數量
if (isset($_GET["maxSellCount"]) && !empty($_GET["maxSellCount"])) {
    $maxSellCount = $_GET["maxSellCount"];
    $sql .= " AND sold < " . $maxSellCount;
}

require_once("db_connect.php");
$result = $conn->query($sql);

$product_count = $result->num_rows;
$perPage = 10;
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$startItem = ($page - 1) * $perPage;
$totalPage = ceil($product_count / $perPage);

$type = isset($_GET["type"]) ? $_GET["type"] : 1;

if ($type == 1) {
    $orderBy = "product_id ASC";
} elseif ($type == 2) {
    $orderBy = "product_id DESC";
} elseif ($type == 3) {
    $orderBy = "price ASC";
} elseif ($type == 4) {
    $orderBy = "price DESC";
} elseif ($type == 5) {
    $orderBy = "specialoffer ASC";
} elseif ($type == 6) {
    $orderBy = "specialoffer DESC";
} elseif ($type == 7) {
    $orderBy = "quantity ASC";
} elseif ($type == 8) {
    $orderBy = "quantity DESC";
} elseif ($type == 9) {
    $orderBy = "sold ASC";
} elseif ($type == 10) {
    $orderBy = "sold DESC";
} else {
    header("location: 404.php");
}

$sql .= " ORDER BY " . $orderBy . " LIMIT " . $startItem . ", " . $perPage;
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
    <style>
        th {
            white-space: nowrap;
        }

        .dash {

            text-align: center;
            align-items: center;
        }

        .ratio {
            width: 250px;
            height: 250px;
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>


</head>

<body>
    <div class="container">
        <h1>我的商品</h1>
        <form class="row g-3 p-2" action="product-search.php">
            <div class="col-12 mb-3 ">
                <label for="inputname" class="form-label">商品名稱</label>
                <input type="text" class="form-control" id="inputname" placeholder="請輸