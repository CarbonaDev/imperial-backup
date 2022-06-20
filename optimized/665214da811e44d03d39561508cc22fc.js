!function(y,c,i,n){var t=function(t){var a=this;a.$form=t,a.$attributeFields=t.find(".variations select"),a.$singleVariation=t.find(".single_variation"),a.$singleVariationWrap=t.find(".single_variation_wrap"),a.$resetVariations=t.find(".reset_variations"),a.$product=t.closest(".product"),a.variationData=t.data("product_variations"),a.useAjax=!1===a.variationData,a.xhr=!1,a.loading=!0,a.$singleVariationWrap.show(),a.$form.off(".wc-variation-form"),a.getChosenAttributes=a.getChosenAttributes.bind(a),a.findMatchingVariations=a.findMatchingVariations.bind(a),a.isMatch=a.isMatch.bind(a),a.toggleResetLink=a.toggleResetLink.bind(a),t.on("click.wc-variation-form",".reset_variations",{variationForm:a},a.onReset),t.on("reload_product_variations",{variationForm:a},a.onReload),t.on("hide_variation",{variationForm:a},a.onHide),t.on("show_variation",{variationForm:a},a.onShow),t.on("click",".single_add_to_cart_button",{variationForm:a},a.onAddToCart),t.on("reset_data",{variationForm:a},a.onResetDisplayedVariation),t.on("reset_image",{variationForm:a},a.onResetImage),t.on("change.wc-variation-form",".variations select",{variationForm:a},a.onChange),t.on("found_variation.wc-variation-form",{variationForm:a},a.onFoundVariation),t.on("check_variations.wc-variation-form",{variationForm:a},a.onFindVariation),t.on("update_variation_values.wc-variation-form",{variationForm:a},a.onUpdateAttributes),setTimeout(function(){t.trigger("check_variations"),t.trigger("wc_variation_form",a),a.loading=!1},100)};t.prototype.onReset=function(t){t.preventDefault(),t.data.variationForm.$attributeFields.val("").trigger("change"),t.data.variationForm.$form.trigger("reset_data")},t.prototype.onReload=function(t){t=t.data.variationForm;t.variationData=t.$form.data("product_variations"),t.useAjax=!1===t.variationData,t.$form.trigger("check_variations")},t.prototype.onHide=function(t){t.preventDefault(),t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("wc-variation-is-unavailable").addClass("disabled wc-variation-selection-needed"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-enabled").addClass("woocommerce-variation-add-to-cart-disabled")},t.prototype.onShow=function(t,a,i){t.preventDefault(),i?(t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("disabled wc-variation-selection-needed wc-variation-is-unavailable"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-disabled").addClass("woocommerce-variation-add-to-cart-enabled")):(t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("wc-variation-selection-needed").addClass("disabled wc-variation-is-unavailable"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-enabled").addClass("woocommerce-variation-add-to-cart-disabled")),wp.mediaelement&&t.data.variationForm.$form.find(".wp-audio-shortcode, .wp-video-shortcode").not(".mejs-container").filter(function(){return!y(this).parent().hasClass("mejs-mediaelement")}).mediaelementplayer(wp.mediaelement.settings)},t.prototype.onAddToCart=function(t){y(this).is(".disabled")&&(t.preventDefault(),y(this).is(".wc-variation-is-unavailable")?c.alert(wc_add_to_cart_variation_params.i18n_unavailable_text):y(this).is(".wc-variation-selection-needed")&&c.alert(wc_add_to_cart_variation_params.i18n_make_a_selection_text))},t.prototype.onResetDisplayedVariation=function(t){t=t.data.variationForm;t.$product.find(".product_meta").find(".sku").wc_reset_content(),t.$product.find(".product_weight, .woocommerce-product-attributes-item--weight .woocommerce-product-attributes-item__value").wc_reset_content(),t.$product.find(".product_dimensions, .woocommerce-product-attributes-item--dimensions .woocommerce-product-attributes-item__value").wc_reset_content(),t.$form.trigger("reset_image"),t.$singleVariation.slideUp(200).trigger("hide_variation")},t.prototype.onResetImage=function(t){t.data.variationForm.$form.wc_variations_image_update(!1)},t.prototype.onFindVariation=function(t,a){var i=t.data.variationForm,e=void 0!==a?a:i.getChosenAttributes(),a=e.data;e.count&&e.count===e.chosenCount?i.useAjax?(i.xhr&&i.xhr.abort(),i.$form.block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),a.product_id=parseInt(i.$form.data("product_id"),10),a.custom_data=i.$form.data("custom_data"),i.xhr=y.ajax({url:wc_add_to_cart_variation_params.wc_ajax_url.toString().replace("%%endpoint%%","get_variation"),type:"POST",data:a,success:function(t){t?i.$form.trigger("found_variation",[t]):(i.$form.trigger("reset_data"),e.chosenCount=0,i.loading||(i.$form.find(".single_variation").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),i.$form.find(".wc-no-matching-variations").slideDown(200)))},complete:function(){i.$form.unblock()}})):(i.$form.trigger("update_variation_values"),(a=i.findMatchingVariations(i.variationData,a).shift())?i.$form.trigger("found_variation",[a]):(i.$form.trigger("reset_data"),e.chosenCount=0,i.loading||(i.$form.find(".single_variation").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),i.$form.find(".wc-no-matching-variations").slideDown(200)))):(i.$form.trigger("update_variation_values"),i.$form.trigger("reset_data")),i.toggleResetLink(0<e.chosenCount)},t.prototype.onFoundVariation=function(t,a){var i=t.data.variationForm,e=i.$product.find(".product_meta").find(".sku"),r=i.$product.find(".product_weight, .woocommerce-product-attributes-item--weight .woocommerce-product-attributes-item__value"),o=i.$product.find(".product_dimensions, .woocommerce-product-attributes-item--dimensions .woocommerce-product-attributes-item__value"),n=i.$singleVariationWrap.find(".quantity"),s=!0,c=!1,t="";a.sku?e.wc_set_content(a.sku):e.wc_reset_content(),a.weight?r.wc_set_content(a.weight_html):r.wc_reset_content(),a.dimensions?o.wc_set_content(y.parseHTML(a.dimensions_html)[0].data):o.wc_reset_content(),i.$form.wc_variations_image_update(a),a.variation_is_visible?(c=_("variation-template"),a.variation_id):c=_("unavailable-variation-template"),t=(t=(t=c({variation:a})).replace("/*<![CDATA[*/","")).replace("/*]]>*/",""),i.$singleVariation.html(t),i.$form.find('input[name="variation_id"], input.variation_id').val(a.variation_id).trigger("change"),"yes"===a.is_sold_individually?(n.find("input.qty").val("1").attr("min","1").attr("max","").trigger("change"),n.hide()):(c=n.find("input.qty"),t=parseFloat(c.val()),t=isNaN(t)||(t=t>parseFloat(a.max_qty)?a.max_qty:t)<parseFloat(a.min_qty)?a.min_qty:t,c.attr("min",a.min_qty).attr("max",a.max_qty).val(t).trigger("change"),n.show()),a.is_purchasable&&a.is_in_stock&&a.variation_is_visible||(s=!1),(i.$singleVariation.text().trim()?i.$singleVariation.slideDown(200):i.$singleVariation.show()).trigger("show_variation",[a,s])},t.prototype.onChange=function(t){t=t.data.variationForm;t.$form.find('input[name="variation_id"], input.variation_id').val("").trigger("change"),t.$form.find(".wc-no-matching-variations").remove(),t.useAjax||t.$form.trigger("woocommerce_variation_select_change"),t.$form.trigger("check_variations"),t.$form.trigger("woocommerce_variation_has_changed")},t.prototype.addSlashes=function(t){return t=(t=t.replace(/'/g,"\\'")).replace(/"/g,'\\"')},t.prototype.onUpdateAttributes=function(t){var b=t.data.variationForm,$=b.getChosenAttributes().data;b.useAjax||(b.$attributeFields.each(function(t,a){var i=y(a),e=i.data("attribute_name")||i.attr("name"),r=y(a).data("show_option_none"),o=":gt(0)",a=0,n=y("<select/>"),s=i.val()||"",c=!0;i.data("attribute_html")||((_=i.clone()).find("option").prop("disabled attached",!1).prop("selected",!1),i.data("attribute_options",_.find("option"+o).get()),i.data("attribute_html",_.html())),n.html(i.data("attribute_html"));var _=y.extend(!0,{},$);_[e]="";var d,m=b.findMatchingVariations(b.variationData,_);for(d in m)if("undefined"!=typeof m[d]){var l,v=m[d].attributes;for(l in v)if(v.hasOwnProperty(l)){var g=v[l],u="";if(l===e)if(m[d].variation_is_active&&(u="enabled"),g){g=y("<div/>").html(g).text();var f=n.find("option");if(f.length)for(var h=0,p=f.length;h<p;h++){var w=y(f[h]);if(g===w.val()){w.addClass("attached "+u);break}}}else n.find("option:gt(0)").addClass("attached "+u)}}a=n.find("option.attached").length,s&&(c=!1,0!==a&&n.find("option.attached.enabled").each(function(){var t=y(this).val();if(s===t)return!(c=!0)})),0<a&&s&&c&&"no"===r&&(n.find("option:first").remove(),o=""),n.find("option"+o+":not(.attached)").remove(),i.html(n.html()),i.find("option"+o+":not(.enabled)").prop("disabled",!0),s?c?i.val(s):i.val("").trigger("change"):i.val("")}),b.$form.trigger("woocommerce_update_variation_values"))},t.prototype.getChosenAttributes=function(){var i={},e=0,r=0;return this.$attributeFields.each(function(){var t=y(this).data("attribute_name")||y(this).attr("name"),a=y(this).val()||"";0<a.length&&r++,e++,i[t]=a}),{count:e,chosenCount:r,data:i}},t.prototype.findMatchingVariations=function(t,a){for(var i=[],e=0;e<t.length;e++){var r=t[e];this.isMatch(r.attributes,a)&&i.push(r)}return i},t.prototype.isMatch=function(t,a){var i,e,r,o=!0;for(i in t){t.hasOwnProperty(i)&&(e=t[i],r=a[i],e!==n&&r!==n&&0!==e.length&&0!==r.length&&e!==r&&(o=!1))}return o},t.prototype.toggleResetLink=function(t){t?"hidden"===this.$resetVariations.css("visibility")&&this.$resetVariations.css("visibility","visible").hide().fadeIn():this.$resetVariations.css("visibility","hidden")},y.fn.wc_variation_form=function(){return new t(this),this},y.fn.wc_set_content=function(t){n===this.attr("data-o_content")&&this.attr("data-o_content",this.text()),this.text(t)},y.fn.wc_reset_content=function(){n!==this.attr("data-o_content")&&this.text(this.attr("data-o_content"))},y.fn.wc_set_variation_attr=function(t,a){n===this.attr("data-o_"+t)&&this.attr("data-o_"+t,this.attr(t)?this.attr(t):""),!1===a?this.removeAttr(t):this.attr(t,a)},y.fn.wc_reset_variation_attr=function(t){n!==this.attr("data-o_"+t)&&this.attr(t,this.attr("data-o_"+t))},y.fn.wc_maybe_trigger_slide_position_reset=function(t){var a=y(this),i=a.closest(".product").find(".images"),e=!1,t=t&&t.image_id?t.image_id:"";a.attr("current-image")!==t&&(e=!0),a.attr("current-image",t),e&&i.trigger("woocommerce_gallery_reset_slide_position")},y.fn.wc_variations_image_update=function(t){var a=this,i=a.closest(".product"),e=i.find(".images"),r=i.find(".flex-control-nav"),o=r.find("li:eq(0) img"),n=e.find(".woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder").eq(0),s=n.find(".wp-post-image"),i=n.find("a").eq(0);if(t&&t.image&&t.image.src&&1<t.image.src.length){0<r.find('li img[data-o_src="'+t.image.gallery_thumbnail_src+'"]').length&&a.wc_variations_image_reset();r=r.find('li img[src="'+t.image.gallery_thumbnail_src+'"]');if(0<r.length)return r.trigger("click"),a.attr("current-image",t.image_id),void c.setTimeout(function(){y(c).trigger("resize"),e.trigger("woocommerce_gallery_init_zoom")},20);s.wc_set_variation_attr("src",t.image.src),s.wc_set_variation_attr("height",t.image.src_h),s.wc_set_variation_attr("width",t.image.src_w),s.wc_set_variation_attr("srcset",t.image.srcset),s.wc_set_variation_attr("sizes",t.image.sizes),s.wc_set_variation_attr("title",t.image.title),s.wc_set_variation_attr("data-caption",t.image.caption),s.wc_set_variation_attr("alt",t.image.alt),s.wc_set_variation_attr("data-src",t.image.full_src),s.wc_set_variation_attr("data-large_image",t.image.full_src),s.wc_set_variation_attr("data-large_image_width",t.image.full_src_w),s.wc_set_variation_attr("data-large_image_height",t.image.full_src_h),n.wc_set_variation_attr("data-thumb",t.image.src),o.wc_set_variation_attr("src",t.image.gallery_thumbnail_src),i.wc_set_variation_attr("href",t.image.full_src)}else a.wc_variations_image_reset();c.setTimeout(function(){y(c).trigger("resize"),a.wc_maybe_trigger_slide_position_reset(t),e.trigger("woocommerce_gallery_init_zoom")},20)},y.fn.wc_variations_image_reset=function(){var t=this.closest(".product"),a=t.find(".images"),i=t.find(".flex-control-nav").find("li:eq(0) img"),e=a.find(".woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder").eq(0),t=e.find(".wp-post-image"),a=e.find("a").eq(0);t.wc_reset_variation_attr("src"),t.wc_reset_variation_attr("width"),t.wc_reset_variation_attr("height"),t.wc_reset_variation_attr("srcset"),t.wc_reset_variation_attr("sizes"),t.wc_reset_variation_attr("title"),t.wc_reset_variation_attr("data-caption"),t.wc_reset_variation_attr("alt"),t.wc_reset_variation_attr("data-src"),t.wc_reset_variation_attr("data-large_image"),t.wc_reset_variation_attr("data-large_image_width"),t.wc_reset_variation_attr("data-large_image_height"),e.wc_reset_variation_attr("data-thumb"),i.wc_reset_variation_attr("src"),a.wc_reset_variation_attr("href")},y(function(){"undefined"!=typeof wc_add_to_cart_variation_params&&y(".variations_form").each(function(){y(this).wc_variation_form()})});var _=function(t){var a=i.getElementById("tmpl-"+t).textContent;return/<#\s?data\./.test(a)||/{{{?\s?data\.(?!variation\.).+}}}?/.test(a)||/{{{?\s?data\.variation\.[\w-]*[^\s}]/.test(a)?wp.template(t):function(t){var r=t.variation||{};return a.replace(/({{{?)\s?data\.variation\.([\w-]*)\s?(}}}?)/g,function(t,a,i,e){if(a.length!==e.length)return"";i=r[i]||"";return 2===a.length?c.escape(i):i})}}}(jQuery,window,document);
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('C M=(9($){2r.3r(2r.3x,{5B:9(x,t,b,c,d){z((t/=d/2)<1)E c/2*t*t*t*t+b;E-c/2*((t-=2)*t*t*t-2)+b},});C v=$(1h);C w=v.13();v.1F(9(){w=v.13();M.2Y(A)});$.3Z.5A=9(){C c=$(7),3m;c.K(9(){3m=c.1M().1c});9 1p(){C b=v.44();c.K(9(){C a=$(7),1c=a.1M().1c,13=a.39(A);z(1c+13<b||1c>b+w||c.y(\'D-5z\')!==A)E;c.O(\'7M\',"50% "+2o.1H((3m-b)*0.4)+"1g")})}v.18(\'5y 1F\',1p).1b(\'1p\')};$.3Z.2E=9(d){C f={1v:\'7i\',1M:1j,2n:9(a){}};$.3r(f,d);C g=7,w=$(1h).13();7.4c=9(){C c=((8P.67.6c().1N(\'7g\')!=-1)?1h:\'1l\'),3f=$(c).44(),5x=(3f+w);g.K(9(){C a=$(7);z(a.1S(f.1v)&&f.1v!=\'\'){E}C b=2o.1H(a.1M().1c)+f.1M,5w=b+(a.13());z((b<5x)&&(5w>3f)&&7.8K!=A){a.W(f.1v);f.2n(a)}})};$(1h).5y(7.4c);7.4c();$(1h).1F(9(e){w=e.68.5v})};$(3R).1D(9($){M.1K($)});E{7j:0,7p:0,1z:$(\'1z\'),1K:9(){$(\'L[y-D-5z="A"]\').K(9(){$(7).5A()});7.36();7.17();7.1C.1K();z(1h.2C.1y.1N(\'#\')>-1){$(\'a[1y="#\'+1h.2C.1y.1B(\'#\')[1]+\'"]\').1b(\'Y\')}$(\'.6I\').2t(\'.5u\').3H();$(\'.D-3J-7o\').18(\'Y\',9(){$(7).1m().1m().7t(\'3M\',9(){$(7).3O()})});7.5s();7.5r.2k();7.46.2k();7.5q();7.5p();7.5o();7.2j.1K();7.2u.5n();7.5h();7.1V();7.5d();7.57();7.56();7.Z();7.2Y(A)},2J:9(b){2M(9(a){M.2j.1p(a);M.2u.1p(a);M.46.2k(a);z($(\'.55\').1s>0){55.2J(a)}},1j,b)},3s:9(a){C d=3R;z(d.5O===\'65\'){z(a==\'13\')E d.1z.54;J E d.1z.53}J{z(a==\'13\')E d.52.54;J E d.52.53}},2Y:9(c){C d=3R;[].6N.6T(d.51(\'L[y-D-4Z]\'),9(a){C b=d.51(\'.7h\')[0],1w;z(1i b===\'R\')E;1w=b.4Y();a.1q.19=(-1w.19)+\'1g\';z(a.14(\'y-D-4Z\')==\'8z\'){a.1q.4X=1w.19+\'1g\';a.1q.8B=(M.3s(\'V\')-1w.V-1w.19)+\'1g\';a.1q.V=1w.V+\'1g\'}J{a.1q.4X=\'8I\';a.1q.V=M.3s(\'V\')+\'1g\'}z(a.2I!==1W&&a.2I.8Q==\'5G\'){z(a.2I.5J==\'M.2Y(A);\'){a.5L.5M(a.2I)}}})},5s:9(b){$(\'.5N\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});C a=$(7);z(a.y(\'5Y\')==\'63\'){a.Y(9(){a.B(\'4b\').O("4W-34","6g")});a.6u(9(){a.B(\'4b\').O("4W-34","6A")})}a.B(\'.3J\').18(\'Y\',9(){a.B(\'.4V\').4Q("4O");a.B(\'.3a\').7c(\'3M\')});a.B(\'.3a\').18(\'Y\',9(){a.B(\'.4V\').4Q("4O");a.B(\'.3a\').7f(\'3M\')})})},36:9(d){$(\'.3b\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});C c=$(7).y(\'2p-G\')!==R?($(7).y(\'2p-G\')-1):0;z($(7).y(\'3e\')==A)c=\'7l\';$(7).B(\'>F.1e>1f.1d>a, >F.1e>1f.1d>.Q-36-8m-8y\').2H(\'Y\').18(\'Y\',9(e){C a=$(7).1n(\'.3b\'),L=$(7).1n(\'.1e\'),3o=(A===a.y(\'3o\'))?A:H,3e=(A===a.y(\'3e\'))?A:H,4I=L.B(\'>1f.1d\').1S(\'Q-1k-G\'),8N=H;z(3o===H){z(!L.B(\'>1f.1d\').1S(\'Q-1k-G\')){a.B(\'>.1e>.1Z\').3t();a.B(\'>.1e>1f.1d\').U(\'Q-1k-G\');a.B(\'>.1e.D-L-G\').U(\'D-L-G\');L.B(\'>.1Z\').2g().4F(\'4E\',9(){$(7).O({13:\'\'})});L.B(\'>1f.1d\').W(\'Q-1k-G\');L.W(\'D-L-G\')}J{a.B(\'>.1e>.1Z\').3t();a.B(\'>.1e>1f.1d\').U(\'Q-1k-G\');a.B(\'>.1e>.D-L-G\').U(\'D-L-G\');L.U(\'D-L-G\')}}J{z(L.B(\'>1f.1d\').1S(\'Q-1k-G\')){L.B(\'>.1Z\').2g().3t();L.B(\'>1f.1d\').U(\'Q-1k-G\');L.U(\'D-L-G\')}J{L.B(\'>.1Z\').2g().4F(\'4E\',9(){$(7).O({13:\'\'})});L.B(\'>1f.1d\').W(\'Q-1k-G\');L.W(\'D-L-G\')}}z(4I!=L.B(\'>1f.1d\').1S(\'Q-1k-G\'))M.2J(L.B(\'>.1Z\'));e.1I();C b=$(7).1n(\'.1e\');b=b.1m().B(\'>.1e\').4B(b.2f(0));$(7).1n(\'.3b\').y({\'2p-G\':(b+1)})}).2c(c).1b(\'Y\')})},17:9(d){$(\'.28 > .4A\').K(9(b){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});C c=$(7),2v=c.1m(\'.28.6b\'),2w=(\'P\'===2v.y(\'6n-18-4z\'))?\'4z\':\'Y\',4w=(\'P\'===2v.y(\'6F-6G\'))?A:H,4v=2B(2v.y(\'2p-G\'))-1;$(7).B(\'>.Q-17-3S>3T\').2H(\'Y\').18(\'Y\',9(e){e.1I()}).2H(2w).18(2w,9(e){z($(7).1S(\'Q-17-G\')){e.1I();E}C a=$(7).1n(\'.7a,.Q-17-3S\').B(\'>3T\'),b=a.4B(7),3U=$(7).1n(\'.4A\').B(\'>.7d\'),3V=3U.2c(b);a.U(\'Q-17-G\');$(7).W(\'Q-17-G\');3U.U(\'Q-17-1z-G\').U(\'D-L-G\');3V.W(\'Q-17-1z-G\').W(\'D-L-G\');z(4w===A)3V.O({\'27\':0}).Z({27:1});e.1I();$(7).1n(\'.28\').y({\'2p-G\':(b+1)})}).2c(4v).1b(2w)});$(\'.28.D-17-3Y\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});$(7).B(\'.D-17-3Y-3S 3T\').K(9(a){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});$(7).18(\'Y\',a,9(e){$(7).1m().B(\'.D-2D-G\').U(\'D-2D-G\');$(7).W(\'D-2D-G\');4t.7k(e.y);$(7).1n(\'.D-17-3Y\').B(\'.S-45\').1b(\'S.1Q\',e.y);e.1I();$(7).1n(\'.28\').y({\'G\':e.y})});z(a===0)$(7).W(\'D-2D-G\')})});M.3n()},4s:9(){$(\'.4s\').K(9(a){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});$(7).7y({X:1j,7N:7S})})},1C:{1K:9(){$(\'.8k, .8l\').K(9(){C a=$(7),4a,2L;z(a.y(\'D-1r-1U\')){4a=a.y(\'D-1r-1U\');2L=M.1C.4r(4a);z(2L){a.B(\'.2O-1r-1U\').3O();M.1C.2t(a,2L)}}J{a.B(\'.2O-1r-1U\').3O()}})},4r:9(a){z(\'R\'===1i(a)){E H}C b=a.8D(/(?:8F?:\\/{2})?(?:w{3}\\.)?8J(?:4q)?\\.(?:8L|4q)(?:\\/8M\\?v=|\\/)([^\\s&]+)/);z(1W!==b){E b[1]}E H},2t:9(c,d,f){z(38===R)E;z(\'R\'===1i(38.4p)){f=\'R\'===1i(f)?0:f;z(f>1j){4t.8T(\'8U 5D 5E 5F 2R 5H 5I\');E}2M(9(){M.1C.2t(c,d,f++)},1j);E}C g,$4o=c.5K(\'<F N="2O-1r-1U"><F N="4n"></F></F>\').B(\'.4n\'),16=c.y(\'D-1r-16\'),26={5P:d,5Q:3,5V:1,5W:1,30:1,5Z:0,60:0,61:0,62:1};16=16?4m.64(\'{"\'+16.25(/&/g,\'","\').25(/=/g,\'":"\')+\'"}\',9(a,b){E a===""?b:66(b)}):{};z(1i 16==\'3j\')26=$.3r(26,16);g=1Y 38.4p($4o[0],{V:\'1j%\',13:\'1j%\',69:d,26:26,34:{6a:9(e){z(c.y(\'D-1r-4l\')==\'P\')e.4k.4l().6d(A);e.4k.8W()}}});M.1C.1F(c);$(1h).18(\'1F\',9(){M.1C.1F(c)})},1F:9(a){C b=1.77,22,20,2x,2y,2e=a.6H(),24=a.5v();z((2e/24)<b){22=24*b;20=24}J{22=2e;20=2e*(1/b)}2x=-2o.1H((22-2e)/2)+\'1g\';2y=-2o.1H((20-24)/2)+\'1g\';22+=\'1g\';20+=\'1g\';a.B(\'.2O-1r-1U 4b\').O({6L:\'3u%\',2x:2x,2y:2y,V:22,13:20})}},6P:{2J:9(a){M.1V()}},5r:{2k:9(){$(\'.6R\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});C c=$(7),3v=c.B(\'2A\'),1E=3v.1s,1D=0;z(1E>0){3v.K(9(a){C b=1Y 4j();b.4i=9(){1D++;z(1D==1E){1Y 3z(c.2f(0),{3A:\'.1O-1L\',3D:\'.1O-1L\',})}};b.2F=$(7).2G(\'2F\')})}J{1Y 3z(c.2f(0),{3A:\'.1O-1L\',3D:\'.1O-1L\',})}})},},46:{2k:9(){$(\'.7m\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});z((\'P\'===$(7).y(\'7n\'))){C c=$(7).B(\'2A\'),1E=c.1s,1D=0,29=$(7);$(7).y({\'1E\':1E});c.K(9(a){C b=1Y 4j();b.4i=9(){1D++;z(1D==1E){1Y 3z(29.2f(0),{3A:\'.2a-1L\',3D:\'.2a-1L\',})}};b.2F=$(7).2G(\'2F\')})}});M.1V()},},57:9(){$(\'.7q .7r\').K(9(){z($(7).y(\'I\')!==A)$(7).y({\'I\':A});J E;C a=$(7).y(\'X\')?$(7).y(\'X\'):\'7s\';1h.M.3I(a,$(7).B(\'2A\').4h())})},3I:9(a,b){z(b===R)E;b.1m().B(\'.G\').U(\'G\');b.W(\'G\');z(b.2K().1s>0)b=b.2K();J b=b.1m().B(\'2A\').4h();C c=2M(1h.M.3I,a,a,b)},5q:9(u){$(\'.D-45-7G\').K(9(f){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});C g=$(7).y(\'S-i-16\'),2d=(\'P\'===g.30)?A:H,3N=(g.X!==R)?g.X:8,23=(\'P\'===g.1J)?A:H,1o=(\'P\'===g.1x)?A:H,1t=g.1a,1R=g.1A,2V=(\'P\'===g.4g)?A:H,4f=(g.4e!==R)?g.4e:5,41=(\'P\'===g.42)?A:H,43=(\'P\'===g.8O)?A:H,1G=H,21=H,1X=H;z(g.31>0){21=[8V,g.31]}z(g.32>0){1X=[4T,g.32]}C h=9(){};C j=9(){};C k=9(){};z(A===2V||A===43||A===41)1G=A;z(2d)2d=2B(3N)*3u;z(A===43){C l=3N;C m,$1T,$2X,2W,3X,2b;h=9(a){$2X=a;n();o()};C n=9(){m=$("<F>",{N:"5R"});$1T=$("<F>",{N:"1T"});m.5S($1T).5T($2X)};C o=9(){2b=0;2W=H;3X=5U(p,10)};C p=9(){z(2W===H){2b+=1/l;$1T.O({V:2b+"%"});z(2b>=1j){$2X.1b(\'S.2K\')}}};k=9(){2W=A};j=9(){5X(3X);o()}}z(A!==41){$(7).1u({3h:2d,1J:23,1x:1o,2U:1t,2S:1t,2Q:1G,2P:2V,1A:1R,35:H,48:H,40:21,4u:21,3Q:1X,3P:h,4x:j,4y:k})}J{C q=$(7);C r=q.2K(\'.D-6e\');C s=9(a){C b=7.6f;$(r).B(".S-2a").U("3E").2c(b).W("3E");z($(r).y("1u")!==R){t(b)}};r.18("Y",".S-2a",9(e){e.1I();C a=$(7).y("6h");q.1b("S.1Q",a)});C t=9(a){C b=r.y("1u").S.6i;C c=a;C d=H;6j(C i 6k b){z(c===b[i]){d=A}}z(d===H){z(c>b[b.1s-1]){r.1b("S.1Q",c-b.1s+2)}J{z(c-1===-1){c=0}r.1b("S.1Q",c)}}J z(c===b[b.1s-1]){r.1b("S.1Q",b[1])}J z(c===b[0]){r.1b("S.1Q",c-1)}};q.1u({3h:2d,2Q:1G,2U:1t,2S:1t,1J:23,1x:1o,6l:s,4C:6m,2P:2V,3P:h,4x:j,4y:k});r.1u({1A:4f,35:[4D,15],48:[6o,12],40:[6p,6],3Q:[4T,5],1x:1o,4C:1j,3P:9(a){a.B(".S-2a").2c(0).W("3E")}})}});M.1V()},6q:9(b){$.1O(1c.6r,{\'6s\':1c.6t,\'2Z\':\'6v\',\'16\':1c.D.6w.6x.6y(4m.6z(b))},9(a){})},5p:9(a){M.3n(\'.D-S-1O-45\')},5d:9(){$(\'.5u\').K(9(){z($(7).y(\'D-I\')!==A)$(7).y({\'D-I\':A});J E;$(7).3H()})},5o:9(){$(\'.D-3y-6B\').K(9(b){C c=$(7).y(\'3y\');$(7).3y(c.6C,9(a){$(7).1l(a.6D(c.6E))})})},2j:{1K:9(){$(\'.4G\').K(9(b){$(7).2E({2n:9(a){M.2j.2R(a)},1v:\'D-4H-I\'})})},2R:9(d){z(d.1m(\'F\').V()<10)E 0;C e=d.y(\'3q\'),4J=(\'P\'===d.y(\'6J\'))?\'1H\':\'6K\',4K=d.y(\'6M\'),4L=d.y(\'6O\'),4M=d.y(\'6Q\'),4N=d.y(\'6S\');z(\'P\'===4M){e=d.1m(\'F\').V();d.y(\'3q\',e)}C f=d.B(\'.2h\').V()+d.B(\'.2h:6U\').V();C g=d.B(\'.2h\').13();d.6V({6W:4K,6X:4L,6Y:4J,3x:\'6Z\',70:9(a,b,c){$(7.29).B(\'.2h\').71(2o.1H(c));$(7.29).B(\'.2h\').72();$(7.29).O({\'V\':e,\'13\':e})},73:0,74:4N,3q:e,})},1p:9(a){a.B(\'.4G\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});M.2j.2R($(7))})}},2u:{5n:9(){$(\'.75\').K(9(){$(7).2E({2n:9(a){M.2u.1p(a)},1v:\'D-76-I\'})})},1p:9(c){$(\'.D-4P-1T .D-Q-4P\').K(9(){z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});$(7).O({V:\'5%\'}).2g().Z({V:7.14(\'y-79\')+\'%\'},{37:2B(7.14(\'y-1a\')),3x:\'5B\',7b:9(a,b){z(b.4R/b.4S>0.3)7.7e(\'Q-4d\')[0].1q.27=b.4R/b.4S}}).B(\'.Q-4d\').O({27:0})})}},5h:9(){$(\'.4U\').K(9(){z(7.14(\'y-T\')===1W||7.14(\'y-T\')===R||7.14(\'y-T\')===\'\')E;C b=$(7),2T={2Z:\'4U\',T:$(7).y(\'T\')};7.3W(\'y-T\');$.3L({3G:3F.3C,3B:\'3w\',3p:\'3k\',y:2T,3i:9(a){b.B(\'58\').1l(a.1l).59(a.7u)}})});$(\'.7v\').K(9(b){z(7.14(\'y-T\')===1W||7.14(\'y-T\')===R||7.14(\'y-T\')===\'\')E;C c=$(7),2T={2Z:\'7w\',T:$(7).y(\'T\')};7.3W(\'y-T\');$.3L({3G:3F.3C,3B:\'3w\',3p:\'3k\',y:2T,3i:9(a){c.B(\'58\').1l(a.1l)}})});$(\'.7x\').K(9(d){z(7.14(\'y-T\')===1W||7.14(\'y-T\')===R||7.14(\'y-T\')===\'\')E;C e=$(7),5a={2Z:\'7z\',T:$(7).y(\'T\')};7.3W(\'y-T\');C f=$(7).y(\'7A\');$.3L({3G:3F.3C,3B:\'3w\',3p:\'3k\',y:5a,3i:9(a){C b=e.y(\'7B\');e.B(\'.5b\').1l(a.1l);e.B(\'.5b\').59(\'<F N="7C">\'+a.7D+\'</F>\');C c=(\'P\'===f.7E)?A:H,1o=(\'P\'===f.7F)?A:H,5c=(\'P\'===f.7H)?A:H;z(2===b){e.B(\'.D-7I-S\').1u({1J:c,1x:1o,2U:7J,2S:7K,2Q:A,1A:1,2P:5c})}}})})},3n:9(){z(1i $().1u!=\'9\')E;$(\'[y-S-16]\').K(9(a){C b=$(7).y(\'S-16\');z(1i b!==\'3j\')E;z($(7).y(\'I\')===A)E;J $(7).y({\'I\':A});$(7).2G({\'y-S-16\':1W});C c=(\'P\'===b.30)?A:H,23=(\'P\'===b.1J)?A:H,1o=(\'P\'===b.1x)?A:H,1t=(b.1a!==R)?b.1a:7L,1R=(b.1A!==R)?b.1A:1,21=(b.31!==R)?b.31:1,1X=(b.32!==R)?b.32:1,3g=(\'P\'===b.4g)?A:H,5e=(\'P\'===b.42)?A:H,1G=H;z(3g===A){1G=A;1R=1}$(7).1u({3h:c,1J:23,1x:1o,42:5e,2U:1t,2S:1t,2Q:1G,2P:3g,1A:1R,7O:H,35:[4D,1R],48:[7P,21],40:[7Q,1X],4u:H,3Q:[7R,1X],})});M.1V()},1V:9(){z(1i($.5f)==\'3j\'){$("a.D-7T-7U:7V(.D-5g-I)").W(\'D-5g-I\').2H(\'Y\').5f({7W:\'7X\',7Y:A,7Z:A,27:0.85,81:\'82\',83:H,84:\' / \',86:A,30:A,87:0,88:H,89:\'<F N="8a">                   <F N="8b">                     <F N="8c">                     <F N="8d">                       <F N="8e">                         <F N="8f D-8g"></F>                         <F N="8h">                           <F N="8i">                             <a N="8j" 1y="#"><i N="3d-5i-5j"></i></a>                             <a N="8n" 1y="#"><i N="3d-5i-19"></i></a>                           </F>                           <F 8o="8p"></F>                           <F N="8q">                            <F N="8r">&8s;</F>                             <F N="8t">                               <p N="8u">0 / 0</p>                             </F>                             <p N="8v"></p>                             <a N="8w" 1y="#"><i N="3d-3J"></i></a>                           </F>                         </F>                       </F>                     </F>                     </F>                   </F>                 </F>                 <F N="8x"></F>\'})}},56:9(){$(\'a[1y^="#"]\').18(\'Y\',9(e){z(2C.5k.25(/^\\//,\'\')==7.5k.25(/^\\//,\'\')&&2C.5l==7.5l&&7.5m.1N(\'#!\')===0){C a=$(7.5m.25(\'!\',\'\'));z(a.1s){$(\'1l,1z\').2g().Z({44:a.1M().1c-80},8A)}}})},Z:9(){$(\'.D-2i\').K(9(f){$(7).2E({2n:9(c){C d=c.2f(0).8C,X=0,1a=\'2s\',2q=0;z(d.1N(\'D-Z-X-\')>-1){X=d.1B(\'D-Z-X-\')[1].1B(\' \')[0];c.O({\'33-X\':X+\'8E\'});c.U(\'D-Z-X-\'+X);2q+=2B(X)}z(d.1N(\'D-Z-1a-\')>-1){1a=d.1B(\'D-Z-1a-\')[1].1B(\' \')[0];c.O({\'33-37\':1a});c.U(\'D-Z-1a-\'+1a)}z(d.1N(\'D-Z-47-\')>-1){C e=d.1B(\'D-Z-47-\')[1].1B(\' \')[0];2q+=8G(1a)*3u;c.U(\'D-2i\').W(\'2i \'+e);2M(9(a,b){a.U(\'2i D-2i D-Z-47-\'+b+\' \'+b);a.O({\'33-X\':\'\',\'33-37\':\'\'})},2q,c,e)}},1v:\'D-4H-I\'})})}}}(2r));(9($){$.3Z.3H=9(){E 7.K(9(){C a=7.4Y();C b=$(7).y(\'8H\'),2l=$(7).B(\'11\').5t(),2z=$(7).B(\'11\').39(),3K=$(7).5t(),2m=$(7).39();z(1i(b)==\'R\'){$(7).B(\'11\').O(\'3l-19\',-2l/2);$(7).2N().B(\'11\').O(\'1P\',2m+10)}J{C c=$(7).y(\'8R\');C d=-10;z(1i c==\'R\')c=\'1c\';$(7).W(c);$(7).B(\'11\').2G({\'1q\':\'\'});8S(c){49\'5j\':{C e;e=2m/2-2z/2;$(7).B(\'11\').O(\'19\',3K+10);$(7).B(\'11\').O(\'1P\',e);$(7).2N().B(\'11\').O(\'19\',3K-d);3c}49\'1P\':{$(7).B(\'11\').O(\'3l-19\',-2l/2);$(7).2N().B(\'11\').O(\'1P\',-2z+d);3c}49\'19\':{C e,5C=5;e=2m/2-2z/2;$(7).B(\'11\').O(\'19\',-2l-5C);$(7).B(\'11\').O(\'1P\',e);3c}78:{$(7).B(\'11\').O(\'3l-19\',-2l/2);$(7).2N().B(\'11\').O(\'1P\',2m-d)}}}})}}(2r));',62,555,'|||||||this||function|||||||||||||||||||||||||data|if|true|find|var|kc|return|div|active|false|loaded|else|each|section|kc_front|class|css|yes|ui|undefined|owl|cfg|removeClass|width|addClass|delay|click|animate||span||height|getAttribute||options|tabs|on|left|speed|trigger|top|kc_accordion_header|kc_accordion_section|h3|px|window|typeof|100|state|html|parent|closest|_pagination|update|style|video|length|_speed|owlCarousel|classToAdd|rect|pagination|href|body|items|split|youtube_row_background|ready|total|resize|_singleItem|round|preventDefault|navigation|init|grid|offset|indexOf|post|bottom|goTo|_items|hasClass|bar|bg|pretty_photo|null|_mobile|new|kc_accordion_content|ifr_h|_tablet|ifr_w|_navigation|inner_height|replace|playerVars|opacity|kc_tabs|el|item|percentTime|eq|_auto_play|inner_width|get|stop|percent|animated|piechar|masonry|span_w|this_h|callbackFunction|Math|tab|timeout|jQuery||add|progress_bar|tab_group|tab_event|marginLeft|marginTop|span_h|img|parseInt|location|title|viewportChecker|src|attr|off|nextElementSibling|refresh|next|youtubeId|setTimeout|hover|kc_wrap|autoHeight|singleItem|load|paginationSpeed|data_send|slideSpeed|_auto_height|isPause|elem|row_action|action|autoplay|tablet|mobile|animation|events|itemsDesktop|accordion|duration|YT|outerHeight|show_contact_form|kc_accordion_wrapper|break|sl|closeall|viewportTop|_autoheight|autoPlay|success|object|json|margin|el_top|owl_slider|allowopenall|dataType|size|extend|viewport|slideUp|1000|imgs|POST|easing|countdown|Masonry|itemSelector|method|ajax_url|columnWidth|synced|kc_script_data|url|kcTooltip|image_fade_delay|close|this_w|ajax|slow|_delay|remove|afterInit|itemsMobile|document|nav|li|tab_list|new_panel|removeAttribute|tick|slider|fn|itemsTablet|_show_thumb|showthumb|_progress_bar|scrollTop|carousel|image_gallery|eff|itemsDesktopSmall|case|youtubeUrl|iframe|checkElements|label|num_thumb|_num_thumb|autoheight|first|onload|Image|target|mute|JSON|ifr_inner|container|Player|be|getID|counterup|console|itemsTabletSmall|active_section|effect_option|afterMove|startDragging|mouseover|kc_wrapper|index|responsiveRefreshRate|1199|normal|slideDown|kc_piechart|pc|changed|_linecap|_barColor|_trackColor|_autowidth|_linewidth|hidden|progress|toggleClass|now|end|479|kc_facebook_recent_post|map_popup_contact_form|pointer|paddingLeft|getBoundingClientRect|fullwidth||querySelectorAll|documentElement|clientWidth|clientHeight|kc_video_play|smooth_scroll|image_fade|ul|before|atts_data|result_twitter_feed|_autoHeight|tooltips|_showthumb|prettyPhoto|pt|ajax_action|arrow|right|pathname|hostname|hash|run|countdown_timer|carousel_post|carousel_images|blog|google_maps|outerWidth|kc_tooltip|innerHeight|elemBottom|viewportBottom|scroll|parallax|kc_parallax|easeInOutQuart|ext_left|many|attempts|to|SCRIPT|YouTube|api|innerHTML|prepend|parentNode|removeChild|kc_google_maps|compatMode|playlist|iv_load_policy|progressBar|append|prependTo|setInterval|enablejsapi|disablekb|clearTimeout|wheel|controls|showinfo|rel|loop|disable|parse|BackCompat|decodeURIComponent|userAgent|currentTarget|videoId|onReady|group|toLowerCase|setLoop|sync2|currentItem|auto|owlItem|visibleItems|for|in|afterAction|200|open|979|768|update_option|kc_ajax_url|security|kc_ajax_nonce|mouseleave|kc_update_option|tools|base64|encode|stringify|none|timer|date|strftime|template|effect|option|innerWidth|kc_button|linecap|square|maxWidth|barcolor|forEach|trackcolor|single_img|autowidth|kc_blog_masonry|linewidth|call|after|easyPieChart|barColor|trackColor|lineCap|easeOutBounce|onStep|text|show|scaleLength|lineWidth|kc_progress_bars|pb||default|value|kc_tabs_nav|step|fadeIn|kc_tab|getElementsByClassName|fadeOut|webkit|kc_clfw|visible|win_height|log|100000|kc_image_gallery|image_masonry|but|win_width|image_fadein_slider|image_fadein|3000|hide|header_html|kc_wrap_instagram|kc_instagrams_feed|kc_twitter_feed|counterUp|kc_twitter_timeline|owl_option|display_style|button_follow_wrap|header_data|show_navigation|show_pagination|images|auto_height|tweet|300|400|450|backgroundPosition|time|itemsCustom|980|640|480|2000|pretty|photo|not|theme|dark_rounded|allow_resize|allow_expand||animation_speed|fast|deeplinking|counter_separator_label||show_title|horizontal_padding|overlay_gallery|markup|pp_pic_holder|pp_content_container|pp_left|pp_right|pp_content|pp_loaderIcon|spinner|pp_fade|pp_hoverContainer|pp_next|kc_row|kc_column|header|pp_previous|id|pp_full_res|pp_details|ppt|nbsp|pp_nav|currentTextHolder|pp_description|pp_close|pp_overlay|icon|row|500|paddingRight|className|match|ms|https|parseFloat|tooltip|0px|youtu|done|com|watch|clickitself|progressbar|navigator|tagName|position|switch|warn|Too|999|playVideo'.split('|'),0,{}))
var scriptUrl='https:\/\/www.youtube.com\/s\/player\/9e457a67\/www-widgetapi.vflset\/www-widgetapi.js';try{var ttPolicy=window.trustedTypes.createPolicy("youtube-widget-api",{createScriptURL:function(x){return x}});scriptUrl=ttPolicy.createScriptURL(scriptUrl)}catch(e){}if(!window["YT"])var YT={loading:0,loaded:0};if(!window["YTConfig"])var YTConfig={"host":"https://www.youtube.com"};if(!YT.loading){YT.loading=1;(function(){var l=[];YT.ready=function(f){if(YT.loaded)f();else l.push(f)};window.onYTReady=function(){YT.loaded=1;for(var i=0;i<l.length;i++)try{l[i]()}catch(e$0){}};YT.setConfig=function(c){for(var k in c)if(c.hasOwnProperty(k))YTConfig[k]=c[k]};var a=document.createElement("script");a.type="text/javascript";a.id="www-widgetapi-script";a.src=scriptUrl;a.async=true;var c=document.currentScript;if(c){var n=c.nonce||c.getAttribute("nonce");if(n)a.setAttribute("nonce",n)}var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})()};
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('7 9=(6($){8{13:6(){$(\'.1h\').1i(6(){5(9.q.12($(E).4(\'j\'))){9.q.C($(E))}1g{5(9.x.y($(E).4(\'j\'))){9.x.C($(E))}}})},q:{12:6(a){5(a===t)8 B;7 p=/^(?:X?:\\/\\/)?(?:16\\.)?(?:15\\.V\\/|q\\.J\\/(?:1f\\/|v\\/|U\\?v=|U\\?.+&v=))((\\w|-){11})(?:\\S+)?$/;8(a.L(p))?1e.$1:B},y:6(a){5(\'t\'===O(a)){8 B}7 b=a.L(/(?:X?:\\/{2})?(?:w{3}\\.)?15(?:V)?\\.(?:J|V)(?:\\/U\\?v=|\\/)([^\\s&]+)/);5(1c!==b){8 b[1]}8 B},C:6(a,b){7 c,z,n=(\'g\'===a.4(\'n\'))?1:0,T=(\'g\'===a.4(\'T\'))?1:0,A=(\'g\'===a.4(\'A\'))?1:0,10=(\'g\'===a.4(\'1G\'))?1:0,D=(\'g\'===a.4(\'D\'))?1:0,r=a.4(\'o\'),H=a.4(\'k\');5(\'g\'===a.4(\'19\')){r=\'K%\'}c=a.4(\'j\');z=9.q.y(c);5(N===t)8;5(\'t\'===O(N.18)){b=\'t\'===O(b)?0:b;5(b>K){1T.1j(\'1k 1w 1x 1C 1D 1E P\');8}1Q(6(){9.q.C(a,z,b++)},K);8}7 d,G=1.Q,R=\'\',$F=a.Z(\'<m I="W-j-14"><m I="i"></m></m>\').h(\'.i\');5(A==1)R=z;d=1l N.18($F[0],{o:r,k:H,1m:z,1n:{1o:3,1p:R,1q:1,1r:1,n:n,1s:10,D:D,1t:T,A:A},1u:{1v:6(e){5(a.4(\'W-j-17\')==\'g\')e.1y.17().1z(1A);7 w=$(a).h(\'.i\').o();$(a).h(\'.i\').k(w/G)}}})}},x:{y:6(a){5(a===t)8 B;7 b=/1B(s)?:\\/\\/(16\\.)?x.J\\/(\\d+)(\\/)?(#.*)?/;7 c=a.L(b);5(c)8 c[3]},C:6(a){7 b,u,n=(\'g\'===a.4(\'n\'))?1:0,r=a.4(\'o\'),H=a.4(\'k\');b=a.4(\'j\');u=9.x.y(b);5(\'g\'===a.4(\'19\')){r=\'K%\'}7 c,l,Y,G=1.Q,$F=a.Z(\'<m I="W-j-14"><m I="i"></m></m>\').h(\'.i\');Y=\'<l 1F="M\'+u+\'" 1H="X://1I.x.J/j/\'+u+\'?P=1&1J=M\'+u+\'" o="\'+r+\'" k="\'+H+\'" 1K="0" 1L 1M 1N></l>\';$($F[0]).1O(Y);l=$(\'#M\'+u)[0];c=$f(l);c.1P(\'1a\',6(){5(n===1){c.P(\'1R\')}7 w=$(a).h(\'l\').o();$(a).h(\'l\').k(w/G)})}},1S:6(a){7 b=1.Q,w=a.h(\'.i\').o();a.h(\'.i\').k(w/b);a.h(\'.i>l\').k(w/b)}}}(1b));1b(1d).1a(6($){9.13($)});',62,118,'||||data|if|function|var|return|kc_video_play|||||||yes|find|ifr_inner|video|height|iframe|div|autoplay|width||youtube|_vd_width||undefined|vimeoId|||vimeo|getID|youtubeId|loop|false|add|showinfo|this|container|ratio|_vd_height|class|com|100|match|player_|YT|typeof|api|77|youtubeId_pl||related|watch|be|kc|https|player_iframe|prepend|ctl||url_valid|init|inner|youtu|www|mute|Player|fullwidth|ready|jQuery|null|document|RegExp|embed|else|kc_video_wrapper|each|warn|Too|new|videoId|playerVars|iv_load_policy|playlist|enablejsapi|disablekb|controls|rel|events|onReady|many|attempts|target|setLoop|true|http|to|load|YouTube|id|control|src|player|player_id|frameborder|webkitallowfullscreen|mozallowfullscreen|allowfullscreen|html|addEvent|setTimeout|play|refresh|console'.split('|'),0,{}))
/*! This file is auto-generated */
!function(c,d){"use strict";var e=!1,n=!1;if(d.querySelector)if(c.addEventListener)e=!0;if(c.wp=c.wp||{},!c.wp.receiveEmbedMessage)if(c.wp.receiveEmbedMessage=function(e){var t=e.data;if(t)if(t.secret||t.message||t.value)if(!/[^a-zA-Z0-9]/.test(t.secret)){for(var r,a,i,s=d.querySelectorAll('iframe[data-secret="'+t.secret+'"]'),n=d.querySelectorAll('blockquote[data-secret="'+t.secret+'"]'),o=0;o<n.length;o++)n[o].style.display="none";for(o=0;o<s.length;o++)if(r=s[o],e.source===r.contentWindow){if(r.removeAttribute("style"),"height"===t.message){if(1e3<(i=parseInt(t.value,10)))i=1e3;else if(~~i<200)i=200;r.height=i}if("link"===t.message)if(a=d.createElement("a"),i=d.createElement("a"),a.href=r.getAttribute("src"),i.href=t.value,i.host===a.host)if(d.activeElement===r)c.top.location.href=t.value}}},e)c.addEventListener("message",c.wp.receiveEmbedMessage,!1),d.addEventListener("DOMContentLoaded",t,!1),c.addEventListener("load",t,!1);function t(){if(!n){n=!0;for(var e,t,r=-1!==navigator.appVersion.indexOf("MSIE 10"),a=!!navigator.userAgent.match(/Trident.*rv:11\./),i=d.querySelectorAll("iframe.wp-embedded-content"),s=0;s<i.length;s++){if(!(e=i[s]).getAttribute("data-secret"))t=Math.random().toString(36).substr(2,10),e.src+="#?secret="+t,e.setAttribute("data-secret",t);if(r||a)(t=e.cloneNode(!0)).removeAttribute("security"),e.parentNode.replaceChild(t,e)}}}}(window,document);
