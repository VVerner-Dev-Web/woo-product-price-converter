<?php defined('ABSPATH') || exit('No direct script access allowed');

$updateIntervalTime = isset($_POST['update_interval_time']) ? $_POST['update_interval_time'] : null;

if($updateIntervalTime) :
    if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], $_POST['action']) ) : 
        update_option('update_interval_time', $updateIntervalTime, false);
    endif;
endif;

$IntervalTime = $updateIntervalTime ? $updateIntervalTime : get_option('update_interval_time');

$timeOptions = [
    ['option_value' => 5 * MINUTE_IN_SECONDS, 'option_text' => '5 minutos'],
    ['option_value' => 10 * MINUTE_IN_SECONDS, 'option_text' => '10 minutos'],
    ['option_value' => 30 * MINUTE_IN_SECONDS, 'option_text' => '30 minutos'],
    ['option_value' => 1 * HOUR_IN_SECONDS, 'option_text' => '1 hora'],
    ['option_value' => 2 * HOUR_IN_SECONDS, 'option_text' => '2 horas'],
    ['option_value' => 3 * HOUR_IN_SECONDS, 'option_text' => '3 horas'],
    ['option_value' => 6 * HOUR_IN_SECONDS, 'option_text' => '6 horas'],
    ['option_value' => 12 * HOUR_IN_SECONDS, 'option_text' => '12 horas'],
    ['option_value' => DAY_IN_SECONDS, 'option_text' => '1 dia'],    
];




?>
<div class="wrap">
    
    <h2>Conversão de preços</h2>
    
    <form method="POST">
        <table>
            <tr>
                <td>Intervalo de atualização de preços</td>
                <td>
                    <select name="update_interval_time">
                        <?php foreach ($timeOptions as $timeOption) :?>
                            <option <?php selected($IntervalTime, $timeOption['option_value']);?> value="<?= $timeOption['option_value'];?>"> <?= $timeOption['option_text'];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <?php wp_nonce_field('update_option');?>
                    <input type="hidden" name="action" value="update_option">
                    <button class="button-primary">Salvar</button>
                </th>
            </tr>
        </table>
    </form>
</div>
