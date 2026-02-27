<?php
if (!function_exists('esc_attr')) {
  function esc_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
}


if (!function_exists('esc_url')) {
  function esc_url($url) {
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
  }
}


if (!function_exists('esc_html')) {
  function esc_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
}
