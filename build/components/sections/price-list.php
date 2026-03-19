<?php
$table_content = get_field('table_content');
?>

<section class="price-list">
  <div class="container">
    <div class="price-list__title-inner">
      <h1 class="price-list__title">Прайс-лист</h1>
<!--      <a class="price-list__link" href="#">Скачать прайс-лист (<span class="price-list__link-size">2 мб</span>)-->
<!--        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--          <path d="M19.2725 20.5563C19.6742 20.5563 20 20.8796 20 21.2782C20 21.6767 19.6742 22 19.2725 22H4.72746C4.32581 22 4 21.6767 4 21.2782C4 20.8796 4.32581 20.5563 4.72746 20.5563H19.2725ZM11.2725 2.72184C11.2725 2.32329 11.5983 2 12 2C12.4017 2 12.7275 2.32329 12.7275 2.72184V15.4119L17.7192 10.4587C18.0032 10.1769 18.464 10.1769 18.748 10.4587C19.032 10.7405 19.032 11.1977 18.748 11.4795L12.5144 17.665C12.2304 17.9468 11.7696 17.9468 11.4856 17.665L5.252 11.4795C4.96799 11.1977 4.96799 10.7405 5.252 10.4587C5.53601 10.1769 5.99678 10.1769 6.28079 10.4587L11.2725 15.4119V2.72184Z" fill="white"/>-->
<!--        </svg>-->
<!---->
<!--      </a>-->
    </div>
    <time class="price-list__date" datetime="<?php echo date( 'Y-m-d' ); ?>">
      Прайс-лист на фиброцементные панели на <?php echo date( 'd.m.Y' ); ?> года.
    </time>
    <?= $table_content  ?>
  </div>
</section>