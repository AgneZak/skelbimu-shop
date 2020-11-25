<?php
require '../bootloader.php';

$nav = nav();


$products_array = file_to_array(DB_FILE);
$products = $products_array['items'] ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Shop</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.tpl.php'; ?>
    <article class="wrapper">
        <h1 class="header header--main">Welcome to BBZ SHOP</h1>
        <section class="grid-container">
            <?php if ($products == []): ?>
                <h2>List is empty</h2>
            <?php else: ?>
                <?php foreach ($products as $product) : ?>
                    <div class="grid-item">
                        <h4><?php print $product['name']; ?></h4>
                        <img class="product-img" src="<?php print $product['img']; ?>" alt="">
                        <p><?php print $product['descrip']; ?></p>
                        <p><?php print $product['price']; ?> $</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </article>
</main>
</body>
</html>