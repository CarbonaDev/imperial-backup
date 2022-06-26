<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php //CAIXA DE TEXTO + BOTÃO VERIFICAR + LABEL DIGITE SEU EMAIL .
//Se tiver email_exists(email) = id, mostra div login, senão mostra div de cadastro.

//De qqlr maneira retorna pra checkout. 
$showVerif=true; ?>

         <form name="form" action="" method="get" style="display: flex;
    justify-content: center;">

         <div class="verificacao" id="verificacao" <?php if ($showVerif==false){?>style="display:none"<?php } else {?>style="display:block" <?php } ?>>	
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="display: flex;
    flex-direction: column;
        align-items: center;
        position: relative;
    left: 0%!important;">
                <label for="username" style="font-size:16px;"><b>Digite seu email para continuar</b>:<span class="required">*</span></label>
                <?php
                if ( WC()->cart->get_cart_contents_count() > 0 ){
                	echo " <input type='hidden' name='return-to-checkout' id='return-to-checkout' value='true'> ";
                }
                ?>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="verificaemail" id="verificaemail" autocomplete="username" value="<?php echo ( ! empty( $_POST['verificaemail'] ) ) ? esc_attr( wp_unslash( $_POST['verificaemail'] ) ) : ''; ?>" style="box-shadow: 0px 0px 3px grey;"/><?php // @codingStandardsIgnoreLine ?>

                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" id="botao" value="Verificar" style="border-radius: 13px!important;
    background-color: #937c5c;
    color: white;
    margin-top: 10px;
    text-transform: capitalize;
    padding: 13px 30px;
    ">Continuar</button>


				<?php
					
					$showRegistro = false;	
                	$showLogin = false;
				    
				    if( $_GET['verificaemail'] != "") {
				    	if ( email_exists( $_GET['verificaemail']) !== false) {
				    	$showRegistro = false;	
                		$showLogin = true;
                		echo "<script>document.getElementById('verificacao').style['display'] = 'none';</script>";
				        } else {
				        $showRegistro = true;	
                		$showLogin = false;
						echo "<script>document.getElementById('verificacao').style['display'] = 'none';</script>";
				        }//onFunc();
				    }

				    ?>
				</p></div>

</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1" id="loginuser" <?php if ($showLogin==false){?>style="display:none"<?php } else {?>style="display:block" <?php } ?>>

		<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo $_GET['verificaemail']; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row" style="    padding: 10px 125px; text-align: center;">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" style="margin-top: 10px;">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>" style="border-radius: 13px!important;
    background-color: #937c5c;
    color: white;
    text-transform: capitalize;
    padding: 13px 30px;">Continuar</button>
			</p>
							
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Esqueceu sua senha?</a> <!-- <?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?> -->
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="u-column2 col-2" id="registeruser" <?php if ($showRegistro==false){?>style="display:none"<?php } else {?>style="display:block" <?php } ?> >

		<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo $_GET['verificaemail']; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo $_GET['verificaemail']; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-form-row form-row" style="display: flex;
    flex-direction: row;
    justify-content: center;">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" style="border-radius: 13px!important;
    background-color: #937c5c;
    color: white;
    text-transform: capitalize;
    padding: 13px 30px;">Continuar</button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
