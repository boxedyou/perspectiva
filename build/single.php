<?php
/**
 * Template for displaying single posts
 *
 * @package Perspectiva
 */

get_header();
?>

<main class="main-page">
    <?php
    while (have_posts()) :
        the_post();
        
        $post_type = get_post_type();
        
        switch ($post_type) {
            case 'news':
                get_template_part('single-news');
                break;
            case 'objects':
                get_template_part('single-objects');
                break;
            case 'category':
                get_template_part('single-category');
                break;
            default:
                // Стандартный вывод записи
                ?>
                <div class="container">
                    <article>
                        <h1><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                </div>
                <?php
                break;
        }
    endwhile;
    ?>
</main>

<?php
get_footer();
