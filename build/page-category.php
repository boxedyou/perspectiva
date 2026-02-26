<?php
// Подключаем head
include __DIR__ . '/components/head.php';
// Подключаем header
include __DIR__ . '/components/header.php'; ?>
  <main class="main-category">
    <?php
    include __DIR__ . '/components/elements/breadcrumbs.php';
    include __DIR__ . '/components/sections/objects.php';
    include __DIR__ . '/components/sections/map-projects.php';
    include __DIR__ . '/components/sections/contact-us.php';
    include __DIR__ . '/components/sections/seo.php';
    ?>
  </main>

<?php // Подключаем footer
include __DIR__ . '/components/footer.php';


