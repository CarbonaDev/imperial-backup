<?php
/**
 * Provide a admin area view for the plugin
 */
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://letti.com.br/wordpress
 * @since      "1.0.0"
 * @package    Clearsale
 * @subpackage Clearsale/admin/partials
 */
?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="clearsale_options" id="cs_options" action="options.php">

    <?php
        //Grab all options - pegar do banco os dados e completar as variaveis
        $options = get_option($this->plugin_name);

        // Clearsale - dar o "echo" delas no form abaixo
        $modo = $options['modo']; // vem numerico, na base 1:0 
        $login = $options['login'];
        $password = $options['password'];
        $finger = $options['finger'];
        $cancel_order = $options['cancel_order']; // true = on qdo tiver reprovação da Clear cancelar pedido
        if (!isset($options['status_of_aproved'])) $status_of_aproved = "wc-processing";
        else $status_of_aproved = $options['status_of_aproved']; // o status que vamos colocar qdo o pedido for aprovado
        // antes sempre era wc-processing, isto é feito em: Cs_status
        $debug = $options['debug']; // =on ligado(checked)
        $tmp = wc_get_order_statuses();
        $remover = array("wc-cs-inanalisis" => "Análise de Risco ClearSale", "wc-cancelled" => "Cancelado", "wc-failed" => "Malsucedido");
        $status_all = array_diff($tmp, $remover)
        /*
        $key = array_search('wc-cs-inanalisis', $status_all);
        if($key!==false){
            unset($status_all[$key]);
        }
        $key = array_search('wc-cancelled', $status_all);
        if($key!==false){
            unset($status_all[$key]);
        }
        */
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>
        
        <h2><?php esc_attr_e( 'View all ClearSale products', $this->plugin_name ); ?>
        <a href="https://br.clear.sale/antifraude/ecommerce" target="_blank"><?php esc_attr_e( 'here', $this->plugin_name ); ?></a>
        </h2>

        <h2><?php esc_attr_e( 'Select between test and production environment', $this->plugin_name ); ?></h2>
        <select name="<?php echo $this->plugin_name; ?>[modo]" id="<?php echo $this->plugin_name; ?>-modo">
            <option <?php if ($modo==1) echo 'selected="selected"';?> value="1"><?php _e('ClearSale Test (homologation)',$this->plugin_name); ?></option>
	        <option <?php if (!$modo || $modo==0) echo 'selected="selected"';?> value="0"><?php _e('ClearSale Production',$this->plugin_name); ?></option>

        </select>

        <h2><?php esc_attr_e( 'Enter login and password provided by ClearSale', $this->plugin_name ); ?></h2>
        <fieldset>
            <legend class="screen-reader-text"><span>login</span></legend>
            <?php _e('Login: ', $this->plugin_name); ?>
            <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-login" name="<?php echo $this->plugin_name; ?>[login]" value="<?php echo $login; ?>"/>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span>password</span></legend>
            <?php _e('Password: ', $this->plugin_name); ?>
            <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-password" name="<?php echo $this->plugin_name; ?>[password]" value="<?php echo $password; ?>"/>
        </fieldset>

        <fieldset>
            <p><?php _e('Enter the Fingerprint provided by ClearSale,', $this->plugin_name); ?>
              </br><?php _e('You should have a number like this: a6s8h29ym6xgm5qor3sk', $this->plugin_name); ?>
            </p>
            <legend class="screen-reader-text"><span><?php _e('finger', $this->plugin_name); ?></span></legend>
            <input type="textarea" cols="80" rows="10" id="<?php echo $this->plugin_name; ?>-finger" name="<?php echo $this->plugin_name; ?>[finger]" value="<?php echo $finger; ?>"/>
        </fieldset>

        <br>
        <h2><?php _e('Cancel order when CleaSale status is negative', $this->plugin_name ); ?></h2>
        <?php $tmp='<script type="text/javascript"> var flag=0; '; if ($cancel_order) $tmp.=' flag=1;';  $tmp.=' </script>'; echo $tmp; ?>
        <fieldset>
            <?php _e('Cancel Order:', $this->plugin_name); ?>
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-cancel_order" onclick="msgcheckbox();" name="<?php echo $this->plugin_name; ?>[cancel_order]"
               <?php if ($cancel_order) echo 'checked="checked"' ?>>
            <div id="msgchkbox" style="display: <?php if ($cancel_order) echo 'none; '; else echo 'block; ' ?>">
                <h3><?php _e('ClearSale is not responsible for orders that follow after our disapproval', $this->plugin_name ); ?></h3>
            </div>
        </fieldset>
<?php echo '<script type="text/javascript"> 
        function msgcheckbox() {
            if (flag==0) flag = 1; else flag = 0;
            if (flag == 0) document.getElementById("msgchkbox").style.display = "block";
            else document.getElementById("msgchkbox").style.display = "none";
        }
    </script>'; ?>
        <br>
        <h2><?php esc_attr_e( 'Select New status after order is approved. Default: Processing', $this->plugin_name ); ?></h2>
        <select name="<?php echo $this->plugin_name; ?>[status]" id="<?php echo $this->plugin_name; ?>-status">
        <?php foreach($status_all as $key => $s_names) {?>
            <option <?php if ($status_of_aproved==$key) echo 'selected="selected"';?> value=<?php echo $key?>><?php _e($s_names,$this->plugin_name); ?></option>
        <?php } ?>
        </select>
        <br><br>
        <h2><?php esc_attr_e( 'Please, inform the URL below to ClearSale. This action will allow the retailer to receive approval/disapproval of the operations.', $this->plugin_name ); ?></h2>
        <h2><?php echo get_site_url() . "/wp-content/plugins/clearsale-total/public/status.php" ?></h2>

        <br>
        <?php $tmp = sprintf( __( 'Log ClearSale events, such as API requests, you can check this log in %s.', $this->plugin_name ), '<a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs&log_file=' . esc_attr( $this->plugin_name ) . '-' . date("Y-m-d") . '-' . sanitize_file_name( wp_hash( $this->plugin_name ) ) . '.log' ) ) . '">' . __( 'System Status &gt; Logs', $this->plugin_name ) . '</a>' ); ?>
        <fieldset>
            <p><?php _e('Enable Log: ', $this->plugin_name); ?></p>
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-debug" name="<?php echo $this->plugin_name; ?>[debug]"
               <?php if ($debug) echo 'checked="checked"' ?>>
            <?php echo $tmp; ?>
        </fieldset>
        <br>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
        <?php settings_fields($this->plugin_name); ?>
    </form>


</div>

