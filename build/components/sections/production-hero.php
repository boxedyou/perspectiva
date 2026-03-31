<?php
// Берём общую группу полей для блока
$production_hero_group = get_field('production_hero_group');

// Защита от пустого ACF
$text  = $production_hero_group['text']  ?? '';
$title = $production_hero_group['title'] ?? '';

// Статичное изображение и подпись для видео
$video_img_url = get_template_directory_uri() . '/assets/images/video/video.jpg';
$video_alt     = 'Цех покраски панелей';

// Модификатор класса: на странице "О компании" убираем фон и не показываем заголовок
$is_about_page    = is_page('about');
$section_classes  = 'production-hero' . ( $is_about_page ? ' production-hero--not-back' : '' );
?>

<section class="<?= esc_attr($section_classes); ?>">
    <div class="container">
      <?php if ( ! $is_about_page && $title ) : ?>
          <h1 class="production-hero__title"><?= esc_html($title); ?></h1>
      <?php endif; ?>

        <div class="production-hero__wrapper">
            <div class="production-hero__item">
              <?php if ( $text ) : ?>
                <?= $text; // в ACF предполагается уже отформатированный HTML ?>
              <?php endif; ?>

              <?php if ( $is_about_page ) : ?>
                  <!-- На странице "О компании" показываем ссылку "Подробнее о производстве" -->
                  <a class="production-hero__link" href="<?= esc_url( home_url('/production/') ); ?>">
                      Подробнее о производстве
                  </a>
              <?php endif; ?>
            </div>

            <div class="production-hero__item">
                <div class="production-hero__gallery">
                    <!-- Превью видео (Fancybox-галерея) -->
                    <a class="production-hero__gallery-item"
                       href="<?= get_template_directory_uri(); ?>/assets/video/compressed_watermarkless.mp4"
                       data-fancybox="production-gallery"
                       data-caption="<?= esc_attr($video_alt); ?>">
                        <img
                                src="<?= esc_url($video_img_url); ?>"
                                alt="<?= esc_attr($video_alt); ?>"
                                width="360"
                                height="240"
                                loading="lazy"
                        >
                    </a>

                    <!-- Иконка воспроизведения -->
                    <svg class="production-hero__icon" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="64" height="64" rx="8" fill="#161A1F"/>
                        <path d="M24.4344 17C25.1531 17.0025 25.8592 17.1964 26.4799 17.5616L44.9661 28.4369H44.9676C45.5858 28.7986 46.0992 29.3182 46.4562 29.9426C46.8132 30.5671 47.0019 31.2754 47.0026 31.9962C47.0032 32.7171 46.8167 33.4262 46.4607 34.0513C46.105 34.6761 45.5924 35.1957 44.9752 35.5586L26.4799 46.4384C25.8592 46.8036 25.1531 46.9975 24.4344 47C23.7159 47.0024 23.009 46.813 22.3859 46.452C21.763 46.0911 21.2451 45.5704 20.8853 44.9433C20.5255 44.3161 20.3357 43.6036 20.3359 42.8791V21.1209C20.3357 20.3963 20.5255 19.6839 20.8853 19.0567C21.2452 18.4295 21.7629 17.909 22.3859 17.548C23.009 17.187 23.7159 16.9976 24.4344 17ZM22.3408 42.8806C22.3407 43.2497 22.4359 43.613 22.6192 43.9324C22.8025 44.2518 23.0666 44.5166 23.3839 44.7005C23.7013 44.8844 24.0623 44.981 24.4284 44.9797C24.7944 44.9784 25.1539 44.8789 25.47 44.6929L43.9652 33.8131L44.191 33.6597C44.4056 33.4924 44.5863 33.2838 44.7223 33.045C44.9036 32.7265 44.9996 32.365 44.9993 31.9977C44.9989 31.6306 44.9026 31.27 44.7208 30.9519C44.5389 30.6338 44.2772 30.3697 43.9622 30.1854L43.9607 30.1839L25.47 19.3071C25.1539 19.1211 24.7944 19.0231 24.4284 19.0218C24.0623 19.0205 23.7013 19.1156 23.3839 19.2995C23.0665 19.4834 22.8025 19.7496 22.6192 20.0691C22.4362 20.3883 22.3408 20.7507 22.3408 21.1194V42.8806Z" fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>