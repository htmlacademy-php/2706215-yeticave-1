<?php

/** @var string $page_title */
/** @var bool   $is_auth */
/** @var string $user_name */
/** @var string $main_class */
/** @var string $main_content */
/** @var array  $categories */

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= esc($page_title) ?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">

        <?= include_template('header.php', [
            'is_auth' => $is_auth,
            'user_name' => $user_name,
        ]) ?>

        <main class="<?= $main_class ?>">
            <?= $main_content ?>
        </main>
    </div>

    <?= include_template('footer.php', [
        'categories' => $categories,
    ]) ?>

    <script src="js/flatpickr.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
