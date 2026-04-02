<?php
/**
 * Single news content with TOC from ACF flexible content.
 * Рабочий вариант:
 * 1) сначала готовим контент и TOC
 * 2) потом выводим сайдбар (уже с готовыми якорями)
 * 3) затем выводим подготовленные блоки контента
 */

function news_make_anchor_slug($text)
{
  $text = wp_strip_all_tags((string) $text);
  $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $text = trim(preg_replace('/\s+/u', ' ', $text));

  // Транслитерация кириллицы -> латиница
  $map = [
    'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'E','Ж'=>'Zh','З'=>'Z','И'=>'I','Й'=>'Y',
    'К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F',
    'Х'=>'Kh','Ц'=>'Ts','Ч'=>'Ch','Ш'=>'Sh','Щ'=>'Shch','Ъ'=>'','Ы'=>'Y','Ь'=>'','Э'=>'E','Ю'=>'Yu','Я'=>'Ya',
    'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'zh','з'=>'z','и'=>'i','й'=>'y',
    'к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f',
    'х'=>'kh','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'shch','ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
  ];

  $text = strtr($text, $map);

  $slug = sanitize_title($text); // уже латиница -> нормальный slug
  return $slug !== '' ? $slug : 'section';
}

if (!function_exists('news_make_anchor_slug')) {
  function news_make_anchor_slug($text)
  {
    $text = wp_strip_all_tags((string) $text);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/u', ' ', $text));

    $slug = sanitize_title($text);
    return $slug !== '' ? $slug : 'section';
  }
}

if (!function_exists('news_add_h2_ids_and_collect_toc')) {
  function news_add_h2_ids_and_collect_toc($html, array &$used_ids, array &$toc_items)
  {
    if (!is_string($html) || $html === '') {
      return $html;
    }

    return preg_replace_callback(
      '/<h2([^>]*)>(.*?)<\/h2>/isu',
      function ($m) use (&$used_ids, &$toc_items) {
        $attrs = $m[1];
        $inner = $m[2];
        $text  = trim(wp_strip_all_tags($inner));

        if ($text === '') {
          return $m[0];
        }

        // Если id уже есть в h2 — используем его как базу
        if (preg_match('/\sid=(["\'])(.*?)\1/i', $attrs, $id_match)) {
          $base_id = sanitize_title($id_match[2]);
          if ($base_id === '') {
            $base_id = news_make_anchor_slug($text);
          }
        } else {
          $base_id = news_make_anchor_slug($text);
        }

        $id = $base_id;

        // Уникализируем
        if (isset($used_ids[$base_id])) {
          $used_ids[$base_id]++;
          $id = $base_id . '-' . $used_ids[$base_id];
        } else {
          $used_ids[$base_id] = 0;
        }

        $toc_items[] = [
          'text' => $text,
          'id'   => $id,
        ];

        // Обновляем/добавляем id в h2
        if (preg_match('/\sid=(["\'])(.*?)\1/i', $attrs)) {
          $attrs = preg_replace('/\sid=(["\'])(.*?)\1/i', ' id="' . esc_attr($id) . '"', $attrs, 1);
        } else {
          $attrs .= ' id="' . esc_attr($id) . '"';
        }

        return '<h2' . $attrs . '>' . $inner . '</h2>';
      },
      $html
    );
  }
}

$tags = get_the_terms(get_the_ID(), 'news_tags');

// 1) Первый проход по flexible content: готовим TOC и HTML блоков
$used_ids = [];
$toc_items = [];
$rendered_blocks = [];

if (have_rows('news_contents')) {
  while (have_rows('news_contents')) {
    the_row();

    switch (get_row_layout()) {
      case 'text_block':
        $text = get_sub_field('text');
        if ($text) {
          $text = news_add_h2_ids_and_collect_toc($text, $used_ids, $toc_items);
          $rendered_blocks[] = wp_kses_post($text);
        }
        break;

      case 'gallery':
        $images = get_sub_field('imgs');
        if ($images && is_array($images)) {
          ob_start();
          ?>
            <div class="gallery-news">
              <?php
              $gallery_group = 'news-gallery-' . get_row_index();
              foreach ($images as $image) :
                $img_url = $image['url'] ?? '';
                $img_alt = $image['alt'] ?? '';
                $caption = !empty($image['caption']) ? $image['caption'] : $img_alt;
                ?>
                  <a class="gallery-news__link"
                          href="<?= esc_url($img_url); ?>"
                          data-fancybox="<?= esc_attr($gallery_group); ?>"
                          data-caption="<?= esc_attr($caption); ?>">
                      <img class="gallery-news__img"
                              src="<?= esc_url($img_url); ?>"
                              alt="<?= esc_attr($img_alt); ?>"
                              loading="lazy">
                  </a>
              <?php endforeach; ?>
            </div>
          <?php
          $rendered_blocks[] = ob_get_clean();
        }
        break;
    }
  }
}
?>

<section class="news-content">
    <div class="container">
        <h1 class="news-content__title"><?= esc_html(get_the_title()); ?></h1>

        <div class="news-content__tags-wrapper">
          <?php if ($tags && !is_wp_error($tags)) : ?>
              <div class="news-content__tags-inner">
                <?php foreach ($tags as $term) : ?>
                    <p class="news-content__tag"><?= esc_html($term->name); ?></p>
                <?php endforeach; ?>
              </div>
          <?php endif; ?>

            <time class="news-content__date" datetime="<?= esc_attr(get_the_date('c')); ?>">
              <?= esc_html(get_the_date('d.m.Y')); ?>
            </time>
        </div>

        <div class="news-content__wrapper" data-end-parent>
            <div class="news-content__sidebar" data-start-parent>
              <?php if (!empty($toc_items)) : ?>
                  <div class="news-content__subject" data-content-parent>
                      <p class="news-content__sidebar-title" data-content-open>
                          Содержание
                          <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M12.8313 0.208617C13.0985 -0.0695388 13.5324 -0.0695388 13.7996 0.208617C14.0668 0.486772 14.0668 0.9385 13.7996 1.21666L7.48414 7.79138C7.21696 8.06954 6.78304 8.06954 6.51586 7.79138L0.20039 1.21666C-0.0667968 0.9385 -0.0667968 0.486772 0.20039 0.208617C0.467577 -0.0695389 0.901492 -0.0695389 1.16868 0.208617L7 6.27933L12.8313 0.208617Z" fill="#161A1F"/>
                          </svg>
                      </p>

                      <nav class="news-content__subject-menus active" data-content>
                          <ul class="news-content__menus-list">
                            <?php foreach ($toc_items as $item) : ?>
                                <li class="news-content__menu-item">
                                    <a class="news-content__menu-anchor" href="#<?= esc_attr($item['id']); ?>">
                                      <?= esc_html($item['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                          </ul>
                      </nav>
                  </div>
              <?php endif; ?>

                <div class="news-content__sidebar-banner" data-move>
                    <h4 class="news-content__banner-title">Хотите получить предложение по фасадам?</h4>
                    <p class="news-content__banner-text">Свяжитесь с нами, наши менеджеры подскажут подходящие варианты!</p>
                    <button class="news-content__banner-button" type="button" data-callback-popup-open>Получить предложение</button>
                </div>
            </div>

            <div class="news-content__item">
              <?php if (!empty($rendered_blocks)) : ?>
                <?php foreach ($rendered_blocks as $block_html) : ?>
                  <?= $block_html; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
        </div>
    </div>
</section>