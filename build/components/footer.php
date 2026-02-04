<?php
// Убеждаемся, что функции подключены
if (!function_exists('enqueue_js_files')) {
  require_once __DIR__ . '/../function.php';
}
?>
<footer class="footer">
  <div class="container"></div>
</footer>

<?php
// Подключаем JS перед закрывающим тегом body
echo enqueue_js_files(true);
?>
</body>
</html>