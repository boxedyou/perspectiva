<?php
/**
 * Главный шаблон темы (index.php)
 *
 * Резервный шаблон: используется, если не найден более специфичный
 * (front-page.php, home.php, single.php, page.php и т.д.).
 *
 * @package Perspectiva
 */

get_header();
?>

    <main class="main-page">
        <div class="container">
          <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                      <h1 class="entry-title">
                          <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                          </a>
                      </h1>

                      <div class="entry-content">
                        <?php
                        if ( is_singular() ) {
                          the_content();
                        } else {
                          the_excerpt();
                        }
                        ?>
                      </div>
                  </article>
            <?php endwhile; ?>

            <?php
            the_posts_pagination( [
              'prev_text' => '&laquo; Предыдущая',
              'next_text' => 'Следующая &raquo;',
            ] );
            ?>
          <?php else : ?>
              <article class="no-posts">
                  <h1>Ничего не найдено</h1>
                  <p>Записей пока нет.</p>
              </article>
          <?php endif; ?>
        </div>
    </main>

<?php
get_footer();