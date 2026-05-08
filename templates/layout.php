<?php

/** @var string $page_title */
/** @var bool   $is_auth */
/** @var string $user_name */
/** @var string $main_content */
/** @var array  $categories */

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">

        <?php echo include_template('header.php', [
            'is_auth' => $is_auth,
            'user_name' => $user_name,
        ]); ?>

        <main class="container">
            <?= $main_content ?>
        </main>
    </div>

    <?php echo include_template('footer.php', [
        'categories' => $categories,
    ]); ?>

    <script src="flatpickr.js"></script>
    <script src="script.js"></script>
</body>

</html>
