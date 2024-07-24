<?php

$cpt_store_key = 'store';

function review_cpt_metaboxes()
{
    add_meta_box('cpt_lojas_details', 'Detalhes da Loja', 'review_cpt_callback', 'loja', 'normal', 'high');
}
add_action('add_meta_boxes', 'review_cpt_metaboxes');


function review_cpt_callback($post)
{

    global $cpt_store_key;
    if (! $post) {
        return;
    }

    wp_nonce_field('cpt_lojas_save_details', 'cpt_lojas_details_nonce');

    $platforms = [
        ["name" => "Actionpay", "id" => "ACTIONPAY"],
        ["name" => "Afilio", "id" => "AFILIO"],
        ["name" => "Amazon", "id" => "AMAZON"],
        ["name" => "Awin", "id" => "AWIN"],
        ["name" => "Rakuten", "id" => "RAKUTEN"],
        ["name" => "Social Soul", "id" => "SOCIALSOUL"],
    ];
    sort($platforms);

    $type = get_post_meta($post->ID, $cpt_store_key . '_type', true);
    $logo = get_post_meta($post->ID, $cpt_store_key . '_logo', true);
    $logosvg = get_post_meta($post->ID, $cpt_store_key . '_logosvg', true);
    $description = get_post_meta($post->ID, $cpt_store_key . '_description', true);
    $domain = get_post_meta($post->ID, $cpt_store_key . '_domain', true);
    $url = get_post_meta($post->ID, $cpt_store_key . '_url', true);
    $email = get_post_meta($post->ID, $cpt_store_key . '_email', true);
    $ra_shortname = get_post_meta($post->ID, $cpt_store_key . '_ra_shortname', true);
    $ra_storeid = get_post_meta($post->ID, $cpt_store_key . '_ra_storeid', true);
    $ra_score = get_post_meta($post->ID, $cpt_store_key . '_ra_score', true);
    $programas = get_post_meta($post->ID, $cpt_store_key . '_affiliate', true);
    $programas = $programas ? $programas : null;
    ?>
    <table class="form-table">
        <tr>
            <th><label for="type">Tipo</label></th>
            <td>
                <select name="<?php echo ($cpt_store_key); ?>_type" class="cptstore-field cptstore-field-type">
                    <?php foreach ([["name" => "Brand", "id" => "BRAND"], ["name" => "Multi Brand", "id" => "MULTIBRAND"]] as $typeOption) : ?>
                        <option value="<?php echo ($typeOption['id']); ?>" <?php selected($type, $typeOption['id']); ?>>
                            <?php echo ($typeOption['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="logo">Imagem do Logo</label></th>
            <td>
                <input type="hidden" id="logo" name="<?php echo ($cpt_store_key . '_logo'); ?>"
                    value="<?php echo esc_attr($logo); ?>" />
                <button id="upload-logo" class="button">Adicionar Logo</button>
                <div id="logo-preview" style="margin-top: 10px;">
                    <?php if ($logo) : ?>
                        <img src="<?php echo esc_url($logo); ?>" style="max-width: 100px; height: auto;" />
                    <?php endif; ?>
                </div>
            </td>
        </tr>

        <tr>
            <th><label for="description">Descrição da Loja</label></th>
            <td><textarea id="description" name="<?php echo ($cpt_store_key . '_description'); ?>" rows="5"
                    cols="50"><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="domain">Domínio</label></th>
            <td><input type="text" id="domain" name="<?php echo ($cpt_store_key . '_domain'); ?>"
                    value="<?php echo ($domain); ?>" placeholder="example.com" /></td>
        </tr>
        <tr>
            <th><label for="url">Url</label></th>
            <td><input type="url" id="url" name="<?php echo ($cpt_store_key . '_url'); ?>"
                    value="<?php echo esc_url($url); ?>" placeholder="https://www.example.com" /></td>
        </tr>
        <tr>
            <th><label for="email">Email de Contato</label></th>
            <td><input type="email" id="email" name="<?php echo ($cpt_store_key . '_email'); ?>"
                    value="<?php echo esc_attr($email); ?>" /></td>
        </tr>
        <tr>
            <th><label for="programas">Programas de Afiliados</label></th>
            <td>
                <!-- PROGRAMS -->
                <div id="programas-wrapper">
                    <?php if (! empty($programas)) : ?>
                        <?php foreach ($programas as $index => $programa) :

                            $platform = isset($programa['platform']) ? $programa['platform'] : null;
                            $advertiserId = isset($programa['advertiser_id']) ? $programa['advertiser_id'] : null;
                            $publisherId = isset($programa['publisher_id']) ? $programa['publisher_id'] : null;
                            ?>
                            <div class="programa" style="margin: 30px auto">


                                <select style="width:200px;margin:auto 10px auto 0"
                                    name="<?php echo $cpt_store_key . '_affiliate' ?>[<?php echo $index; ?>][platform]">
                                    <?php foreach ($platforms as $platformOption) : ?>
                                        <option value="<?php echo ($platformOption['id']); ?>" <?php selected($platform, $platformOption['id']); ?>>
                                            <?php echo ($platformOption['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input style="width:150px;margin:auto 10px" type="text"
                                    name="<?php echo $cpt_store_key . '_affiliate' ?>[<?php echo $index; ?>][advertiser_id]"
                                    value="<?php echo esc_attr($advertiserId); ?>" placeholder="ID Advertiser" />

                                <input style="width:150px;margin:auto 10px" type="text"
                                    name="<?php echo $cpt_store_key . '_affiliate' ?>[<?php echo $index; ?>][publisher_id]"
                                    value="<?php echo esc_attr($publisherId); ?>" placeholder="ID Publisher" />

                                <input style="width:100px;margin:auto 10px" type="number"
                                    name="<?php echo $cpt_store_key . '_affiliate' ?>[<?php echo $index; ?>][comission]"
                                    value="<?php echo esc_attr($programa['comission']); ?>" placeholder="Comissão" />

                                <button class="remove-programa button">Remover</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button id="add-programa" class="button">Adicionar Programa</button>
                <!-- END PROGRAMS -->
            </td>
        </tr>
        <tr>
            <th><label for="ra_shortname">RA Store Shortname</label></th>
            <td><input type="text" id="ra_shortname" name="<?php echo ($cpt_store_key . '_ra_shortname'); ?>"
                    value="<?php echo esc_attr($ra_shortname); ?>" /></td>
        </tr>
        <tr>
            <th><label for="ra_storeid">RA Store ID</label></th>
            <td><input type="text" id="ra_storeid" name="<?php echo ($cpt_store_key . '_ra_storeid'); ?>"
                    value="<?php echo esc_attr($ra_storeid); ?>" /></td>
        </tr>
        <tr>
            <th><label for="ra_score">RA Store Score</label></th>
            <td>
                <fieldset>
                    <legend class="cptstore-field-legend"> </legend>
                    <input type="range" class="cptstore-field cptstore-field-range" min="0" max="10" step="0.1"
                        id="ra_score" name="<?php echo ($cpt_store_key . '_ra_score'); ?>"
                        value="<?php echo esc_attr($ra_score); ?>" />
                    <p>Nota: <output id="ra_score_output"></output></p>
                    <script>
                        const input_score = document.querySelector("#ra_score");
                        const value_score = document.querySelector("#ra_score_output");
                        value_score.textContent = input_score.value;
                        input_score.addEventListener("input", (event) => {
                            value_score.textContent = event.target.value;
                        });
                    </script>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th><label for="logosvg">SVG Logo</label></th>
            <td><textarea id="logosvg" name="<?php echo ($cpt_store_key . '_logosvg'); ?>" rows="5"
                    cols="50"><?php echo esc_textarea($logosvg); ?></textarea></td>
        </tr>
    </table>

    <script>
        jQuery(document).ready(function ($) {
            var programaIndex = <?php echo ! empty($programas) ? count($programas) + 1 : 0; ?>;

            $('#add-programa').on('click', function (e) {
                e.preventDefault();

                var programaHTML = '<div class="programa" style="margin: 30px auto">' +

                    '<select style="width:200px;margin:auto 10px auto 0" name="<?php echo $cpt_store_key . '_affiliate' ?>[' + programaIndex + '][platform]">' +
                    <?php foreach ($platforms as $typeOption) : ?>
                    '<option value="<?php echo ($typeOption['id']); ?>" <?php selected($type, $typeOption['id']); ?>><?php echo ($typeOption['name']); ?></option>' +
                    <?php endforeach; ?>
                '</select>' +
                    
                    '<input style="width:150px;margin:auto 10px" type="text" name="<?php echo ($cpt_store_key . '_affiliate'); ?>[' + programaIndex + '][advertiser_id]" placeholder="ID Advertiser" />' +
                    
                    '<input style="width:150px;margin:auto 10px" type="text" name="<?php echo ($cpt_store_key . '_affiliate'); ?>[' + programaIndex + '][publisher_id]" placeholder="ID Publisher" />' +
                    
                    '<input style="width:100px;margin:auto 10px" type="text" name="<?php echo ($cpt_store_key . '_affiliate'); ?>[' + programaIndex + '][comission]" placeholder="Comissão" />' +
                    
                    '<button class="remove-programa button">Remover</button>' +
                    '</div>';
                $('#programas-wrapper').append(programaHTML);
                programaIndex++;
            });

            $('#programas-wrapper').on('click', '.remove-programa', function (e) {
                e.preventDefault();
                $(this).closest('.programa').remove();
            });

            var file_frame;
            $('#upload-logo').on('click', function (e) {
                e.preventDefault();
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Selecionar Logo',
                    button: {
                        text: 'Usar Logo'
                    },
                    multiple: false
                });
                file_frame.on('select', function () {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    $('#logo').val(attachment.url);
                    $('#logo-preview').html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto;" />');
                });
                file_frame.open();
            });
        });
    </script>
    <?php
}
?>