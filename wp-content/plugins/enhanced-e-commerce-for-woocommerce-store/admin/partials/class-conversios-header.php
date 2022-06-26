<?php
/**
 * @since      4.0.2
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if ( ! class_exists( 'Conversios_Header' ) ) {
	class Conversios_Header extends TVC_Admin_Helper{
		protected $site_url;
		protected $conversios_site_url;
		protected $subscription_data;
		protected $plan_id=1;
		public function __construct( ){
			$this->site_url = "admin.php?page=";
			$this->conversios_site_url = $this->get_conversios_site_url();
			$this->subscription_data = $this->get_user_subscription_data();
			if(isset($this->subscription_data->plan_id) && !in_array($this->subscription_data->plan_id, array("1"))){
			    $this->plan_id = $this->subscription_data->plan_id;
			}
			add_action('add_conversios_header',array($this, 'before_start_header'));
			add_action('add_conversios_header',array($this, 'header_notices'));
			add_action('add_conversios_header',array($this, 'conversios_header'));
			add_action('add_conversios_header',array($this, 'header_menu'));
		}	
		
		/**
     * before start header section
     *
     * @since    4.1.4
     */
		public function before_start_header(){
			?>
			<div class="bodyrightpart conversios-body-part">
			<?php
		}
		/**
     * header notices section
     *
     * @since    4.1.4
     */
		public function header_notices(){
			if($this->plan_id == 1){
				?>
				<!--- Promotion box start -->
			  <div class="promobandtop">
			    <div class="container-fluid">
			      <div class="row">
			          <div class="promoleft">
		              <div class="promobandmsg">
		                  Level up your game by getting detail insights on every products. Make the informed decision for your next campaign.
		              </div>
			          </div>
			          <div class="promoright">
	                <div class="prmoupgrdbtn">
	                    <a target="_blank" href="<?php echo $this->get_pro_plan_site().'?utm_source=EE+Plugin+User+Interface&utm_medium=Top+Bar+upgrading+to+pro&utm_campaign=Upsell+at+Conversios'; ?>" class="upgradebtn">Upgrade</a>
	                </div>
			          </div>
			      </div>
			    </div>
			  </div>
			  <!--- Promotion box end -->
				<?php
			}
			echo $this->call_tvc_site_verified_and_domain_claim();	
		}
		/**
     * header section
     *
     * @since    4.1.4
     */
		public function conversios_header(){
			$plan_name = "Free Plan";
			if(isset($this->subscription_data->plan_name) && !in_array($this->subscription_data->plan_id, array("1"))){
        $plan_name = $this->subscription_data->plan_name;
      }
      $ee_msg_list = $this->get_ee_msg_nofification_list();

      $active_count = 0;
      if(!empty($ee_msg_list)){
        $html = "";
        foreach ($ee_msg_list as $key => $value) {
          if( isset($value["active"]) && $value["active"] == 1 ){
            $active_count++;
            $m_date = isset($value["date"])?"<span class=\"tvc-msg_date\">".$value["date"]."</span>":"";
            $m_title = isset($value["title"])?"<h4 class=\"tvc-msg_title\">".$value["title"]."</h4>":"";
            $m_html = isset($value["html"])?"<span class=\"tvc-msg_text\">".base64_decode($value["html"])."</span>":"";
            $target = (isset($value["link_type"]) && $value["link_type"] == "external")?"target=\"_blank\"":"";
            $m_link = isset($value["link"])?"<a ".$target." href=".$value["link"]." class=\"tvc-notification-button is-secondary\">".$value["link_title"]."</a>":"";
              
            $html.="<li>
              <section class=\"tvc-msg plain\">
                <div class=\"tvc-msg_wrapper\">
                  <div class=\"tvc-msg_content\">".$m_title.$m_html."</div>
                  <div class=\"tvc-msg_actions\">
                    ".$m_link."
                    <div class=\"tvc-dropdown\">
                      <button type=\"button\" data-id=".$key." class=\"tvc-notification-button is-tertiary is-dismissible-notification\">Dismiss</button>
                    </div>
                    ".$m_date."
                  </div>
                </div>
              </section>
            </li>";
          }
        }
      }
			?>
			<!-- header start -->
		  <header class="header">
	      <div class="hedertop">
          <div class="row align-items-center">
            <div class="hdrtpleft">
              <div class="brandlogo">
                  <a target="_blank" href="<?php echo $this->conversios_site_url; ?>"><img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/logo.png'; ?>" alt="" /></a>
              </div>
              <div class="hdrcntcbx">
                  For any query, contact us at <span>+1 (415) 968-6313</span>
              </div>
            </div>
            <div class="hdrtpright">
              <div class="hustleplanbtn">
                  <a href="<?php echo $this->site_url.'conversios-account'; ?>"><button class="cvrs-btn greenbtn"><?php echo $plan_name; ?></button></a>
              </div>
              <?php /*
              <div class="hdrnotiwrp">
                  <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/notification-icon.png'; ?>" alt="" />
                  <div class="notialrt"><?php echo $active_count; ?></div>
              </div>
              */ ?>
            </div>
            <div class="hdrcntcbx mblhdrcntcbx">
                For any query, contact us at <span>+1 (415) 968-6313</span>
            </div>
          </div>
	      </div>
		  </header>
		  <!-- header end -->
			<?php
		}

		/* add active tab class */
	  protected function is_active_menu($page=""){
	      if($page!="" && isset($_GET['page']) && $_GET['page'] == $page){
	          return "active";
	      }
	      return ;
	  }
	  public function conversios_menu_list(){
	  	//slug => arra();
	  	$conversios_menu_list = array(
	  		'conversios' => array(
	  			'title'=>'Dashboard',
	  			'icon'=>ENHANCAD_PLUGIN_URL.'/admin/images/conversios-menu.png',
	  			'acitve_icon'=>ENHANCAD_PLUGIN_URL.'/admin/images/active-conversios-menu.png'
	  			),
	  		'conversios-google-analytics'=>array('title'=>'Google Analytics'),
	  		'conversios-google-ads'=>array('title'=>'Google Ads'),
	  		'conversios-google-shopping-feed'=>array('title'=>'Google Shopping')
	  		 );
	  	if($this->plan_id == 1){
	  		$conversios_menu_list['conversios-pricings'] = array('title'=>'Free Vs Pro','icon'=>'');
	  	}
	  	return apply_filters('conversios_menu_list', $conversios_menu_list, $conversios_menu_list);
	  }
		/**
     * header menu section
     *
     * @since    4.1.4
     */
		public function header_menu(){
			$menu_list = $this->conversios_menu_list();
			if(!empty($menu_list)){
				?>
				<div class="navinfowrap">
      	  <div class="navinfotopnav">
            <ul>
						<?php
						foreach ($menu_list as $key => $value) {
							if(isset($value['title']) && $value['title']){
								$is_active = $this->is_active_menu($key);
								$icon = "";
								if(!isset($value['icon']) && !isset($value['acitve_icon'])){
									$icon = ENHANCAD_PLUGIN_URL.'/admin/images/'.$key.'-menu.png';					
									if($is_active == 'active'){
										$icon = ENHANCAD_PLUGIN_URL.'/admin/images/'.$is_active.'-'.$key.'-menu.png';
									}
								}else{
									$icon = (isset($value['icon']))?$value['icon']:((isset($value['acitve_icon']))?$value['acitve_icon']:"");
									if($is_active == 'active' && isset($value['acitve_icon'])){
										$icon =$value['acitve_icon'];
									}
								}
								?>
								<li class="<?php echo $is_active;  ?>">
		              <a href="<?php echo $this->site_url.$key; ?>">
		              	<?php if($icon != ""){?>
		                <span class="navinfoicon"><img src="<?php echo $icon; ?>" /></span>
		              <?php } ?>
		                <span class="navinfonavtext"><?php echo $value['title']; ?></span>
		              </a>
			          </li>
								<?php	
							}
						}?>
						</ul>
					</div>
				</div>	
				<?php
			}
			
		}

	}
}
new Conversios_Header();