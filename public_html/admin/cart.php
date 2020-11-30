<?php
require '../../bootloader.php';

$nav = nav();

if (is_logged_in()) {
    $user_key = is_logged_user();
    $rows = file_to_array(DB_FILE);

    if (isset($_POST['id'])) {
        foreach ($rows['items'] ?? [] as $key => $items) {
            if ($items['id'] == $_POST['id']) {
                $rows['users'][$user_key]['cart'][] = $items;
                $rows['items'][$key]['disabled'] = 'true';
            }
        }

        array_to_file($rows, DB_FILE);
    }
    $products = $rows['users'][$user_key]['cart'] ?? [];

    $total = 0;

    foreach ($products as $product) {
        $total += $product['price'];
    }

    $h3 = 'Jusu krepselis' . ' ' . $_SESSION['email'];
} else {
    header("Location: /login.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>My Order</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.tpl.php'; ?>
    <article class="wrapper">
        <h1 class="header header--main">My Order</h1>
        <h3 class="header"><?php print $h3; ?></h3>
        <section class="grid-container">

            <?php if ($products == []): ?>

                <h2>List is empty</h2>

            <?php else : ?>

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
        <div>
            <h2>Total: <?php print $total; ?>$</h2>
            <form method="POST" action="/admin/my.php">
                <input type="hidden" name="id" value="PIRKTI">
                <button type="submit">Checkout</button>
            </form>
        </div>
    </article>
</main>
</body>
</html>