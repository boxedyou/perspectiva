<?php
$product_id = get_the_ID();

// Группа полей карточки
$card_group = get_field('card_group', $product_id);

// Базовые безопасные значения
$price = '';
$card_imgs = [];
$text_small = '';

// Проверяем, что группа существует и это массив
if (!empty($card_group) && is_array($card_group)) {
  $price = isset($card_group['price']) ? (string)$card_group['price'] : '';
  $card_imgs = !empty($card_group['card_imgs']) && is_array($card_group['card_imgs']) ? $card_group['card_imgs'] : [];
  $text_small = isset($card_group['text_small']) ? (string)$card_group['text_small'] : '';
}

// Форматирование цены только если она есть
$price_with_sub = '';
if ($price !== '') {
  $price_with_sub = preg_replace(
    '/(м)(\d+)/u',      // "м" + одна или несколько цифр
    '$1<sup>$2</sup>',  // заворачиваем цифры после "м" в <sup>
    $price
  );
}

// Таксономия размеров
$size_terms = get_the_terms($product_id, 'size');
?>

    <section class="single-category-hero">
        <div class="container">
            <h1 class="single-category-hero__title"><?php the_title(); ?></h1>
            <div class="single-category-hero__wrapper">
                <div class="single-category-hero__item">
                    <div class="single-category-hero__swiper swiper" data-single-category-hero-swiper>
                        <div class="single-category-hero__swiper-wrapper swiper-wrapper">
                          <?php if (!empty($card_imgs)) : ?>
                            <?php foreach ($card_imgs as $img_index => $card_img) :
                              if (empty($card_img) || !is_array($card_img)) {
                                continue;
                              }

                              $url = !empty($card_img['url']) ? $card_img['url'] : '';
                              $alt = !empty($card_img['alt']) ? $card_img['alt'] : '';
                              $title = !empty($card_img['title']) ? $card_img['title'] : '';

                              if (!$url) {
                                continue;
                              }
                              ?>
                                  <div class="single-category-hero__slide swiper-slide" <?php echo $img_index === 0 ? 'data-src-copy' : ''; ?>>
                                      <img src="<?php echo esc_url($url); ?>"
                                           alt="<?php echo esc_attr($alt); ?>"
                                           title="<?php echo esc_attr($title); ?>"
                                           width="720"
                                           height="540"
                                           loading="lazy">
                                  </div>
                            <?php endforeach; ?>
                          <?php else : ?>
                              <div class="single-category-hero__slide swiper-slide" data-src-copy>
                                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/single-category-hero/1.jpg'); ?>"
                                       alt=""
                                       title=""
                                       width="720"
                                       height="540"
                                       loading="lazy">
                              </div>
                          <?php endif; ?>
                        </div>
                    </div>
                  <?php if (is_array($card_imgs) && count($card_imgs) > 1) : ?>
                      <div class="single-category-hero__swiper-thumb swiper" data-single-category-hero-swiper-thumb>
                          <div class="single-category-hero__swiper-wrapper-thumb swiper-wrapper">
                            <?php if (!empty($card_imgs)) : ?>
                              <?php foreach ($card_imgs as $card_img) :
                                if (empty($card_img) || !is_array($card_img)) {
                                  continue;
                                }

                                $url = !empty($card_img['url']) ? $card_img['url'] : '';
                                $alt = !empty($card_img['alt']) ? $card_img['alt'] : '';
                                $title = !empty($card_img['title']) ? $card_img['title'] : '';

                                if (!$url) {
                                  continue;
                                }
                                ?>
                                    <div class="single-category-hero__slide-thumb swiper-slide">
                                        <img src="<?php echo esc_url($url); ?>"
                                             alt="<?php echo esc_attr($alt); ?>"
                                             title="<?php echo esc_attr($title); ?>"
                                             width="100"
                                             height="76"
                                             loading="lazy">
                                    </div>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </div>
                      </div>
                  <?php endif; ?>
                </div>

                <div class="single-category-hero__item">
                    <h3 class="single-category-hero__item-title" data-item-name><?php the_title(); ?> <span data-ral-name></span></h3>
                    <p class="single-category-hero__text">Выберите цвет:
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.18723 3.86276C8.10487 2.49292 10.4447 1.84446 12.7939 2.03159C15.1432 2.21874 17.3508 3.22982 19.0274 4.88608C20.7039 6.54228 21.7421 8.73709 21.958 11.0838C22.1738 13.4305 21.5537 15.7783 20.2075 17.7125C18.8611 19.6468 16.8742 21.0438 14.5985 21.6563C12.3354 22.2653 9.9313 22.0588 7.80474 21.0759C7.58898 20.9951 7.35534 20.9752 7.12894 21.0172L3.96177 21.9443C3.95701 21.9456 3.95189 21.9466 3.9471 21.9479C3.69204 22.0156 3.42345 22.0175 3.16769 21.9525C2.91194 21.8875 2.67727 21.7578 2.48547 21.5766C2.29366 21.3953 2.15127 21.168 2.07192 20.9163C1.99262 20.6648 1.97848 20.3971 2.03158 20.1388L2.049 20.0737L3.03656 17.0202C3.08497 16.7814 3.06488 16.5339 2.97604 16.3068C1.96674 14.1922 1.73078 11.7902 2.31217 9.51947C2.8968 7.23638 4.26954 5.23271 6.18723 3.86276ZM12.6967 3.2484C10.6344 3.08418 8.58041 3.65336 6.89695 4.85582C5.21335 6.05855 4.00831 7.81767 3.49504 9.82207C3.01384 11.7013 3.16899 13.6833 3.93059 15.4595L4.09106 15.8116L4.10848 15.852C4.29134 16.3134 4.33254 16.8188 4.22585 17.3035C4.22164 17.3227 4.21631 17.3417 4.21027 17.3604L3.22545 20.3992C3.21747 20.4494 3.22021 20.5009 3.23554 20.5496C3.25237 20.603 3.28288 20.6514 3.32357 20.6899C3.36423 20.7282 3.41426 20.7559 3.46845 20.7696C3.52114 20.783 3.57622 20.7819 3.62892 20.7687L6.82359 19.8353L6.87586 19.8224C7.27612 19.743 7.68898 19.7639 8.07799 19.8811L8.24304 19.937L8.28522 19.9545C10.1599 20.8299 12.2833 21.0148 14.2812 20.4771C16.2792 19.9394 18.0232 18.7137 19.2053 17.0156C20.3873 15.3174 20.9316 13.2561 20.7421 11.1957C20.5526 9.13552 19.6418 7.20845 18.17 5.75444C16.6981 4.30035 14.7592 3.4127 12.6967 3.2484ZM12.009 16.084C12.346 16.084 12.6197 16.3576 12.6197 16.6947C12.6195 17.0316 12.3459 17.3044 12.009 17.3044H11.9998C11.6628 17.3044 11.3893 17.0316 11.3891 16.6947C11.3891 16.3576 11.6627 16.084 11.9998 16.084H12.009ZM10.1879 7.16289C10.8857 6.7528 11.7064 6.60243 12.5041 6.73926C13.3017 6.87613 14.025 7.29115 14.5462 7.91021C15.0673 8.52924 15.3524 9.31277 15.3513 10.1219L15.3412 10.3539C15.2353 11.4912 14.3662 12.2794 13.6714 12.7426C13.2824 13.0019 12.8974 13.1936 12.6123 13.3203C12.469 13.3839 12.3489 13.4324 12.263 13.4651C12.22 13.4815 12.1849 13.494 12.1603 13.5027C12.1481 13.5071 12.1381 13.5104 12.1309 13.5128C12.1274 13.5141 12.124 13.5148 12.1218 13.5156C12.1208 13.5159 12.1198 13.5162 12.119 13.5165L12.1181 13.5174C12.1179 13.5175 12.1175 13.5175 11.9246 12.9388L12.1172 13.5174C11.7975 13.6239 11.4517 13.4511 11.3451 13.1314C11.2387 12.8117 11.4116 12.4659 11.7311 12.3593C11.7317 12.3591 11.7327 12.3588 11.7339 12.3584C11.7373 12.3572 11.7433 12.3557 11.7513 12.3529C11.7679 12.347 11.7943 12.3374 11.8283 12.3244C11.8964 12.2985 11.9957 12.2579 12.1163 12.2043C12.3593 12.0963 12.6796 11.9367 12.9947 11.7266C13.6618 11.2818 14.1307 10.7367 14.1308 10.1219V10.121C14.1316 9.5999 13.9483 9.0947 13.6127 8.69605C13.2772 8.29752 12.8113 8.03045 12.2978 7.94231C11.7842 7.85421 11.2552 7.95061 10.8059 8.21464C10.3568 8.47868 10.016 8.89408 9.84313 9.3856C9.73119 9.70334 9.38248 9.87052 9.06464 9.7588C8.74671 9.64696 8.57968 9.29824 8.69144 8.9803C8.96001 8.21682 9.49016 7.57299 10.1879 7.16289Z"
                                  fill="#C42539"/>
                        </svg>
                    </p>
                    <div class="single-category-hero__color-inner">
                        <button class="single-category-hero__color-choose" data-color-popup-open><span data-color-choose></span></button>
                        <span class="single-category-hero__color-text">— Нажмите на блок слева, чтобы выбрать из палитры</span>
                    </div>
                  <?php if (!empty($size_terms) && !is_wp_error($size_terms)) : ?>
                      <p class="single-category-hero__text">Выберите размер:</p>

                      <ul class="single-category-hero__size-inner" data-size-parent>

                        <?php foreach ($size_terms as $index => $term) : ?>
                            <li
                                    class="single-category-hero__size <?php echo $index === 0 ? 'active' : ''; ?>"
                                    data-size
                                    data-size-name="<?php echo esc_attr($term->name); ?>"
                            >
                              <?php echo esc_html($term->name); ?>
                            </li>
                        <?php endforeach; ?>

                      </ul>
                  <?php endif; ?>
                    <div class="single-category-hero__price-wrapper">
                        <div class="single-category-hero__price-inner">
                            <p class="single-category-hero__price">
                              <?php echo $price_with_sub !== '' ? $price_with_sub : 'Цена уточняется'; ?>
                            </p>
                            <p class="single-category-hero__price-text">Актуальные цены на подходящие вам варианты узнавайте напрямую у менеджеров</p>
                        </div>
                        <button class="single-category-hero__button" data-popup-request-open data-info-fill>Запросить цены</button>
                    </div>

                    <p class="single-category-hero__text">Краткое описание:</p>
                    <p class="single-category-hero__text-second">
                      <?php echo $text_small !== '' ? esc_html($text_small) : 'Описание уточняйте у менеджера.'; ?>
                    </p>

                    <a class="single-category-hero__link" href="#description">Читать подробнее
                        <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 0.5L4.5 4.5L8.5 0.5" stroke="#C42539" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>

                    <div class="single-category-hero__info-inner">
                        <div class="single-category-hero__info">
                            <img class="single-category-hero__info-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/info/1.svg'); ?>" alt="Фото" title="Фото" width="24" height="24" loading="lazy">
                            <p class="single-category-hero__info-text">Гарантия <b>10 лет</b> на защитно-декоративные покрытия изделий</p>
                        </div>
                        <div class="single-category-hero__info">
                            <img class="single-category-hero__info-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/info/2.svg'); ?>" alt="Фото" title="Фото" width="24" height="24" loading="lazy">
                            <p class="single-category-hero__info-text">Осуществляем <b>доставку</b> по всей России</p>
                        </div>
                        <div class="single-category-hero__info">
                            <img class="single-category-hero__info-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/info/3.svg'); ?>" alt="Фото" title="Фото" width="24" height="24" loading="lazy">
                            <p class="single-category-hero__info-text"><b>В основе</b> панелей использован лист фиброцемента</p>
                        </div>
                        <div class="single-category-hero__info">
                            <img class="single-category-hero__info-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/info/4.svg'); ?>" alt="Фото" title="Фото" width="24" height="24" loading="lazy">
                            <p class="single-category-hero__info-text">Плиты «ФАСАД-КОЛОР» напрямую от <b>производителя</b></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php
get_template_part('components/popups/popup-ral');
get_template_part('components/popups/popup-request');
?>