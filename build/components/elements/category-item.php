<?php
/**
 * Элемент категории для одного товара (post type: product)
 * Ожидается, что файл подключается внутри цикла have_posts()
 */

// 1. ID текущего товара (product)
$product_id = get_the_ID();

// 2. Ссылка и заголовок товара
$product_link  = get_permalink( $product_id );
$product_title = get_the_title( $product_id );

// 3. Таксономия categories для data-filter-target
//    Берём первый термин, если он есть
$product_terms = get_the_terms( $product_id, 'categories' );
$filter_target = '';

if ( ! is_wp_error( $product_terms ) && ! empty( $product_terms ) ) {
  // Можно использовать ->name или ->slug, вёрстка у вас ждёт текст,
  // поэтому оставляю name. Если нужен slug — замените на ->slug.
  $filter_target = $product_terms[0]->name;
}

// 4. Группа ACF card_group у продукта
//    Здесь предположительно лежат: price, card_imgs (галерея) и т.п.
$card_group = get_field( 'card_group', $product_id );

// Защита от ситуации, когда card_group не задана или вернулась не как массив
if ( ! is_array( $card_group ) ) {
  $card_group = [];
}

// 4.1. Цена из группы
$price = isset( $card_group['price'] ) ? $card_group['price'] : '';

// 4.2. Галерея изображений из группы
$card_imgs = isset( $card_group['card_imgs'] ) ? $card_group['card_imgs'] : null;

// 5. Определяем картинку карточки:
//    1) миниатюра записи (featured image),
//    2) первая картинка из галереи card_imgs,
//    3) fallback на статичную картинку из темы.
$thumb_url   = '';  // URL изображения
$thumb_alt   = '';  // alt
$thumb_title = '';  // title

// 5.1. Пытаемся взять миниатюру записи
$thumb_url = get_the_post_thumbnail_url( $product_id, 'medium_large' ); // Можно указать свой размер

if ( $thumb_url ) {
  // alt/title для миниатюры берём из заголовка записи
  $thumb_alt   = $product_title;
  $thumb_title = $product_title;
}

// 5.2. Если миниатюры нет — пробуем взять первую картинку из галереи card_imgs
if ( ! $thumb_url && $card_imgs && is_array( $card_imgs ) && ! empty( $card_imgs ) ) {
  // Для ACF Gallery элемент массива — это массив с ключами url, alt, title и т.п.
  $first_img = $card_imgs[0];

  if ( is_array( $first_img ) && ! empty( $first_img['url'] ) ) {
    $thumb_url   = $first_img['url'];
    $thumb_alt   = ! empty( $first_img['alt'] )   ? $first_img['alt']   : $product_title;
    $thumb_title = ! empty( $first_img['title'] ) ? $first_img['title'] : $product_title;
  }
}

// 5.3. Если ни миниатюры, ни галереи — ставим заглушку
if ( ! $thumb_url ) {
  $thumb_url   = get_template_directory_uri() . '/assets/images/category-item/1.png';
  $thumb_alt   = 'Фото';
  $thumb_title = 'Фото';
}

// 6. Таксономия size: размеры, которые принадлежат этому продукту
$sizes = get_the_terms( $product_id, 'size' );
?>

<a class="category-item"
   href="<?php echo esc_url( $product_link ); ?>"
  <?php if ( $filter_target ) : ?>
      data-filter-target="<?php echo esc_attr( $filter_target ); ?>"
  <?php endif; ?>
>
  <?php // Картинка товара (миниатюра / первая из галереи / заглушка) ?>
    <img class="category-item__img"
         src="<?php echo esc_url( $thumb_url ); ?>"
         alt="<?php echo esc_attr( $thumb_alt ); ?>"
         title="<?php echo esc_attr( $thumb_title ); ?>"
         width="346"
         height="240"
         loading="lazy">

  <?php // Заголовок текущей записи (товара) ?>
    <h3 class="category-item__title">
      <?php the_title(); ?>
    </h3>

  <?php // Блок "Цвета" — пока статичный текст, как у вас ?>
    <p class="category-item__text">Цвета:</p>
    <div class="category-item__color-inner">
        <button class="category-item__color-choose"><span></span></button>
        <span class="category-item__color-text">— Цвет выбирается из палитры RAL</span>
    </div>

  <?php // Блок "Размеры" из таксономии size, если термины найдены ?>
  <?php if ( ! is_wp_error( $sizes ) && ! empty( $sizes ) ) : ?>
      <p class="category-item__text">Размеры:</p>
      <div class="category-item__size-wrapper">
        <?php foreach ( $sizes as $size_term ) : ?>
            <p class="category-item__size">
              <?php echo esc_html( $size_term->name ); ?>
            </p>
        <?php endforeach; ?>
      </div>
  <?php endif; ?>

  <?php // Цена: внутри строки меняем "м2" на "м<sup>2</sup>" ?>
  <?php if ( $price ) : ?>
      <p class="category-item__price">
        <?php
        // str_replace не экранирует HTML, поэтому:
        // 1) экранируем текст,
        // 2) потом подменяем уже безопасную строку.
        $safe_price = esc_html( $price );
        echo str_replace( 'м2', 'м<sup>2</sup>', $safe_price );
        ?>
      </p>
  <?php endif; ?>

    <button class="category-item__button" type="button">
        Смотреть подробнее
    </button>
</a>