<?php
// Подключаем head
include __DIR__ . '/components/head.php';
// Подключаем header
include __DIR__ . '/components/header.php'; ?>
  <main class="main-single-category">
    <?php
    include __DIR__ . '/components/elements/breadcrumbs.php';
    include __DIR__ . '/components/sections/single-category-hero.php';
    include __DIR__ . '/components/sections/description.php';
    include __DIR__ . '/components/sections/products.php';
    include __DIR__ . '/components/sections/objects-product.php';
    include __DIR__ . '/components/sections/similar-product.php';
    include __DIR__ . '/components/sections/contact-us.php';
    include __DIR__ . '/components/sections/seo.php';
    ?>
  </main>

<?php // Подключаем footer
include __DIR__ . '/components/footer.php';


