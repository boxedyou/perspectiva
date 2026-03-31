<?php

if (!defined('ABSPATH')) {
  exit;
}

function perspectiva_get_projects_map_data() {
  $result = [];

  $q = new WP_Query([
    'post_type'      => 'object', // или нужный CPT
    'post_status'    => 'publish',
    'posts_per_page' => -1,
  ]);
  if (!$q->have_posts()) {
    return $result;
  }

  while ($q->have_posts()) {
    $q->the_post();
    $post_id = get_the_ID();

    $objects_group = get_field('objects_group', $post_id);
    $coords_raw    = isset($objects_group['coords']) ? trim((string)$objects_group['coords']) : '';

    $coords_field = $objects_group['coords'] ?? null;
    $coords = null;

    if (is_array($coords_field) && isset($coords_field['lat'], $coords_field['lng'])) {
      $coords = [(float)$coords_field['lat'], (float)$coords_field['lng']];
    } elseif (is_string($coords_field) && strpos($coords_field, ',') !== false) {
      [$lat, $lng] = array_map('trim', explode(',', $coords_field, 2));
      if (is_numeric($lat) && is_numeric($lng)) {
        $coords = [(float)$lat, (float)$lng];
      }
    }



    $thumb_id = get_post_thumbnail_id($post_id);

    $result[] = [
      'coords'       => $coords,
      'city'         => isset($objects_group['object_place']) ? (string)$objects_group['object_place'] : '',
      'title'        => get_the_title($post_id),
      'company_name' => get_the_title($post_id), // или отдельное поле ACF
      'description'  => isset($objects_group['object_text']) ? wp_strip_all_tags((string)$objects_group['object_text']) : '',
      'link'         => get_permalink($post_id),
      'img'          => $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium_large') : '',
    ];
  }

  wp_reset_postdata();

  return $result;
}