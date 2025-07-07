<?php
/*
 * שם: בלוק עמודות עם עורך טקסט
 * תיאור: שתי עמודות, כל עמודה עם כותרת, תמונה מרובעת, ועורך טקסט עשיר
 */

if (!defined('ABSPATH')) {
    exit;
}

/* @var $options array */
/* @var $composer array */

$defaults = array(
    'responsive' => '1',
    'font_family' => 'Arial, \'Helvetica Neue\', Helvetica, sans-serif',
    'font_size' => 14,
    'font_color' => '',
    'font_weight' => '',
    'crop' => '3',
    'block_padding_left' => 0,
    'block_padding_right' => 0,
    'block_padding_top' => 15,
    'block_padding_bottom' => 15,
    'block_background' => '',
    'border-radius' => '',
    'background-color' => '',
    'border-color' => '',
    'padding-left' => '',
    'padding-right' => '',
    'padding-top' => '',
    'padding-bottom' => '',
    'box-shadow-x' => '',
    'box-shadow-y' => '',
    'box-shadow-blur' => '',
    'box-shadow-spread' => '',
    'box-shadow-color' => '',
);
for ($i = 1; $i <= 2; $i++) {
    $defaults['image_' . $i] = '';
    $defaults['title_' . $i] = '';
    $defaults['html_' . $i] = '';
    $defaults['url_' . $i] = '';
    $defaults['title_color_' . $i] = '#d2282f';
    $defaults['title_size_' . $i] = 20;
    $defaults['title_font_' . $i] = 'Tahoma,Verdana,Segoe,sans-serif';
}
$options = array_merge($defaults, $options);

// RTL & Hebrew
$dir = 'rtl';
$text_align = 'right';

// Responsive grid
$responsive = !empty($options['responsive']);
$columns = 2;
$grid_padding = 8;
$content_width = $composer['content_width'] ?? 600;
$column_width = floor(($content_width - $grid_padding * $columns * 2) / $columns);

// Inline styles for email compatibility
function tnp_dummyblock_column_style($options) {
    $styles = [];
    if (!empty($options['background-color'])) $styles[] = 'background-color:' . esc_attr($options['background-color']);
    if (!empty($options['border-color'])) $styles[] = 'border:1px solid ' . esc_attr($options['border-color']);
    if (!empty($options['border-radius'])) $styles[] = 'border-radius:' . intval($options['border-radius']) . 'px';
    if (!empty($options['padding-top'])) $styles[] = 'padding-top:' . intval($options['padding-top']) . 'px';
    if (!empty($options['padding-bottom'])) $styles[] = 'padding-bottom:' . intval($options['padding-bottom']) . 'px';
    if (!empty($options['padding-left'])) $styles[] = 'padding-left:' . intval($options['padding-left']) . 'px';
    if (!empty($options['padding-right'])) $styles[] = 'padding-right:' . intval($options['padding-right']) . 'px';
    if (!empty($options['box-shadow-x']) || !empty($options['box-shadow-y']) || !empty($options['box-shadow-blur']) || !empty($options['box-shadow-spread']) || !empty($options['box-shadow-color'])) {
        $x = intval($options['box-shadow-x'] ?? 0);
        $y = intval($options['box-shadow-y'] ?? 0);
        $blur = intval($options['box-shadow-blur'] ?? 0);
        $spread = intval($options['box-shadow-spread'] ?? 0);
        $color = esc_attr($options['box-shadow-color'] ?? '#000');
        $styles[] = "box-shadow: {$x}px {$y}px {$blur}px {$spread}px {$color}";
    }
    $styles[] = 'direction:rtl;text-align:right;';
    return implode(';', $styles);
}

function tnp_dummyblock_title_style($options, $i) {
    $styles = [];
    $font = $options['title_font_' . $i] ?? 'Tahoma,Verdana,Segoe,sans-serif';
    $size = $options['title_size_' . $i] ?? 20;
    $color = $options['title_color_' . $i] ?? '';
    if ($color) $styles[] = 'color:' . esc_attr($color);
    if ($size) $styles[] = 'font-size:' . intval($size) . 'px';
    if ($font) $styles[] = 'font-family:' . esc_attr($font);
    $styles[] = 'font-weight:bold';
    $styles[] = 'margin-bottom:8px';
    $styles[] = 'direction:rtl;text-align:right;';
    return implode(';', $styles);
}

function tnp_dummyblock_passage_style($options) {
    $font = $options['font_family'] ?? 'Arial, \'Helvetica Neue\', Helvetica, sans-serif';
    $size = $options['font_size'] ?? 14;
    $styles = [
        'font-family:' . esc_attr($font),
        'font-size:' . intval($size) . 'px',
        'direction:rtl',
        'text-align:right',
        'margin:0',
    ];
    return implode(';', $styles);
}

// Column content
$columns_html = [];
for ($i = 1; $i <= 2; $i++) {
    $image_html = '';
    if (!empty($options['image_' . $i]['id'])) {
        $image = tnp_resize_2x($options['image_' . $i]['id'], [250, 250, true]);
        if ($image) {
            $image->set_width(250);
            $image->set_height(250);
            $image_html = TNP_Composer::image($image);
        }
    }
    $title = $options['title_' . $i] ?? '';
    $html = $options['html_' . $i] ?? '';
    $url = $options['url_' . $i] ?? '';
    ob_start();
    ?>
    <div style="<?php echo tnp_dummyblock_column_style($options); ?>">
        <?php if ($title) { ?>
            <div style="<?php echo tnp_dummyblock_title_style($options, $i); ?>">
                <?php echo esc_html($title); ?>
            </div>
        <?php } ?>
        <?php if ($url) { ?>
            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" style="text-decoration:none;display:block;color:#d02932;">
        <?php } ?>
        <?php if ($image_html) { ?>
            <div style="text-align:center;margin-bottom:10px;">
                <?php echo $image_html; ?>
            </div>
        <?php } ?>
        <?php if ($html) { ?>
            <div style="<?php echo tnp_dummyblock_passage_style($options); ?>">
                <?php echo wp_kses_post($html); ?>
            </div>
        <?php } ?>
        <?php if ($url) { ?>
            </a>
        <?php } ?>
    </div>
    <?php
    $columns_html[] = ob_get_clean();
}

// Responsive CSS (for web view, not email clients)
?>
<style>
@media only screen and (max-width: 600px) {
    .tnp-dummyblock-columns {
        display: block !important;
    }
    .tnp-dummyblock-column {
        width: 100% !important;
        display: block !important;
        margin-bottom: 20px !important;
    }
}
.tnp-dummyblock-columns a { color: #d02932 !important; }
</style>
<table class="tnp-dummyblock-columns" dir="rtl" width="100%" cellpadding="0" cellspacing="0" border="0" style="direction:rtl;text-align:right;width:100%;">
    <tr>
        <?php foreach ($columns_html as $col_html) { ?>
            <td class="tnp-dummyblock-column" width="50%" valign="top" style="vertical-align:top;width:50%;padding:8px;direction:rtl;text-align:right;">
                <?php echo $col_html; ?>
            </td>
        <?php } ?>
    </tr>
</table>
