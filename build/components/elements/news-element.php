<?php
/**
 * Шаблон элемента новости
 * Используется внутри цикла WordPress (the_post вызван)
 */
if (!empty($news_group['tags']) && is_array($news_group['tags'])) {
  foreach ($news_group['tags'] as $item) {
    $tag = is_array($item) ? ($item['tag'] ?? '') : $item;
    if (!empty($tag)) {
      $news_tags[] = $tag;
    }
  }
}

if (empty($news_tags)) {
  $news_tags = ['Без названия'];
}

$news_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
if (empty($news_image)) {
  $news_image = get_template_directory_uri() . '/assets/images/news/1.jpg';
}

$news_alt = get_the_title();
$news_title = $news_alt;
$news_date = get_the_date('d.m.Y');
$news_item_title = get_the_title();
$excerpt = get_the_excerpt();
$news_text = mb_strlen($excerpt) > 200 ? mb_substr($excerpt, 0, 200) . '...' : $excerpt;
$news_link = get_permalink();
?>

<div class="news-element">
    <div class="news-element__img-inner">
        <img src="<?= esc_url($news_image) ?>"
             alt="<?= esc_attr($news_alt ?: 'Новость') ?>"
             title="<?= esc_attr($news_title ?: '') ?>"
             width="480"
             height="320"
             loading="lazy">
        <div class="news-element__tags-inner">
          <?php
          $tags = get_the_terms(get_the_ID(), 'news_tags');
          if ($tags && !is_wp_error($tags)) : ?>
              <div class="news-content__tags-inner">
                <?php foreach ($tags as $term) : ?>
                    <p class="news-element__tag"><?= esc_html($term->name) ?></p>
                <?php endforeach; ?>
              </div>
          <?php endif; ?>
        </div>
    </div>
  <?php if ($news_date) : ?>
      <time class="news-element__date" datetime="<?= esc_attr(get_the_date('c')) ?>"><?= esc_html($news_date) ?></time>
  <?php endif; ?>
  <?php if ($news_item_title) : ?>
      <h3 class="news-element__title"><?= esc_html($news_item_title) ?></h3>
  <?php endif; ?>
  <?php if ($news_text) : ?>
      <p class="news-element__text"><?= esc_html($news_text) ?></p>
  <?php endif; ?>
  <?php if ($news_link) : ?>
      <a class="news-element__link" href="<?= esc_url($news_link) ?>">Читать далее
          <svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.6031 0.214201C14.8841 -0.0714003 15.3401 -0.0714003 15.6211 0.214201L21.7892 6.48272C22.0703 6.76833 22.0703 7.23167 21.7892 7.51728L15.6211 13.7858C15.3401 14.0714 14.8841 14.0714 14.6031 13.7858C14.3221 13.5002 14.3221 13.0368 14.6031 12.7512L19.5424 7.73153H0.719816C0.322383 7.73153 0 7.4039 0 7C0 6.5961 0.322383 6.26847 0.719816 6.26847H19.5424L14.6031 1.24875C14.3221 0.963151 14.3221 0.499802 14.6031 0.214201Z" fill="#C42539"/>
          </svg>
      </a>
  <?php endif; ?>
</div>