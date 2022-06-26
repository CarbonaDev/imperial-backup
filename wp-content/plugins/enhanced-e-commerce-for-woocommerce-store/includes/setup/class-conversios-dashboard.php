<?php
/**
 * @since      4.1.4
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if ( ! class_exists( 'Conversios_Dashboard' ) ) {
	class Conversios_Dashboard {
		protected $screen;
    protected $TVC_Admin_Helper;
    protected $CustomApi;
    protected $subscription_id;
    protected $ga_traking_type;
    protected $ga3_property_id;
    protected $ga3_ua_analytic_account_id;
    protected $ga3_view_id;
    protected $ga_currency;
    protected $ga_currency_symbols;
    protected $ga4_measurement_id;
    protected $ga4_property_id;
    protected $subscription_data;
    protected $plan_id=1;
    protected $is_need_to_update_api_data_wp_db = false;
    protected $pro_plan_site;
    protected $report_data;
    protected $notice;
    protected $google_ads_id;

    protected $connect_url;
    protected $g_mail;
    protected $is_refresh_token_expire;
		public function __construct( ){
      
      $this->TVC_Admin_Helper = new TVC_Admin_Helper();
      $this->CustomApi = new CustomApi();
      $this->connect_url =  $this->TVC_Admin_Helper->get_custom_connect_url(admin_url().'admin.php?page=conversios');
      $this->subscription_id = $this->TVC_Admin_Helper->get_subscriptionId();
      // update API data to DB while expired token
      
      if ( isset($_GET['subscription_id']) && $_GET['subscription_id'] == $this->subscription_id){
        if ( isset($_GET['g_mail']) && $_GET['g_mail']){
          $this->TVC_Admin_Helper->update_subscription_details_api_to_db();
        }
      } else if(isset($_GET['subscription_id']) && $_GET['subscription_id']){
        $this->notice = "You tried signing in with different email. Please try again by signing it with the email id that you used to set up the plugin earlier. <a href=\'".$this->TVC_Admin_Helper->get_conversios_site_url()."\' target=\'_blank\'>Reach out to us</a> if you have any difficulty.";
      }
      $this->is_refresh_token_expire = $this->TVC_Admin_Helper->is_refresh_token_expire();
      $this->subscription_data = $this->TVC_Admin_Helper->get_user_subscription_data();
      $this->pro_plan_site = $this->TVC_Admin_Helper->get_pro_plan_site().'?utm_source=EE+Plugin+User+Interface&utm_medium=dashboard&utm_campaign=Upsell+at+Conversios';
      if(isset($this->subscription_data->plan_id) && !in_array($this->subscription_data->plan_id, array("1"))){
        $this->plan_id = $this->subscription_data->plan_id;
      }
      if(isset($this->subscription_data->google_ads_id) && $this->subscription_data->google_ads_id != ""){
        $this->google_ads_id = $this->subscription_data->google_ads_id;
      }

      if( $this->subscription_id != "" ){
        $this->g_mail = get_option('ee_customer_gmail');
        $this->ga_traking_type = $this->subscription_data->tracking_option; // UA,GA4,BOTH
        $this->ga3_property_id = $this->subscription_data->property_id; // GA3
        $this->ga3_ua_analytic_account_id = $this->subscription_data->ua_analytic_account_id;
        if($this->is_refresh_token_expire == false){
          $this->set_ga3_view_id_and_ga3_currency();
        }
        $this->ga4_measurement_id = $this->subscription_data->measurement_id; //GA4 ID
      }else{
        wp_redirect("admin.php?page=conversios_onboarding");
        exit;
      }     
      
			$this->includes();
			$this->screen = get_current_screen();
      $this->init();
      $this->load_html();
		}

    public function includes() {
      if (!class_exists('CustomApi.php')) {
        require_once(ENHANCAD_PLUGIN_DIR . 'includes/setup/CustomApi.php');
      }   
    }

		public function init(){
      
    }
    
    public function set_ga3_view_id_and_ga3_currency(){
      //$this->view_id = get_option('ee_ga_view_id');
      if(isset($this->subscription_data->view_id) && isset($this->subscription_data->analytics_currency) && $this->subscription_data->view_id!="" && $this->subscription_data->analytics_currency!=""){
        $this->ga3_view_id = $this->subscription_data->view_id;
        $this->ga_currency = $this->subscription_data->analytics_currency;
        $this->ga_currency_symbols = $this->TVC_Admin_Helper->get_currency_symbols($this->ga_currency);
        
      }else{
        $data = array(
          "subscription_id"=>$this->subscription_id,
          "property_id"=>$this->ga3_property_id,
          "ua_analytic_account_id"=>$this->ga3_ua_analytic_account_id
        );
        $api_rs = $this->CustomApi->get_analytics_viewid_currency($data);        
        if (isset($api_rs->error) && $api_rs->error == '') {
          if(isset($api_rs->data) && $api_rs->data != ""){
            $data = json_decode($api_rs->data);
            $this->ga3_view_id = $data->view_id;
            $this->ga_currency =$data->analytics_currency;
            $this->ga_currency_symbols = $this->TVC_Admin_Helper->get_currency_symbols($this->ga_currency);
            $this->is_need_to_update_api_data_wp_db = true;
          }
        }
      }
    }
    public function load_html(){
      do_action('conversios_start_html_'.$_GET['page']);
      $this->current_html();
      $this->current_js();
      do_action('conversios_end_html_'.$_GET['page']);
    }    
		
    /**
     * Page custom js code
     *
     * @since    4.1.4
     */
    public function current_js(){
    ?>
    <script>
    $( document ).ready(function() {
      /**
        * daterage script
        **/
      var notice='<?php echo $this->notice; ?>';
      if(notice != ""){
        tvc_helper.tvc_alert("error","Email error",notice);
      }
      var plan_id = '<?php echo $this->plan_id; ?>';
      var g_mail = '<?php echo $this->g_mail; ?>';
      var is_refresh_token_expire = '<?php echo $this->is_refresh_token_expire; ?>';
      is_refresh_token_expire = (is_refresh_token_expire == "")?false:true;
      console.log(is_refresh_token_expire);
      //$(function() {
        var start = moment().subtract(30, 'days');
        var end = moment();
        function cb(start, end) {
            var start_date = start.format('DD/MM/YYYY') || 0,
            end_date = end.format('DD/MM/YYYY') || 0;
            $('span.daterangearea').html(start_date + ' - ' + end_date);

            /*var date_range = $.trim($(".report_range_val").text()).split('-');

            var start_date = $.trim(date_range[0].replace(/\//g,"-")) || 0,
            end_date = $.trim(date_range[1].replace(/\//g,"-")) || 0;*/
            var data = {
              action:'get_google_analytics_reports',      
              subscription_id:'<?php echo $this->subscription_id; ?>',
              plan_id:plan_id,
              ga_traking_type:'<?php echo $this->ga_traking_type; ?>',
              view_id :'<?php echo $this->ga3_view_id; ?>',
              ga4_property_id:'<?php echo $this->ga4_property_id; ?>',
              ga_currency :'<?php echo $this->ga_currency; ?>',
              plugin_url:'<?php echo ENHANCAD_PLUGIN_URL; ?>',
              start_date :$.trim(start_date.replace(/\//g,"-")),
              end_date :$.trim(end_date.replace(/\//g,"-")),
              g_mail:g_mail,
              google_ads_id:'<?php echo $this->google_ads_id; ?>',
              conversios_nonce:'<?php echo wp_create_nonce( 'conversios_nonce' ); ?>'
            };
            // Call API
            if(notice == "" && is_refresh_token_expire == false){
              tvc_helper.get_google_analytics_reports(data);
            }

            if(notice == "" && is_refresh_token_expire == true && g_mail != ""){ 
              tvc_helper.tvc_alert("error","","It seems the token to access your Google Analytics account is expired. Sign in with "+g_mail+" again to reactivate the token. <span class='google_connect_url'>Click here..</span>");
            }else if(notice == "" && is_refresh_token_expire == true ){
              tvc_helper.tvc_alert("error","","It seems the token to access your Google Analytics account is expired. Sign in with the connected email again to reactivate the token. <span class='google_connect_url'>Click here..</span>");
            }
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
      //});
      //upgrds plan popup
      $(".upgrdsbrs-btn").on( "click", function() {
          $('.upgradsbscrptn-pp').addClass('showpopup');
          $('body').addClass('scrlnone');
      });
      $('body').click(function(evt){ 
        if($(evt.target).closest('.upgrdsbrs-btn, .upgradsbscrptnpp-cntr').length){
          return;
        }        
        $('.upgradsbscrptn-pp').removeClass('showpopup');
        $('body').removeClass('scrlnone');
      });
      $(".clsbtntrgr").on( "click", function() {
          $(this).closest('.pp-modal').removeClass('showpopup');
          $('body').removeClass('scrlnone');
      });
      //upcoming_featur popup
       $(".upcoming-featur-btn").on( "click", function() {
          $('.upcoming_featur-btn-pp').addClass('showpopup');
          $('body').addClass('scrlnone');
      });
      $('body').click(function(evt){   
        if($(evt.target).closest('.upcoming-featur-btn, .upgradsbscrptnpp-cntr').length){
          return;
        }        
        $('.upcoming_featur-btn-pp').removeClass('showpopup');
        $('body').removeClass('scrlnone');
      });
      /**
        * Custom js code for API call
        **/
      
      //var start_date = moment().subtract(5, 'months').format('YYYY-MM-DD');
      //var end_date = moment().subtract(1, 'days').format('YYYY-MM-DD');
      

      $(".prmoclsbtn").on( "click", function() {
        $(this).parents('.promobandtop').fadeOut()
      });      
      
      /**
        * table responcive
        **/
        $('.mbl-table').basictable({
          breakpoint: 768
        });
        
        /**
         * Convesios custom script
         */
        //Step-0
        $("#tvc_popup_box").on( "click",'span.google_connect_url', function() {
          console.log("call");
          const w =600; const h=650;
          const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
          const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

          const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
          const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

          const systemZoom = width / window.screen.availWidth;
          const left = (width - w) / 2 / systemZoom + dualScreenLeft;
          const top = (height - h) / 2 / systemZoom + dualScreenTop;
          var url ='<?php echo $this->connect_url; ?>';
          url = url.replace(/&amp;/g, '&');
          const newWindow = window.open(url, "newwindow", config=      `scrollbars=yes,
            width=${w / systemZoom}, 
            height=${h / systemZoom}, 
            top=${top}, 
            left=${left},toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no
            `);
          if (window.focus) newWindow.focus();
        });

    });
    </script>
    <?php
    }
    protected function add_upgrdsbrs_btn_calss($featur_name){
      if($this->plan_id == 1){
        return "upgrdsbrs-btn";
      }else if($featur_name != ""){
        $upcoming_featur  = array('download_pdf','schedule_email');
        if(in_array($featur_name, $upcoming_featur)){
          return "upcoming-featur-btn";
        }
      }
    }

    /**
     * Main html code
     *
     * @since    4.1.4
     */
	  public function current_html(){
	  ?>
    <div class="dashbrdpage-wrap">
      <div class="dflex align-items-center mt24 dshbrdtoparea">
        <div class="dashtp-left">
          <button class="dashtpleft-btn <?php echo $this->add_upgrdsbrs_btn_calss('download_pdf'); ?>"><img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/download-icon.png'; ?>" alt="" />Download PDF</button>
          <button class="dashtpleft-btn <?php echo $this->add_upgrdsbrs_btn_calss('schedule_email'); ?>"><img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/clock-icon.png'; ?>" alt="" />Schedule Email</button>
        </div>
        <div class="dashtp-right">

          <?php /*
          <div class="dshtprightselect">
              <select>
                  <option>All</option>
                  <option>All</option>
                  <option>All</option>
              </select>
          </div>*/ ?>
          <?php if($this->plan_id != 1){?>
          <div id="reportrange" class="dshtpdaterange" >
              <div class="dateclndicn">
                  <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/claendar-icon.png'; ?>" alt="" />
              </div> 
              <span class="daterangearea report_range_val"></span>
              <div class="careticn"><img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/caret-down.png'; ?>" alt="" /></div>
          </div>
        <?php } else{ ?>
          <div class="dshtpdaterange <?php echo $this->add_upgrdsbrs_btn_calss('download_pdf'); ?>">
              <div class="dateclndicn">
                  <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/claendar-icon.png'; ?>" alt="" />
              </div> 
              <span class="daterangearea report_range_val"></span>
              <div class="careticn"><img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/caret-down.png'; ?>" alt="" /></div>
          </div>
        <?php }?>

        </div>
      </div>
      <?php if($this->ga_traking_type == "GA4"){?>
      <div class="temp_note"><p>The reporting dashboard feature is only available for Google Analytics 3 properties currently. We are working on Google Analytics 4 dashboard, we will update you once it is live.</p></div>
    <?php } ?>
      <!--- dashboard summary section start -->
      <div class="wht-rnd-shdwbx mt24 dashsmry-wrap">
        <div class="dashsmry-item">
          <div class="dashsmrybx" id="s1_transactionsPerSession">
            <div class="dshsmrycattxt dash-smry-title">Conversion Rate</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
              <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/green-up.png'; ?>" alt="" />
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_transactionRevenue">
            <div class="dshsmrycattxt dash-smry-title">Revenue </div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx mblsmry3bx" id="s1_transactions">
            <div class="dshsmrycattxt dash-smry-title">Total Transactions </div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx mblsmry3bx" id="s1_revenuePerTransaction">
            <div class="dshsmrycattxt dash-smry-title">Avg. Order Value</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx mblsmry3bx flwdthmblbx" id="s1_productAddsToCart">
            <div class="dshsmrycattxt dash-smry-title">Added to Cart</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
        </div>
        <div class="dashsmry-item">
          <div class="dashsmrybx" id="s1_productRemovesFromCart">
            <div class="dshsmrycattxt dash-smry-title">Removed from Cart</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_sessions">
            <div class="dshsmrycattxt dash-smry-title">Sessions</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_users">
            <div class="dshsmrycattxt dash-smry-title">Total Users</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_newUsers">
            <div class="dshsmrycattxt dash-smry-title">New Users</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_productDetailViews">
            <div class="dshsmrycattxt dash-smry-title">Product Views</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          
        </div>
        <?php /*
        <div class="dashsmry-item">
          <div class="dashsmrybx" id="s1_transactionShipping">
            <div class="dshsmrycattxt dash-smry-title">Shipping</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
          <div class="dashsmrybx" id="s1_transactionTax">
            <div class="dshsmrycattxt dash-smry-title">TAX</div>
            <div class="dshsmrylrgtxt dash-smry-value">-</div>
            <div class="updownsmry dash-smry-compare-val">
                %
            </div>
            <div class="dshsmryprdtxt">From Previous Period</div>
          </div>
        </div> */?>
      </div>
      <!--- dashboard summary section end -->

      <!--- dashboard ecommerce cahrt section start -->
      <div class="mt24 dshchrtwrp ecomfunnchart">
        <div class="row">
          <?php if($this->plan_id != 1){?>
          <div class="col50">
            <div class="chartbx ecomfunnchrtbx ecom-funn-chrt-bx">
              <div class="chartcntnbx">
                <h5>Ecommerce Conversion Funnel</h5>
                <div class="chartarea">
                   <canvas id="ecomfunchart" width="400" height="300"></canvas>
                </div>
                <hr>
                <div class="ecomchartinfo">
                  <div class="ecomchrtinfoflex">
                    <div class="ecomchartinfoitem">
                        <div class="ecomchartinfolabel">Sessions</div>
                        <div class="chartpercarrow conversion_s1"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                        <div class="ecomchartinfolabel">Product View</div>
                        <div class="chartpercarrow conversion_s2"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                        <div class="ecomchartinfolabel">Add to Cart</div>
                        <div class="chartpercarrow conversion_s3"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                        <div class="ecomchartinfolabel">Checkouts</div>
                        <div class="chartpercarrow conversion_s4"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                        <div class="ecomchartinfolabel">Order Confirmation</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php }else{ ?>
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Ecommerce Conversion Funnel</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/ecom-chart.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Conversion Funnel</h5>
                    <p>This Report will help you visualize drop offs at each stage of your shopping funnel starting from home page to product page, cart page to checkout page and to final order confirmation page. Find out the major drop offs at each stage and take informed data driven decisions to increase the conversions and better marketing ROI.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>

          <?php if($this->plan_id != 1){?>
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx ecom-checkout-funn-chrt-bx">
                <div class="chartcntnbx">
                  <h5>Ecommerce Checkout Funnel</h5>
                  <div class="chartarea">
                     <canvas id="ecomcheckoutfunchart" width="400" height="300"></canvas>
                  </div>
                  <hr>
                <div class="ecomchartinfo ecomcheckoutfunchartinfo">
                  <div class="ecomchrtinfoflex">
                    <div class="ecomchartinfoitem">
                      <div class="ecomchartinfolabel">Checkout Step 1</div>
                      <div class="chartpercarrow checkoutfunn_s1"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                      <div class="ecomchartinfolabel">Checkout Step 2</div>
                      <div class="chartpercarrow checkoutfunn_s2"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                      <div class="ecomchartinfolabel">Checkout Step 3</div>
                      <div class="chartpercarrow checkoutfunn_s3"></div>
                    </div>
                    <div class="ecomchartinfoitem">
                      <div class="ecomchartinfolabel">Purchase</div>
                    </div>
                    
                  </div>
                </div>

                </div>
              </div>
            </div>
          <?php }else{ ?>
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Checkout Funnel</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/ecom-chart.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Checkout Funnel</h5>
                    <p>This Report will help you in finding out the performance of your checkout page and leakages at each checkout step. Identify the small areas of improvements and fix them for smooth customer experience on your ecommerce site.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          <?php  } ?>
          
        </div>
      </div>
      <!--- dashboard ecommerce cahrt section over -->

      <!--- Product Performance section start -->
      <?php if($this->plan_id != 1){?>
      <div class="mt24 whiteroundedbx dshreport-sec">
        <div class="row dsh-reprttop">
          <div class="dshrprttp-left">
            <h4>Product Performance Report</h4>
            <a href="#" class="viewallbtn <?php echo $this->add_upgrdsbrs_btn_calss('download_pdf'); ?>">View all <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/blue-right-arrow.png'; ?>" alt="" /></a>
          </div>
        </div>
        <div class="dashtablewrp product_performance_report" id="product_performance_report">
          <table class="dshreporttble mbl-table" >
              <thead>
                  <tr>
                      <th class="prdnm-cell">Product Name</th>
                      <th>Views</th>
                      <th>Added to Cart</th>
                      <th>Orders</th>
                      <th>Qty</th>
                      <th>Revenue (<?php echo $this->ga_currency_symbols; ?>)</th>
                      <th>Avg Price (<?php echo $this->ga_currency_symbols; ?>)</th>
                      <th>Refund Amount (<?php echo $this->ga_currency_symbols; ?>)</th>
                      <th>Cart to details (%)</th>
                      <th>Buy to details (%)</th>
                </tr>
              </thead>
              <tbody>                                    
              </tbody>
          </table>
        </div>
      </div>
      <?php }else{ ?>
        <div class="mt24 whiteroundedbx dshreport-sec">
          <div class="row dsh-reprttop">
            <div class="col">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Product Performance Report</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Product Performance Report</h5>
                    <p>This report will help you understand how products in your store are performing and based on it you can take informed merchandising decision to further increase your revenue.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php  } ?>
      <!--- Product Performance section over -->

      <!--- Source Performance Report section start -->
      <?php if($this->plan_id != 1){?>
      <div class="mt24 whiteroundedbx dshreport-sec">
          <div class="row dsh-reprttop">
              <div class="dshrprttp-left">
                <h4>Source/Medium Performance Report</h4>
                <a href="" class="viewallbtn <?php echo $this->add_upgrdsbrs_btn_calss('download_pdf'); ?>">View all <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/blue-right-arrow.png'; ?>" alt="" /></a>
              </div>
          </div>
          <div class="dashtablewrp medium_performance_report" id="medium_performance_report">
              <table class="dshreporttble mbl-table" >
                  <thead>
                      <tr>
                          <th class="prdnm-cell">Source/Medium</th>
                          <th>Conversion (%)</th>
                          <th>Revenue (<?php echo $this->ga_currency_symbols; ?>)</th>
                          <th>Total transactions</th>
                          <th>Avg Order value (<?php echo $this->ga_currency_symbols; ?>)</th>
                          <th>Added to carts</th>
                          <th>removed from cart</th>
                          <th>Product views</th>
                          <th>Users</th>
                          <th>Sessions</th>
                    </tr>
                  </thead>
                  <tbody>
                      
                  </tbody>
              </table>
          </div>
      </div>
      <?php }else{ ?>
        <div class="mt24 whiteroundedbx dshreport-sec">
          <div class="row dsh-reprttop">
            <div class="col">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Source/Medium Performance Report</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Source/Medium Performance Report</h5>
                    <p>Find out the performance of each of your traffic channels. You can access which campaigns or channels are attributing sales, add to carts, product views etc. You can also see your shopping and checkout behavior funnels for each of the channels and take informed decisions of managing your ad spends for each channel.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php  } ?>
      <!--- Source Performance Report section over -->


      <!--- Shopping and Google Ads Performance section start -->
      <?php /* if($this->plan_id != 1){?>
      <div class="mt24 whiteroundedbx ggladsperfom-sec">
          <h4>Shopping and Google Ads Performance</h4>
          <div class="row">
            <div class="col50">
              <div class="chartbx ggladschrtbx daily-clicks-bx">
                <div class="chartcntnbx">
                  <h5>Clicks</h5>
                  <div class="chartarea">
                     <canvas id="dailyClicks" width="400" height="300" class="chartcntainer"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col50">
              <div class="chartbx ggladschrtbx daily-cost-bx">
                <div class="chartcntnbx">
                  <h5>Cost</h5>
                  <div class="chartarea">
                     <canvas id="dailyCost" width="400" height="300" class="chartcntainer"></canvas>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col50">
              <div class="chartbx ggladschrtbx daily-conversions-bx">
                <div class="chartcntnbx">
                  <h5>Conversions</h5>
                  <div class="chartarea">
                     <canvas id="dailyConversions" width="400" height="300" class="chartcntainer"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col50">
              <div class="chartbx ggladschrtbx daily-sales-bx">
                <div class="chartcntnbx">
                  <h5>Sales</h5>
                  <div class="chartarea">
                     <canvas id="dailySales" width="400" height="300" class="chartcntainer"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div> 
      <?php }else{ ?>
        <div class="mt24 whiteroundedbx ggladsperfom-sec">
          <h4>Shopping and Google Ads Performance</h4>
          <div class="row">
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Google Ads Clicks Performance</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Google Ads Clicks Performance</h5>
                    <p>This report will help you .</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Google Ads Cost Performance</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Google Ads Cost Performance</h5>
                    <p>This report will help you understand how products in your store are performing and based on it you can take informed merchandising decision to further increase your revenue.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Google Ads Conversions Performance</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Google Ads Conversions Performance</h5>
                    <p>This report will help you </p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col50">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Google Ads Sales Performance</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Google Ads Sales Performance</h5>
                    <p>This report will help you.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php } */ ?>
      <!--- Shopping and Google Ads Performance section start -->

      <!--- Compaign section start -->
      <?php if($this->plan_id != 1){?>
      <div class="mt24 whiteroundedbx dshreport-sec">
          <div class="row dsh-reprttop">
              <div class="dshrprttp-left">
                <h4>Campaign Performance</h4>
                <a href="" class="viewallbtn <?php echo $this->add_upgrdsbrs_btn_calss('download_pdf'); ?>">View all <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/blue-right-arrow.png'; ?>" alt="" /></a>
              </div>
          </div>
          <div class="dashtablewrp campaign_performance_report" id="campaign_performance_report">
               <?php if($this->google_ads_id == ""){
                  ?>
                  <p>Set up your google ads account from <a href="<?php echo $this->TVC_Admin_Helper->get_onboarding_page_url(); ?>">here</a> in order to access Campaign performance data.</p>
                  <?php
                } ?> 
              <table class="dshreporttble mbl-table" >
                  <thead>
                      <tr>
                        <th class="prdnm-cell">Campaign Name</th>
                        <th>Daily Budget</th>
                        <th>Status</th>
                        <th>Clicks</th>
                        <th>Cost</th>
                        <th>Conversions</th>
                        <th>Sales</th>
                    </tr>
                  </thead>
                  <tbody>  
                                 
                  </tbody>
              </table>

          </div>
      </div>
      <?php }else{ ?>
        <div class="mt24 whiteroundedbx dshreport-sec">
          <div class="row dsh-reprttop">
            <div class="col">
              <div class="chartbx ecomfunnchrtbx">
                <div class="chartcntnbx prochrtftr">
                  <h5>Campaign Performance</h5>
                  <div class="chartarea">
                     <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/table-data.jpg'; ?>" alt="" />
                  </div>
                </div>
                <div class="prochrtovrbox">
                  <div class="prochrtcntn">
                    <div class="prochrttop">
                      <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/lock-orange.png'; ?>" alt="" />
                      Locked 
                    </div>
                    <h5>Campaign Performance</h5>
                    <p>Access your campaign performance data to know how are they performing and take actionable decisions to increase your marketing ROI.</p>
                    <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php  } ?>
      <!--- Source Performance Report section over -->

      <!-- UPGRADE SUBSCRIPTION -->
      <div id="upgradsbscrptn" class="pp-modal whitepopup upgradsbscrptn-pp">
        <div class="sycnprdct-ppcnt">
          <div class="ppwhitebg pp-content upgradsbscrptnpp-cntr">
            <div class="ppclsbtn absltpsclsbtn clsbtntrgr">
              <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/close-white.png'; ?>" alt="">
            </div>
            <div class="upgradsbscrptnpp-hdr">
              <h5>Upgrade to Pro..!!</h5>
            </div>
            <div class="ppmodal-body">
              <p>This feature is only available in the paid plan. Please upgrade to get the full range of reports and more.</p>
              <div class="ppupgrdbtnwrap">
                <a class="blueupgrdbtn" href="<?php echo $this->pro_plan_site; ?>" target="_blank">Upgrade Now</a>
              </div>
            </div>              
          </div>
        </div>
      </div>
      <!--  Upcoming featur -->
      <div id="upcoming_featur" class="pp-modal whitepopup upcoming_featur-btn-pp">
        <div class="sycnprdct-ppcnt">
          <div class="ppwhitebg pp-content upgradsbscrptnpp-cntr">
            <div class="ppclsbtn absltpsclsbtn clsbtntrgr">
              <img src="<?php echo ENHANCAD_PLUGIN_URL.'/admin/images/close-white.png'; ?>" alt="">
            </div>
            <div class="upgradsbscrptnpp-hdr">
              <h5>Upcoming..!!</h5>
            </div>
            <div class="ppmodal-body">
              <p>We are currently working on this feature and we will reach out to you once this is live.</p>
              <p>We aim to give you a capability to schedule the reports directly in your inbox whenever you want.</p>              
            </div>              
          </div>
        </div>
      </div>

    </div>
    <?php	  	
	  }
	}
}
new Conversios_Dashboard();