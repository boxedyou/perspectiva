<?php
$seo = get_field('seo');
?>

<?php if ($seo) : ?>
<section class="seo">
  <div class="container">
    <div class="seo__wrapper">
        <?= $seo ?>
    </div>
  </div>
</section>
<?php endif; ?>
