<?php

use Review\Utils\TypeTenis;

$cpt_tenis_key = 'tenis';

function cpt_tenis_add_metaboxes()
{
    add_meta_box('cpt_tenis_details', 'Detalhes do Tênis', 'cpt_tenis_details_callback', 'tenis', 'normal', 'high');
}
add_action('add_meta_boxes', 'cpt_tenis_add_metaboxes');


function cpt_tenis_details_callback($post)
{

    global $cpt_tenis_key;

    wp_nonce_field('cpt_tenis_save_details', 'cpt_tenis_details_nonce');

    /**
     * Get Stores
     */
    $stores = [];
    $brands = [];
    $loja_query = new WP_Query(array(
        'post_type' => 'loja',
        'posts_per_page' => 50,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    if ($loja_query->have_posts()) :
        while ($loja_query->have_posts()) :
            $loja_query->the_post();
            $storeId = get_the_ID();
            $stores[] = [
                "id" => $storeId,
                "link" => get_permalink($storeId),
                "name" => get_the_title($storeId) . ' - ' . getValueCPTReview($storeId, 'domain', 'store'),
                "image" => getValueCPTReview($storeId, 'logo', 'store'),
                "svg" => getValueCPTReview($storeId, 'logosvg', 'store'),
                "description" => get_the_excerpt($storeId),
            ];
            if (getValueCPTReview($storeId, 'type', 'store') == "BRAND") :
                $brands[] = [
                    "id" => $storeId,
                    "name" => get_the_title($storeId) . ' - ' . getValueCPTReview($storeId, 'domain', 'store'),
                ];
            endif;
        endwhile;
        wp_reset_postdata();
    endif;

    $types = TypeTenis::getAll();

    $priceregular = get_post_meta($post->ID, $cpt_tenis_key . '_priceregular', true);
    $brand = get_post_meta($post->ID, $cpt_tenis_key . '_brand', true);
    $type = get_post_meta($post->ID, $cpt_tenis_key . '_type', true);
    $description = get_post_meta($post->ID, $cpt_tenis_key . '_description', true);
    $classification = get_post_meta($post->ID, $cpt_tenis_key . '_classification', true);
    $characteristics = get_post_meta($post->ID, $cpt_tenis_key . '_characteristics', true);
    $benefits = get_post_meta($post->ID, $cpt_tenis_key . '_benefits', true);
    $offers = get_post_meta($post->ID, $cpt_tenis_key . '_offers', true);
    $imagens = get_post_meta($post->ID, $cpt_tenis_key . '_images', true);
    ?>
    <table class="form-table">

        <tr>
            <th><label for="descricao">Marca</label></th>
            <td>
                <select name="<?php echo ($cpt_tenis_key); ?>_brand" class="cpttenis-field cpttenis-field-store">
                    <?php foreach ($brands as $brandOption) : ?>
                        <option value="<?php echo ($brandOption['id']); ?>" <?php selected($brand, $brandOption['id']); ?>>
                            <?php echo ($brandOption['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="descricao">Tipo</label></th>
            <td>
                <select name="<?php echo ($cpt_tenis_key); ?>_type" class="cpttenis-field cpttenis-field-store">
                    <?php foreach ($types as $typeOption) : ?>
                        <option value="<?php echo ($typeOption->getId()); ?>" <?php selected($type, $typeOption->getId()); ?>>
                            <?php echo ($typeOption->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="priceregular">Preço Regular</label></th>
            <td>
                <input type="number" id="priceregular" name="<?php echo ($cpt_tenis_key); ?>_priceregular"
                    value="<?php echo esc_attr($priceregular); ?>" placeholder="R$ " />
            </td>
        </tr>

        <tr>
            <th><label for="description">Descrição</label></th>
            <td><textarea id="description" name="<?php echo ($cpt_tenis_key); ?>_description" rows="5"
                    cols="50"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>

        <tr>
            <th><label for="characteristics">Características Técnicas</label></th>
            <td><textarea id="characteristics" name="<?php echo ($cpt_tenis_key); ?>_characteristics" rows="5"
                    cols="50"><?php echo esc_textarea($characteristics); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="benefits">Benefícios</label></th>
            <td><textarea id="benefits" name="<?php echo ($cpt_tenis_key); ?>_benefits" rows="5"
                    cols="50"><?php echo esc_textarea($benefits); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="ofertas">Ofertas</label></th>
            <td>
                <div id="ofertas-wrapper">
                    <?php if (! empty($offers)) : ?>
                        <?php foreach ($offers as $index => $oferta) : ?>
                            <div class="oferta">


                                <select name="<?php echo ($cpt_tenis_key); ?>_offers[<?php echo $index; ?>][loja]"
                                    class="cpttenis-field cpttenis-field-store">
                                    <?php foreach ($stores as $store) : ?>
                                        <option value="<?php echo ($store['id']); ?>" <?php selected($oferta['loja'], $store['id']); ?>>
                                            <?php echo ($store['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input type="number" class="cpttenis-field cpttenis-field-price"
                                    name="<?php echo ($cpt_tenis_key); ?>_offers[<?php echo $index; ?>][preco]"
                                    value="<?php echo esc_attr($oferta['preco']); ?>" placeholder="Preço" />
                                <br>

                                <input type="url" class="cpttenis-field cpttenis-field-url"
                                    name="<?php echo ($cpt_tenis_key); ?>_offers[<?php echo $index; ?>][url]"
                                    value="<?php echo esc_url($oferta['url']); ?>" placeholder="URL" />
                                <br>

                                <button class="remove-oferta button">Remover</button>
                                <br>
                                <hr class="cpttenis-field-separator" />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button id="add-oferta" class="button">Adicionar Oferta</button>
            </td>
        </tr>
        <tr>
            <th><label for="imagens">Imagens do Produto</label></th>
            <td>
                <input type="hidden" id="imagens" name="<?php echo ($cpt_tenis_key); ?>_images"
                    value="<?php echo esc_attr($imagens); ?>" />
                <button id="upload-imagens" class="button">Adicionar Imagens</button>
                <div id="imagens-preview"></div>
            </td>
        </tr>
        <tr>
            <th><label for="classification">Classificação</label></th>
            <td>

                <?php foreach (["conforto", "durabilidade", "estabilidade", "peso", "amortecimento", "tracao", "respirabilidade", "design"] as $fieldScore) : ?>
                    <fieldset>
                        <legend class="cpttenis-field-legend"><?php echo ($fieldScore); ?></legend>
                        <input type="range" class="cpttenis-field cpttenis-field-range" min="0" max="10"
                            id="classification_<?php echo ($fieldScore); ?>"
                            name="<?php echo ($cpt_tenis_key); ?>_classification[<?php echo ($fieldScore); ?>]"
                            value="<?php echo esc_attr($classification[$fieldScore] ?? ''); ?>"
                            placeholder="<?php echo ($fieldScore); ?> (0-10)" />
                        <p>Nota: <output id="classification_<?php echo ($fieldScore); ?>_score"></output></p>
                        <script>
                            const input_<?php echo ($fieldScore); ?> = document.querySelector("#classification_<?php echo ($fieldScore); ?>");
                            const value_<?php echo ($fieldScore); ?> = document.querySelector("#classification_<?php echo ($fieldScore); ?>_score");
                            value_<?php echo ($fieldScore); ?>.textContent = input_<?php echo ($fieldScore); ?>.value;
                            input_<?php echo ($fieldScore); ?>.addEventListener("input", (event) => {
                                value_<?php echo ($fieldScore); ?>.textContent = event.target.value;
                            });
                        </script>
                    </fieldset>
                    <hr class="cpttenis-field-separator" />
                <?php endforeach; ?>


            </td>
        </tr>

    </table>
    <script>
        jQuery(document).ready(function ($) {
            var ofertaIndex = <?php echo ! empty($ofertas) ? count($ofertas) : 0; ?>;

            $('#add-oferta').on('click', function (e) {
                e.preventDefault();
                var ofertaHTML = '<div class="oferta">' +
                    '<select name="<?php echo ($cpt_tenis_key); ?>_offers[' + ofertaIndex + '][loja]" class="cpttenis-field cpttenis-field-store">' +
                    <?php foreach ($stores as $store) : ?>
                    '<option value="<?php echo ($store['id']); ?>"><?php echo ($store['name']); ?></option>' +
                    <?php endforeach; ?>
                '</select>' +
                    '<input type="number" class="cpttenis-field cpttenis-field-price" name="<?php echo ($cpt_tenis_key); ?>_offers[' + ofertaIndex + '][preco]" placeholder="Preço" />' +
                    '<input type="url" class="cpttenis-field cpttenis-field-url" name="<?php echo ($cpt_tenis_key); ?>_offers[' + ofertaIndex + '][url]" placeholder="URL" /><br>' +
                    '<button class="remove-oferta button">Remover</button><br>' +
                    '</div><hr class="cpttenis-field-separator" />';
                $('#ofertas-wrapper').append(ofertaHTML);
                ofertaIndex++;
            });

            $('#ofertas-wrapper').on('click', '.remove-oferta', function (e) {
                e.preventDefault();
                $(this).closest('.oferta').remove();
            });

            var file_frame;
            $('#upload-imagens').on('click', function (e) {
                e.preventDefault();
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Selecionar Imagens',
                    button: {
                        text: 'Usar Imagens'
                    },
                    multiple: true
                });
                file_frame.on('select', function () {
                    var attachments = file_frame.state().get('selection').toJSON();
                    var imageURLs = attachments.map(function (attachment) {
                        return attachment.url;
                    }).join(',');
                    $('#imagens').val(imageURLs);
                    var previewHTML = attachments.map(function (attachment) {
                        return '<img src="' + attachment.url + '" style="max-width: 100px; height: auto; margin-right: 10px;" />';
                    }).join('');
                    $('#imagens-preview').html(previewHTML);
                });
                file_frame.open();
            });
        });
    </script>
    <?php
}
?>