<?php

/** @var string $page_title */
/** @var bool $is_auth */
/** @var array $user */
/** @var string $main_class */
/** @var string $main_content */
/** @var array $categories */
/** @var array $css_files */
/** @var array $js_files */

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= esc($page_title) ?></title>
    <!-- common styles -->
    <link href="/assets/css/normalize.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <!-- page styles -->
    <?php if (!empty($css_files)): ?>
        <?= include_asset_files($css_files, ASSET_TYPE_CSS) ?>
    <?php endif; ?>
</head>

<body>
    <div class="page-wrapper">

        <?= include_template('layout/header.php', [
            'is_auth' => $is_auth,
            'user' => $user,
        ]) ?>

        <main class="<?= $main_class ?>">
            <?= $main_content ?>
        </main>
    </div>

    <?= include_template('layout/footer.php', [
        'categories' => $categories,
    ]) ?>

    <!-- page js -->
    <?php if (!empty($js_files)): ?>
        <?= include_asset_files($js_files, ASSET_TYPE_JS) ?>
    <?php endif; ?>
</body>

</html>
