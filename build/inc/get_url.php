<?php
function get_assets_url($path = '') {
  return get_template_directory_uri() . '/assets' . ($path ? '/' . ltrim($path, '/') : '');
}

function get_assets_path($path = '') {
  return get_template_directory() . '/assets' . ($path ? '/' . ltrim($path, '/') : '');
}

