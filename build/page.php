<?php
/**
 * Template for displaying pages
 *
 * @package Perspectiva
 */

get_header();
?>

<main class="main-page">
    <?php
    while (have_posts()) :
        the_post();
        
        // Определяем какой шаблон использовать в зависимости от slug страницы
        $page_slug = get_post_field('post_name', get_post());
        
        switch ($page_slug) {
            case 'catalog':
                get_template_part('page-catalog');
                break;
            case 'category':
                get_template_part('page-category');
                break;
            case 'news':
                get_template_part('page-novosti-i-stati.php');
                break;
            default:
                // Стандартный вывод контента
                ?>
                <div class="container">
                    <h1><?php the_title(); ?></h1>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
                break;
        }
    endwhile;
    ?>
</main>

<?php
get_footer();
