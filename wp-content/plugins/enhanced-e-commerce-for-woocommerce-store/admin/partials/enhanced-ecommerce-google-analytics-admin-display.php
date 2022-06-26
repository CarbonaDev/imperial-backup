<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       tatvic.com
 * @since      1.0.0
 *
 * @package    Enhanced_Ecommerce_Google_Analytics
 * @subpackage Enhanced_Ecommerce_Google_Analytics/admin/partials
 *
 */
if (!defined('ABSPATH')) {
    exit;
}
class TVC_Tabs {
  protected $TVC_Admin_Helper;
  protected $site_url;
  protected $google_detail;
  public function __construct() {
      $this->TVC_Admin_Helper = new TVC_Admin_Helper();
      $this->site_url = "admin.php?page=conversios";
      $this->google_detail = $this->TVC_Admin_Helper->get_ee_options_data(); 
      $this->create_tabs();
  }    
  protected function info_htnml($validation){
      if($validation == true){
          return '<img src="'.ENHANCAD_PLUGIN_URL.'/admin/images/config-success.svg" alt="configuration  success" class="config-success">';
      }else{
          return '<img src="'.ENHANCAD_PLUGIN_URL.'/admin/images/exclaimation.png" alt="configuration  success" class="config-fail">';
      }
  }
  /* add active tab class */
  protected function is_active_tabs($page=""){
      if($page!="" && isset($_GET['page']) && $_GET['page'] == $page){
          return "active";
      }
      return ;
  }
  
  protected function create_tabs(){
    $setting_status = $this->TVC_Admin_Helper->check_setting_status();
    $googleDetail = [];
    $plan_id = 1;
    if(isset($this->google_detail['setting'])){
      if ($this->google_detail['setting']) {
        $googleDetail = $this->google_detail['setting'];
        if(isset($googleDetail->plan_id) && !in_array($googleDetail->plan_id, array("1"))){
          $plan_id = $googleDetail->plan_id;
        }
      }
    }
    ?>
      <ul class="nav nav-pills nav-justified">
        <li class="nav-item">       
          <div class="tvc-tooltip <?php echo $this->is_active_tabs('conversios'); ?>">
                <?php if(isset($setting_status['google_analytic']) && $setting_status['google_analytic'] == false ){?>
                <?php echo (isset($setting_status['google_analytic_msg'])?'<span class="tvc-tooltiptext tvc-tooltip-right">'.$setting_status['google_analytic_msg'].'</span>':"") ?>
                <?php }?>
            <div class="nav-item nav-link <?php echo $this->is_active_tabs('conversios'); ?>">
                <?php if(isset($setting_status['google_analytic']) ){
                    echo $this->info_htnml($setting_status['google_analytic']);
                }?>
                <a  href="<?php echo $this->site_url; ?>"  class=""> Google Analytics</a>
            </div>
          </div>
        </li>
        <li class="nav-item">
            <div class="tvc-tooltip <?php echo $this->is_active_tabs('conversios-google-ads'); ?>">
                <?php if(isset($setting_status['google_ads']) && $setting_status['google_ads'] == false ){?>
                <?php echo (isset($setting_status['google_ads'])?'<span class="tvc-tooltiptext tvc-tooltip-right">'.$setting_status['google_ads_msg'].'</span>':"") ?>
                <?php } ?>
                <div class="nav-link <?php echo $this->is_active_tabs('conversios-google-ads'); ?>">
                <?php if(isset($setting_status['google_ads']) ){
                    echo $this->info_htnml($setting_status['google_ads']);
                }?>
            <a href="<?php echo $this->site_url.'-google-ads'; ?>" class="">Google Ads</a>
           </div>
        </li>
        <?php
        /*$sub_tab_active="";
        if(isset($_GET['tab']) && $_GET['tab'] == 'conversios-google-shopping-feed'){
            $sub_tab_active="active";
        }*/
        ?>
        <li class="nav-item">
            <div class="tvc-tooltip <?php echo $this->is_active_tabs('conversios-google-shopping-feed'); ?>">
                <?php if(isset($setting_status['google_shopping']) && $setting_status['google_shopping'] == false ){
                  echo (isset($setting_status['google_shopping_msg'])?'<span class="tvc-tooltiptext tvc-tooltip-right">'.$setting_status['google_shopping_msg'].'</span>':"");
                } ?>
                <div class="nav-link <?php echo $this->is_active_tabs('conversios-google-shopping-feed'); ?>">
                <?php if(isset($setting_status['google_shopping']) ){
                  echo $this->info_htnml($setting_status['google_shopping']); 
                } ?>
                <a href="<?php echo $this->site_url.'-google-shopping-feed'; ?>" class="">Google Shopping</a>
            </div>
        </li>
        <?php if($plan_id ==1){?>
        <li class="nav-item tvc-new-freevspro-nav-item">
          <div class="nav-link <?php echo $this->is_active_tabs('conversios-pricings'); ?>">
            <span class="tvc-new-freevspro">New</span>
            <a href="<?php echo $this->site_url.'-pricings'; ?>" class="">Free Vs Pro</a>
          </div>
        </li>
      <?php } ?>
        <li class="tvc-help-need">          
          For any query, reach out to us at <a href="tel:+1 (415) 968-6313">+1 (415) 968-6313</a>
        </li>
      </ul>     
    <?php
  }
} ?>