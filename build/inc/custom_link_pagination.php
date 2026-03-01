<?php
/**
 * Кастомные ссылки пагинации
 *
 * @param int    $page_number Номер страницы
 * @param string $post_type   Тип записи (news)
 * @param string $filter      Фильтр (кириллица), сохраняется в URL
 */
function get_custom_pagenum_link($page_number, $post_type = null, $filter = '') {
  if ($post_type === 'news') {
    $page = get_page_by_path('news');
    if ($page) {
      $base_url = get_permalink($page);
      $args = [];

      if ($page_number > 1) {
        $args['paged'] = $page_number;
      }
      if ($filter !== '' && $filter !== 'Все материалы') {
        $args['filter'] = $filter; // add_query_arg закодирует кириллицу
      }

      return empty($args) ? $base_url : add_query_arg($args, $base_url);
    }
  }
  return get_pagenum_link($page_number);
}

add_action('init', function() {
  add_rewrite_rule(
    '^news/page/([0-9]+)/?$',
    'index.php?pagename=news&paged=$matches[1]',
    'top'
  );
}, 10, 0);