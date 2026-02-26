<?php
// Подключаем head
include __DIR__ . '/components/head.php';
// Подключаем header
include __DIR__ . '/components/header.php'; ?>
  <main class="main-catalog">
    <?php
    include __DIR__ . '/components/sections/category-hero.php';
    include __DIR__ . '/components/sections/category-catalog.php';
    include __DIR__ . '/components/sections/seo.php';
    include __DIR__ . '/components/sections/contact-us.php';
    ?>
  </main>

<?php // Подключаем footer
include __DIR__ . '/components/footer.php';


