<?php

// Подключаем head
include __DIR__ . '/components/head.php';
// Подключаем header
include __DIR__ . '/components/header.php'; ?>
    <main class="main-page">
      <?php
      include __DIR__ . '/components/sections/hero.php';
      include __DIR__ . '/components/sections/production.php';
      include __DIR__ . '/components/sections/products.php';
      include __DIR__ . '/components/sections/map-projects.php';
      include __DIR__ . '/components/sections/objects.php';
      include __DIR__ . '/components/sections/contact-us.php';
      ?>
    </main>

<?php // Подключаем footer
include __DIR__ . '/components/footer.php';


