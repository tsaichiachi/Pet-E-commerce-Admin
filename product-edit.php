<?php
// session_start();

if (!isset($_GET["product_id"])) {
    die("資料不存在");
}

require_once("db_connect.php");

$product_id = $_GET["product_id"];

$sql = "SELECT products.*, category.category_name AS category_name, subcategory.subcategory_name AS subcategory_name
FROM products
JOIN category ON category.category_id = products.category_id
JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
WHERE product_id='$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// 新增
$sqlCategory = "SELECT category_id, category_name FROM category";
$resultCategory = $conn->query($sqlCategory);

$sqlSubcategory = "SELECT subcategory_id, subcategory_name FROM subcategory";
$resultSubcategory = $conn->query($sqlSubcategory);
// 新增结束

if (isset($_SESSION["update_success"]) && $_SESSION["update_success"]) {
    // echo "更新成功！";
    unset($_SESSION["update_success"]);
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <title>商品編輯</title>
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
    </style>

</head>

<body>
    <div class="container-fluid">
    <h1 class="text-center my-3"><i class="fa-solid fa-paw"></i>&nbsp;商品編輯&nbsp;<i class="fa-solid fa-paw"></i></h1>
        <div class="py-2">
            <a class="btn btn-primary" href="product.php?product_id=<?= $row["product_id"] ?>">回我的商品</a>
        </div>
        <form action="doProductUpdate.php" method="post" enctype="multipart/form-data">
            <table class=" table table-bordered">
                <tr>
                    <td colspan="2">
                        <h3>第<?= $row["product_id"] ?>項商品</h3>
                        <input type="hidden" name="product_id" value="<?= $row["product_id"] ?>">
                    </td>
                </tr>
                <tr>
                    <th>商品圖片</th>
                    <td>
                        <!-- <figure class="ratio ratio-1x1">
                            <img class="object-fit-cover" src="productimages/<?= $row["image"] ?>" alt="">
                        </figure>
                        <input class="form-control" type="file" name="image"> -->

                        <!-- 即時顯示圖片 -->

                        <form runat="server">
                            <figure class="ratio ratio-1x1">
                                <img class="object-fit-cover" id="previewImage" src="productimages/<?= $row["image"] ?>" alt="">
                            </figure>
                            <input class="form-control" type="file" name="image" id="imgInp">
                        </form>

                        <script>
                            const imgInp = document.getElementById('imgInp');
                            const previewImage = document.getElementById('previewImage');

                            imgInp.onchange = evt => {
                                const [file] = imgInp.files;
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImage.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            };
                        </script>
                    </td>
                </tr>
                <tr>
                    <th>商品名稱</th>
                    <td>
                        <input type="text" class="form-control" value="<?= $row["product_name"] ?>" name="product_name">
                    </td>
                </tr>
                <tr>
                    <th>分類</th>
                    <td>
                        <select id="inputCategory" class="form-select" name="category_id">
                            <?php
                            while ($rowCategory = $resultCategory->fetch_assoc()) {
                                $selected = ($rowCategory["category_id"] == $row["category_id"]) ? "selected" : "";
                                echo "<option value='" . $rowCategory["category_id"] . "' " . $selected . ">" . $rowCategory["category_name"] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>類別</th>
                    <td>
                        <select id="inputSubcategory" class="form-select" name="subcategory_id">
                            <?php
                            while ($rowSubcategory = $resultSubcategory->fetch_assoc()) {
                                $selected = ($rowSubcategory["subcategory_id"] == $row["subcategory_id"]) ? "selected" : "";
                                echo "<option value='" . $rowSubcategory["subcategory_id"] . "' " . $selected . ">" . $rowSubcategory["subcategory_name"] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>價錢</th>
                    <td class="d-flex align-items-center">
                        <span>$</span>
                        <input type="text" class="form-control" value="<?= $row["price"] ?>" name="price">
                    </td>
                </tr>
                <tr>
                    <th>售價</th>
                    <td class="d-flex align-items-center">
                        <span>$</span>
                        <input type="text" class="form-control" value="<?= $row["specialoffer"] ?>" name="specialoffer">
                    </td>
                </tr>
                <tr>
                    <th>庫存數量</th>
                    <td>
                        <input type="text" class="form-control" value="<?= $row["quantity"] ?>" name="quantity">
                    </td>
                </tr>
                <tr>
                    <th>月銷售量</th>
                    <td>
                        <input type="text" class="form-control" value="<?= $row["sold"] ?>" name="sold">
                    </td>
                </tr>
                <tr>
                    <th>商品介紹</th>
                    <td>
                        <input type="text" class="form-control" value="<?= $row["description"] ?>" name="description">
                    </td>
                </tr>
                <tr>
                    <th>新增時間</th>
                    <td><?= $row["created_at"] ?></td>
                </tr>
                <tr>
                    <th>更新時間</th>
                    <td><?php echo date('Y-m-d H:i:s') ?></td>
                </tr>
            </table>
            <div class="py-2">
                <button class="btn btn-info" type="submit">儲存</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    