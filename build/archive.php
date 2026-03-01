<?php
/**
 * Template for displaying archive pages
 *
 * @package Perspectiva
 */

get_header();
?>

<main class="main-page">
    <?php
    if (have_posts()) :
        $post_type = get_post_type();
        
        switch ($post_type) {
            case 'news':
                get_template_part('page-novosti-i-stati.php');
                break;
            default:
                // Стандартный вывод архива
                ?>
                <div class="container">
                    <h1><?php the_archive_title(); ?></h1>
                    <div class="archive-content">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('components/elements/news-element');
                        endwhile;
                        ?>
                    </div>
                    <?php
                    the_posts_pagination();
                    ?>
                </div>
                <?php
                break;
        }
    else :
        get_template_part('404');
    endif;
    ?>
</main>

<?php
get_footer();
