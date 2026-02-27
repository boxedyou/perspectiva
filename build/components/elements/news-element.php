<?php
// Шаблон новости
$images_base_url = './assets/images/news/';
?>

<div class="news-element">
    <div class="news-element__img-inner">
        <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/news/'  . $news_image) ?>"
             alt="<?= esc_attr($news_alt) ?>"
             title="<?= esc_attr($news_title) ?>"
             width="480"
             height="320"
             loading="lazy">
        <div class="news-element__tags-inner">
          <?php foreach ($news_tags as $tag) : ?>
              <p class="news-element__tag"><?= esc_html($tag) ?></p>
          <?php endforeach; ?>
        </div>
    </div>
    <time class="news-element__date"><?= esc_html($news_date) ?></time>
    <h3 class="news-element__title"><?= esc_html($news_item_title) ?></h3>
    <p class="news-element__text"><?= esc_html($news_text) ?></p>
    <a class="news-element__link" href="<?= esc_url(get_permalink(18)); ?>">Читать далее
        <svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.6031 0.214201C14.8841 -0.0714003 15.3401 -0.0714003 15.6211 0.214201L21.7892 6.48272C22.0703 6.76833 22.0703 7.23167 21.7892 7.51728L15.6211 13.7858C15.3401 14.0714 14.8841 14.0714 14.6031 13.7858C14.3221 13.5002 14.3221 13.0368 14.6031 12.7512L19.5424 7.73153H0.719816C0.322383 7.73153 0 7.4039 0 7C0 6.5961 0.322383 6.26847 0.719816 6.26847H19.5424L14.6031 1.24875C14.3221 0.963151 14.3221 0.499802 14.6031 0.214201Z" fill="#C42539"/>
        </svg>
    </a>
</div>