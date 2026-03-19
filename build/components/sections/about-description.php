<?php
$about_description_group = get_field('about_description_group');
if ($about_description_group) :
  $description = $about_description_group['description'];
  $gallery = $about_description_group['gallery'];
  ?>
    <section class="about-description">
        <div class="container">
            <div class="about-description__wrapper">
                <div class="about-description__item">
                  <?= $description ?>
                </div>

              <?php if ($gallery) : ?>
                  <div class="about-description__item">
                      <div class="about-description__swiper-big swiper" data-about-description-swiper>
                          <div class="about-description__swiper-wrapper swiper-wrapper">
                              <?php foreach ($gallery as $img) : ?>
                              <div class="about-description__slide swiper-slide">
                                  <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>" title="<?= $img['title'] ?>" width="720" height="480" loading="lazy">
                              </div>
                              <?php endforeach; ?>

                          </div>
                          <div class="about-description__pagination swiper-pagination" data-about-description-pagination></div>
                      </div>
                    <?php if ( is_array($gallery) && count($gallery) > 1 ) : ?>
                        <div class="about-description__swiper-thumb swiper" data-about-description-swiper-thumb>
                            <div class="about-description__swiper-wrapper swiper-wrapper">
                              <?php foreach ( $gallery as $img ) : ?>
                                <?php
                                $url   = $img['url']   ?? '';
                                $alt   = $img['alt']   ?? '';
                                $title = $img['title'] ?? '';
                                if ( ! $url ) {
                                  continue;
                                }
                                ?>
                                  <div class="about-description__slide-thumb swiper-slide">
                                      <img
                                              src="<?= esc_url($url); ?>"
                                              alt="<?= esc_attr($alt); ?>"
                                              title="<?= esc_attr($title); ?>"
                                              width="100"
                                              height="76"
                                              loading="lazy"
                                      >
                                  </div>
                              <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                  </div>
              <?php endif; ?>

            </div>
          <?php get_template_part('components/elements/products-small'); ?>
        </div>
    </section>
<?php endif; ?>


