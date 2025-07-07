<?php
/* @var $options array */
/* @var $controls NewsletterControls */
/* @var $fields NewsletterFields */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$composer = $composer ?? [];
?>

<p>
    ניתן להוסיף בלוק עם שתי עמודות, כל עמודה כוללת כותרת (עם אפשרות עיצוב), תמונה מרובעת (250x250), עורך טקסט עשיר, וקישור.
</p>

<?php $fields->block_style('', ['default' => 'ברירת מחדל', 'inverted' => 'הפוך']); ?>

<div class="tnp-accordion">
    <h3>הגדרות כלליות</h3>
    <div>
        <div class="tnp-field-row">
            <div class="tnp-field-col-2">
                <?php $fields->select('responsive', 'רספונסיבי', ['1' => 'כן', '0' => 'לא']) ?>
            </div>
            <div class="tnp-field-col-2">
                <?php $fields->select('crop', 'חיתוך תמונה', ['3' => 'ריבוע (1:1)']) ?>
            </div>
        </div>
        <?php
        $fields->font('font', __('גופן טקסט', 'newsletter'), [
            'family_default' => true,
            'size_default' => true,
            'weight_default' => true,
            'family' => 'Arial, \'Helvetica Neue\', Helvetica, sans-serif',
            'size' => 14,
            'align' => 'right',
            'color' => '#d23038',
        ]);
        $fields->font('title_font', __('גופן כותרת', 'newsletter'), [
            'family_default' => true,
            'size_default' => true,
            'weight_default' => true,
            'family' => 'Tahoma,Verdana,Segoe,sans-serif',
            'size' => 20,
            'align' => 'right',
            'color' => '#d23038',
        ]);
        ?>
    </div>

    <?php for ($i = 1; $i <= 2; $i++) { ?>
        <h3>עמודה <?php echo $i; ?></h3>
        <div>
            <?php $fields->text('title_' . $i, 'כותרת', ['style' => 'text-align:right;']) ?>
            <div class="tnp-field-row">
                <div class="tnp-field-col-4">
                    <?php $fields->color('title_color_' . $i, 'צבע כותרת', ['default' => '#d23038']) ?>
                </div>
                <div class="tnp-field-col-4">
                    <?php $fields->size('title_size_' . $i, 'גודל כותרת (px)', ['default' => 20]) ?>
                </div>
                <div class="tnp-field-col-4">
                    <?php 
                    $fields->font('title_font_' . $i, 'גופן כותרת', [
                        'family_default' => true,
                        'size_default' => true,
                        'weight_default' => true,
                        'family' => 'Tahoma,Verdana,Segoe,sans-serif',
                        'size' => 20,
                        'align' => 'right',
                        'color' => '#d23038',
                    ]); 
                    ?>
                </div>
            </div>
            <div style="clear:both; margin: 16px 0 8px 0;"></div>
            <div>
                <?php $fields->media('image_' . $i, 'תמונה (250x250 פיקסלים)', ['style' => 'display:block;margin:0 auto 10px auto;max-width:250px;']) ?>
            </div>
            <div style="margin: 10px 0;"></div>
            <?php $fields->wp_editor('html_' . $i, 'פסקה', [
                'text_font_family'  => $composer['text_font_family'] ?? 'Arial, \'Helvetica Neue\', Helvetica, sans-serif',
                'text_font_size'    => $composer['text_font_size'] ?? 14,
                'text_font_weight'  => $composer['text_font_weight'] ?? '',
                'text_font_color'   => $composer['text_font_color'] ?? '#d23038',
                'background'        => $options['block_background'] ?? '',
                'align'             => 'right',
                'tinymce'           => [
                    'plugins'      => 'code',
                    'toolbar'      => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
                ],
                'quicktags'         => true,
            ]) ?>
            <?php $fields->url('url_' . $i, 'קישור (ייפתח בלשונית חדשה)', ['default' => '', 'style' => 'direction:rtl;text-align:right;color:#d23038;']) ?>
        </div>
    <?php } ?>

    <h3>עיצוב מתקדם</h3>
    <div>
        <div class="tnp-field-row">
            <div class="tnp-field-col-3">
                <?php $fields->size('border-radius', __('רדיוס פינות', 'newsletter')) ?>
            </div>
            <div class="tnp-field-col-3">
                <?php $fields->color('background-color', __('צבע רקע', 'newsletter')) ?>
            </div>
            <div class="tnp-field-col-3">
                <?php $fields->color('border-color', __('צבע מסגרת', 'newsletter')) ?>
            </div>
        </div>
        <div class="tnp-field-row">
            <div class="tnp-field-col">
                <p style="margin: 0; font-size: 14px; font-weight: 300; padding-bottom: 5px; color: #666;">ריווח פנימי</p>
                <table width="100%">
                    <tr>
                        <td><?php $fields->size('padding-left', __('&larr; שמאל', 'newsletter')) ?></td>
                        <td><?php $fields->size('padding-top', __('&uarr; עליון', 'newsletter')) ?><?php $fields->size('padding-bottom', __('&darr; תחתון', 'newsletter')) ?></td>
                        <td><?php $fields->size('padding-right', __('&rarr; ימין', 'newsletter')) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tnp-field-row">
            <div class="tnp-field-col">
                <p style="margin: 0; font-size: 14px; font-weight: 300; padding-bottom: 5px; color: #666;">צללית</p>
                <table width="100%">
                    <tr>
                        <td><?php $fields->color('box-shadow-color', __('צבע', 'newsletter')) ?></td>
                        <td><?php $fields->size('box-shadow-x', __('&harr; X', 'newsletter')) ?></td>
                        <td><?php $fields->size('box-shadow-y', __('&varr; Y', 'newsletter')) ?></td>
                        <td><?php $fields->size('box-shadow-blur', __('טשטוש', 'newsletter')) ?></td>
                        <td><?php $fields->size('box-shadow-spread', __('התרחבות', 'newsletter')) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <h3>הגדרות כלליות</h3>
    <div>
        <?php $fields->block_commons() ?>
    </div>
</div>
