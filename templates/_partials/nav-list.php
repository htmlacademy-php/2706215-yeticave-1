<?php

/** @var array $categories */

?>
<ul class="nav__list container">

    <?php foreach ($categories as $category): ?>
        <li class="nav__item">
            <a href="/index.php"><?= esc($category['name'] ?? '') ?></a>
        </li>
    <?php endforeach; ?>

</ul>
