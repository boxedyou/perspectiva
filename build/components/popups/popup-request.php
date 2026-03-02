<div class="popup popup-request" data-popup data-popup-request>
  <div class="popup__body" data-popup-inner>
    <h2 class="popup__title">Запросить цену на продукцию</h2>
    <h3 class="popup__subtitle">Продукция:</h3>
      <div class="popup__info-inner">
          <div class="popup__info-item">
              <img class="popup__info-img" src="<?= get_template_directory_uri() ?>/assets/images/single-category-hero/1.jpg" data-src-insert alt="Изображение товара" title="Изображение товара" width="88" height="88" loading="lazy">
          </div>
          <div class="popup__info-item">
              <p class="popup__info-title" data-info-title>Фиброцементная панель RAL 3020</p>
              <p class="popup__info-size">Размер: <span class="popup__info" data-info-size>1200*3000*8 мм</span></p>
              <p class="popup__info-ral">Цвет: <span class="popup__info" data-info-ral>RAL 3020</span></p>
          </div>
      </div>
    <h3 class="popup__subtitle">Контактные данные:</h3>
    <?php get_template_part('components/elements/form'); ?>
    <svg class="popup__close" data-popup-close width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M16.9983 6.17176C17.2273 5.94275 17.5992 5.94275 17.8282 6.17176C18.0573 6.40078 18.0573 6.77271 17.8282 7.00173L12.83 12L17.8282 16.9983C18.0573 17.2273 18.0573 17.5992 17.8282 17.8282C17.5992 18.0573 17.2273 18.0573 16.9983 17.8282L12 12.83L7.00173 17.8282C6.77271 18.0573 6.40078 18.0573 6.17176 17.8282C5.94275 17.5992 5.94275 17.2273 6.17176 16.9983L11.17 12L6.17176 7.00173C5.94275 6.77271 5.94275 6.40078 6.17176 6.17176C6.40078 5.94275 6.77271 5.94275 7.00173 6.17176L12 11.17L16.9983 6.17176Z" fill="#161A1F"/>
    </svg>
  </div>

</div>
