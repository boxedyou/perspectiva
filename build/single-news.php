<?php
// Подключаем head
include __DIR__ . '/components/head.php';
// Подключаем header
include __DIR__ . '/components/header.php'; ?>
  <main class="main-single-news">
    <?php
    include __DIR__ . '/components/elements/breadcrumbs.php';
    include __DIR__ . '/components/sections/single-news-content.php';
    include __DIR__ . '/components/sections/contact-us.php';
    include __DIR__ . '/components/sections/materials.php';
    ?>
  </main>

<?php // Подключаем footer
include __DIR__ . '/components/footer.php';


