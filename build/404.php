<?php
/**
 * Template for displaying 404 pages
 *
 * @package Perspectiva
 */

get_header();
?>

<main class="main-page">
    <div class="container">
        <h1>404 - Страница не найдена</h1>
        <p>Извините, запрашиваемая страница не существует.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>">Вернуться на главную</a>
    </div>
</main>

<?php
get_footer();
