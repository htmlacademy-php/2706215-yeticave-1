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
    <!-- common styles -->
    <link href="/css/normalize.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- page styles -->
    <?php if (!empty($css_files)): ?>
        <?= include_css_files($css_files) ?>
    <?php endif; ?>
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

    <!-- page js -->
    <?php if (!empty($js_files)): ?>
        <?= include_js_files($js_files) ?>
    <?php endif; ?>
</body>

</html>
