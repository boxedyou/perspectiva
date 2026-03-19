<?php
$content = get_the_content();
$content = apply_filters('the_content', $content);

// Извлекаем все h2
preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $content, $h2_matches);
$headings = $h2_matches[1] ?? [];

// Добавляем id к h2 и формируем массив для меню
$used_ids = [];
$toc_items = [];
// 6 последних новостей, кроме текущей
$news_more_args = [
  'post_type'      => 'news',
  'posts_per_page' => 6,
  'orderby'        => 'date',
  'order'          => 'DESC',
  'post__not_in'   => [ get_the_ID() ],
  'post_status'    => 'publish',
];
$news_more_query = new WP_Query($news_more_args);
$content = preg_replace_callback(
  '/<h2([^>]*)>(.*?)<\/h2>/is',
  function ($m) use (&$used_ids, &$toc_items) {
    $text = wp_strip_all_tags($m[2]);
    $slug = sanitize_title($text);
    if (isset($used_ids[$slug])) {
      $used_ids[$slug]++;
      $slug .= '-' . $used_ids[$slug];
    } else {
      $used_ids[$slug] = 0;
    }
    $toc_items[] = ['text' => $text, 'id' => $slug];
    return '<h2 id="' . esc_attr($slug) . '"' . $m[1] . '>' . $m[2] . '</h2>';
  },
  $content
);
?>

<section class="news-content">
    <div class="container">
        <h1 class="news-content__title">Вентфасад для частного дома</h1>
        <div class="news-content__tags-wrapper">
          <?php
          $tags = get_the_terms(get_the_ID(), 'news_tags');
          if ($tags && !is_wp_error($tags)) : ?>
              <div class="news-content__tags-inner">
                <?php foreach ($tags as $term) : ?>
                    <p class="news-content__tag"><?= esc_html($term->name) ?></p>
                <?php endforeach; ?>
              </div>
          <?php endif; ?>
            <time class="news-content__date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d.m.Y'); ?></time>
        </div>
        <div class="news-content__wrapper" data-end-parent>
            <div class="news-content__sidebar" data-start-parent>
              <?php if ( ! empty( $toc_items ) && is_array( $toc_items ) ) : ?>
                  <div class="news-content__subject">
                      <p class="news-content__sidebar-title">Содержание
                          <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.8313 0.208617C13.0985 -0.0695388 13.5324 -0.0695388 13.7996 0.208617C14.0668 0.486772 14.0668 0.9385 13.7996 1.21666L7.48414 7.79138C7.21696 8.06954 6.78304 8.06954 6.51586 7.79138L0.20039 1.21666C-0.0667968 0.9385 -0.0667968 0.486772 0.20039 0.208617C0.467577 -0.0695389 0.901492 -0.0695389 1.16868 0.208617L7 6.27933L12.8313 0.208617Z" fill="#161A1F"/>
                          </svg>
                      </p>
                      <nav class="news-content__subject-menus">
                          <ul class="news-content__menus-list">
                            <?php foreach ( $toc_items as $index => $item ) : ?>
                                <li class="news-content__menu-item<?php echo 0 === (int) $index ? ' active' : ''; ?>">
                                    <a class="news-content__menu-anchor" href="#<?php echo esc_attr( $item['id'] ); ?>">
                                      <?php echo esc_html( $item['text'] ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                          </ul>
                      </nav>
                  </div>
              <?php endif; ?>

                <div class="news-content__more" data-move>
                    <p class="news-content__sidebar-title">Читайте также:</p>
                    <div class="news-content__more-wrapper">
                      <?php if ($news_more_query->have_posts()) : ?>
                        <?php while ($news_more_query->have_posts()) : $news_more_query->the_post(); ?>
                              <aside class="news-content__more-item">
                                  <h4 class="news-content__more-item-title"><?php the_title(); ?></h4>
                                  <p class="news-content__more-item-text"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                  <a class="news-content__more-item-link" href="<?php the_permalink(); ?>">Читать далее
                                      <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M14.1465 0.146446C14.3417 -0.0488155 14.6583 -0.0488155 14.8535 0.146446L20.8535 6.14645C21.0488 6.34171 21.0488 6.65822 20.8535 6.85348L14.8535 12.8535C14.6583 13.0487 14.3417 13.0487 14.1465 12.8535C13.9512 12.6582 13.9512 12.3417 14.1465 12.1464L19.293 6.99996H0.5C0.223858 6.99996 0 6.7761 0 6.49996C0 6.22382 0.223858 5.99996 0.5 5.99996H19.293L14.1465 0.853478C13.9512 0.658216 13.9512 0.341709 14.1465 0.146446Z" fill="#C42539"/>
                                      </svg>
                                  </a>
                              </aside>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                      <?php endif; ?>
                    </div>
                </div>
                <div class="news-content__sidebar-banner" data-move>
                    <h4 class="news-content__banner-title">Хотите получить предложение по фасадам?</h4>
                    <p class="news-content__banner-text">Свяжитесь с нами, наши менеджеры подскажут подходящие варианты!</p>
                    <button class="news-content__banner-button">Получить предложение</button>
                </div>
            </div>
            <div class="news-content__item">
              <?php echo $content; ?>
            </div>
        </div>
    </div>
</section>





