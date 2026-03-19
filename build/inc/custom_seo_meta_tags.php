<?php

function custom_seo_meta_tags() {
  if (is_tax() || is_category() || is_tag()) {
    $term = get_queried_object();
    if (!$term || !isset($term->term_id)) return;
    $seo_groups = get_field('ceo_groups', 'term_' . $term->term_id);
  } else {
    $seo_groups = get_field('ceo_groups'); // работает для постов и страниц
  }

  if (!$seo_groups || !is_array($seo_groups)) {
    // если вообще нет группы, выведем стандартный <title> WordPress
    echo '<title>' . esc_html(wp_get_document_title()) . '</title>' . "\n";
    return;
  }

  $seo_title            = $seo_groups['seo_title'] ?? '';
  $seo_keywords         = $seo_groups['seo_keywords'] ?? '';
  $seo_description      = $seo_groups['seo_description'] ?? '';
  $canonical            = $seo_groups['canonical'] ?? '';
  $twitter_title        = $seo_groups['opengraph_twittertitle'] ?? '';
  $twitter_description  = $seo_groups['opengraph_twitter_description'] ?? '';
  $og_title             = $seo_groups['opengraph_ogtitle'] ?? '';
  $og_description       = $seo_groups['opengraph_ogdescription'] ?? '';

  // если SEO-заголовок пуст — стандартный
  if ($seo_title) {
    echo '<title>' . esc_html($seo_title) . '</title>' . "\n";
  } else {
    echo '<title>' . esc_html(wp_get_document_title()) . '</title>' . "\n";
  }

  if ($seo_keywords) {
    echo '<meta name="keywords" content="' . esc_attr($seo_keywords) . '">' . "\n";
  }

  if ($seo_description) {
    echo '<meta name="description" content="' . esc_attr($seo_description) . '">' . "\n";
  }

  if ($canonical) {
    echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
  }

  if ($twitter_title) {
    echo '<meta name="twitter:title" content="' . esc_attr($twitter_title) . '">' . "\n";
  }

  if ($twitter_description) {
    echo '<meta name="twitter:description" content="' . esc_attr($twitter_description) . '">' . "\n";
  }

  if ($og_title) {
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
  }

  if ($og_description) {
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
  }
}

add_action('wp_head', 'custom_seo_meta_tags', 5);
