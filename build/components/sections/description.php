<?php
if (!function_exists('perspectiva_h2_anchor_id')) {
    /**
     * Заголовок → латинский slug для id (a-z0-9-)
     */
    function perspectiva_h2_anchor_id($text)
    {
        $text = trim(wp_strip_all_tags($text));
        if ($text === '') {
            return 'section';
        }

        $ru = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
                'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
                'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );

        $text = strtr($text, $ru);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : 'section';
    }
}

$product_id = get_the_ID();
$card_group = get_field('card_group', $product_id);
$card_group = is_array($card_group) ? $card_group : array();

$card_info = isset($card_group['card_info']) ? (string)$card_group['card_info'] : '';
$czena_i_razmery = (!empty($card_group['czena_i_razmery']) && is_array($card_group['czena_i_razmery'])) ? $card_group['czena_i_razmery'] : array();

$h2_list = array();
$card_output = $card_info;

if ($card_info !== '' && is_string($card_info) && class_exists('DOMDocument')) {
    $wrap_id = 'card-info-root';
    $html = '<div id="' . esc_attr($wrap_id) . '">' . $card_info . '</div>';

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//div[@id="' . $wrap_id . '"]//h2');

    $used_ids = array();

    foreach ($nodes as $node) {
        $text = trim($node->textContent);
        if ($text === '') continue;

        $id = $node->getAttribute('id');

        // Если id нет — генерим
        if ($id === '') {
            if ($text === 'Характеристики') {
                $id = 'info';
            } elseif ($text === 'Описание') {
                $id = 'card-description';
            } else {
                $id = perspectiva_h2_anchor_id($text);
            }
        }

        // Делаем уникальным
        if (in_array($id, $used_ids, true)) {
            $base = $id;
            $n = 2;
            $new_id = $base . '-' . $n;
            while (in_array($new_id, $used_ids, true)) {
                $n++;
                $new_id = $base . '-' . $n;
            }
            $id = $new_id;
        }

        $used_ids[] = $id;
        $node->setAttribute('id', $id);

        $h2_list[] = array(
                'id' => $id,
                'text' => $text,
        );
    }

    // Забираем только внутренности root
    $root = $dom->getElementById($wrap_id);
    if ($root) {
        $card_output = '';
        foreach ($root->childNodes as $child) {
            $card_output .= $dom->saveHTML($child);
        }
    }
}
?>

<section class="description" id="description">
    <div class="container">
        <div class="description__wrapper">
            <div class="description__item">
                <?= $card_output; ?>
                <?php if ($czena_i_razmery) : ?>
                    <h2 id="size">Размеры фиброцементных панелей</h2>
                    <ul>
                        <?php foreach ($czena_i_razmery as $term) :
                            if (!is_array($term) || empty($term['size'])) continue;
                            ?>
                            <li><?= esc_html($term['size']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <h2 id="certificates">Сертификаты</h2>
                <?php get_template_part('components/elements/certificates'); ?>
            </div>

            <div class="description__item">
                <div class="description__item-sidebar-inner">
                    <ul class="description__item-sidebar">
                        <?php foreach ($h2_list as $h2) :
                            if ($h2['id'] === 'description') continue;
                            ?>
                            <li class="description__anchor">
                                <a href="#<?= esc_attr($h2['id']); ?>">
                                    <?= esc_html($h2['text']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                        <li class="description__anchor">
                            <a href="#size">Размеры</a>
                        </li>
                        <li class="description__anchor">
                            <a href="#certificates">Сертификаты</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="products-small-section">
    <div class="container">
        <?php get_template_part('components/elements/products-small'); ?>
    </div>
</section>