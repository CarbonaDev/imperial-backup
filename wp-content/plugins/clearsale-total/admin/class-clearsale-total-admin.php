<?php

/**
 * The admin-specific functionality of the plugin.
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks for how to enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Clearsale_Total
 * @subpackage Clearsale_Total/admin
 * @author     Letti Tecnologia <contato@letti.com.br>
 * @link       https://letti.com.br/wordpress
 * @since      "1.0.0"
 *
 */
class Clearsale_Total_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    "1.0.0"
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    "1.0.0"
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    "1.0.0"
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wp_cs_options = get_option($this->plugin_name);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    "1.0.0"
	 */
	public function cs_total_enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Clearsale_Total_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Clearsale_Total_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/clearsale-total-admin.css', array(), $this->version, 'all');

	} // end of cs_total_enqueue_styles

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    "1.0.0"
	 */
	public function cs_total_enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Clearsale_Total_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Clearsale_Total_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/clearsale-total-admin.js', array('jquery'), $this->version, false);

	} // end of cs_total_enqueue_scripts


	/**
 	* Register the administration menu for this plugin into the WordPress Dashboard menu.
 	*
 	* @since    1.0.0
 	*/

	public function cs_total_add_plugin_admin_menu()
	{
    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
		// para traducao usar o metodo __()
		//$tmp = __('WooCommerce - ClearSale - Settings');
		$tmp = __('WooCommerce - ClearSale Total - Configurações') . " - V " . PLUGIN_NAME_VERSION_CS_TOTAL;
		add_options_page($tmp, 'ClearSale Total', 'manage_options', $this->plugin_name, array($this, 'cs_total_display_plugin_setup_page')
    	);
	}

	/**
 	* Add settings action link to the plugins page.
 	*
 	* @since    1.0.0
 	*/

	public function cs_total_add_action_links($links)
	{
    /*
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
    */
   		$settings_link = array(
    		'<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
   			);
   		return array_merge($settings_link, $links);

	} // end of cs_total_add_action_links

	/**
 	* Render the settings page for this plugin.
 	*
 	* @since    1.0.0
 	*/

	public function cs_total_display_plugin_setup_page()
	{
    	include_once('partials/clearsale-total-admin-display.php');
	}

	/**
	*
	* Valida os inputs
	*
	**/
	public function validate($input)
	{
    	// Validate all inputs        
    	$valid = array();

	//	$valid['cleanup'] = (isset($input['cleanup']) && !empty($input['cleanup'])) ? 1 : 0;
   
		// modo: producao=0 homologacao=1
		//ClearSale Inputs
		if ( !isset($input['modo']) ) $modo = 1 ; else $modo = $input['modo'];
		if ( !isset($input['cancel_order']) ) $cancel = 0; else $cancel = 1;

		if ( !isset($input['status'])) $status_of_aproved = "wc-processing"; else $status_of_aproved = $input['status'];

//if ($input['modo'] == 0) $tmp="modo numero 0";
//syslog(LOG_WARNING,$tmp);

    	$valid['modo'] = $modo;
		$valid['login'] = esc_textarea($input['login']);
		$valid['password'] = esc_textarea($input['password']);
		$valid['finger'] = esc_textarea($input['finger']);
		$valid['cancel_order'] = $cancel; //esc_textarea($input['cancel_order']);
		$valid['status_of_aproved'] = $status_of_aproved;
		$valid['debug'] = esc_textarea($input['debug']);

    	return $valid;
 	} // end of validate

	/**
	 * Inserir o hook para validação da tela de admin setup
	 */
	public function cs_total_options_update()
	{
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	/**
	 * Add custom columns in order grid of woocommerce
	 */
	public function cs_total_add_grid_columns($columns)
	{
		$reordered_columns = array();
		
		// Inserting columns to a specific location
		foreach($columns as $key => $column) {
			$reordered_columns[$key] = $column;
			if ($key ==  'order_status') {
				// Inserting after "Status" column
				$reordered_columns['cs_status'] = __('ClearSale Status', $this->plugin_name);
			}
		}
		return $reordered_columns;
	} // end of cs_total_add_grid_columns

	/**
	 * Adding custom fields meta data for each new column
	 * https://stackoverflow.com/questions/49919915/add-a-woocommerce-orders-list-column-and-value
	 * add_action( 'manage_shop_order_posts_custom_column' , 'cs_add_grid_content', 20, 2 );
	 * 
	 * @param	$column	string - nome da coluna do grid
	 * @param	$post_id
	*/
	public function cs_total_add_grid_content($column, $post_id)
	{
    	switch ($column) {
    	    case 'cs_status' :
				// Get custom post meta data
				//https://codex.wordpress.org/Function_Reference/get_comments
				//https://www.szabogabor.net/how-to-get-orders-comments-in-woocommerce/
				$args = array(
					//'status' => 'hold',
					//'number' => '1', se for só a última ele deixa em branco se não for a da ClearSale
					'post_id' => $post_id, // use post_id, not post_ID
					'approved' => 'approve',
					'type' => ''
				);

				remove_filter('comments_clauses', array('WC_Comments', 'exclude_order_comments'));
				$comments = get_comments($args); // ele lista em ordem descendente de data, achando a 1ra da CS paramos, pois será a última.
				add_filter('comments_clauses', array('WC_Comments', 'exclude_order_comments'));

				foreach($comments as $comment) :
					//echo($comment->comment_author);
					//Status da ClearSale: FRD - pegar apenas FRD  Ou assim-> ClearSale status: FRD score: 99.99
					$apt = stristr($comment->comment_content, "clearsale:");
					$status = substr($apt, 11 ,3);
					if ($status == "NVO") $status="Em Análise";
					//if ($status == "EAP") $status="Esperando Aprovação do Pagamento";
					// echo Clearsale_Total_Status::statusShortNames($status); break;
					// antes { echo $status; break; }
					if ($status) {
						Clearsale_Total_Status::statusShortNames($status); break;
					}
					else { // vazio
						$apt = stristr($comment->comment_content, "status:");
						$status = substr($apt, 8 ,3);
						if ($status == "NVO") $status="Em Análise";
						//if ($status == "EAP") $status="Esperando Aprovação do Pagamento";
						if ($status) {
							echo Clearsale_Total_Status::statusShortNames($status); break;
						}
					}
				endforeach;
            break;
		}
	} // end of cs_total_add_grid_content


} // end of class
