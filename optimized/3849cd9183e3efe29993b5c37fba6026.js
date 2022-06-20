!function(y,c,i,n){var t=function(t){var a=this;a.$form=t,a.$attributeFields=t.find(".variations select"),a.$singleVariation=t.find(".single_variation"),a.$singleVariationWrap=t.find(".single_variation_wrap"),a.$resetVariations=t.find(".reset_variations"),a.$product=t.closest(".product"),a.variationData=t.data("product_variations"),a.useAjax=!1===a.variationData,a.xhr=!1,a.loading=!0,a.$singleVariationWrap.show(),a.$form.off(".wc-variation-form"),a.getChosenAttributes=a.getChosenAttributes.bind(a),a.findMatchingVariations=a.findMatchingVariations.bind(a),a.isMatch=a.isMatch.bind(a),a.toggleResetLink=a.toggleResetLink.bind(a),t.on("click.wc-variation-form",".reset_variations",{variationForm:a},a.onReset),t.on("reload_product_variations",{variationForm:a},a.onReload),t.on("hide_variation",{variationForm:a},a.onHide),t.on("show_variation",{variationForm:a},a.onShow),t.on("click",".single_add_to_cart_button",{variationForm:a},a.onAddToCart),t.on("reset_data",{variationForm:a},a.onResetDisplayedVariation),t.on("reset_image",{variationForm:a},a.onResetImage),t.on("change.wc-variation-form",".variations select",{variationForm:a},a.onChange),t.on("found_variation.wc-variation-form",{variationForm:a},a.onFoundVariation),t.on("check_variations.wc-variation-form",{variationForm:a},a.onFindVariation),t.on("update_variation_values.wc-variation-form",{variationForm:a},a.onUpdateAttributes),setTimeout(function(){t.trigger("check_variations"),t.trigger("wc_variation_form",a),a.loading=!1},100)};t.prototype.onReset=function(t){t.preventDefault(),t.data.variationForm.$attributeFields.val("").trigger("change"),t.data.variationForm.$form.trigger("reset_data")},t.prototype.onReload=function(t){t=t.data.variationForm;t.variationData=t.$form.data("product_variations"),t.useAjax=!1===t.variationData,t.$form.trigger("check_variations")},t.prototype.onHide=function(t){t.preventDefault(),t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("wc-variation-is-unavailable").addClass("disabled wc-variation-selection-needed"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-enabled").addClass("woocommerce-variation-add-to-cart-disabled")},t.prototype.onShow=function(t,a,i){t.preventDefault(),i?(t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("disabled wc-variation-selection-needed wc-variation-is-unavailable"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-disabled").addClass("woocommerce-variation-add-to-cart-enabled")):(t.data.variationForm.$form.find(".single_add_to_cart_button").removeClass("wc-variation-selection-needed").addClass("disabled wc-variation-is-unavailable"),t.data.variationForm.$form.find(".woocommerce-variation-add-to-cart").removeClass("woocommerce-variation-add-to-cart-enabled").addClass("woocommerce-variation-add-to-cart-disabled")),wp.mediaelement&&t.data.variationForm.$form.find(".wp-audio-shortcode, .wp-video-shortcode").not(".mejs-container").filter(function(){return!y(this).parent().hasClass("mejs-mediaelement")}).mediaelementplayer(wp.mediaelement.settings)},t.prototype.onAddToCart=function(t){y(this).is(".disabled")&&(t.preventDefault(),y(this).is(".wc-variation-is-unavailable")?c.alert(wc_add_to_cart_variation_params.i18n_unavailable_text):y(this).is(".wc-variation-selection-needed")&&c.alert(wc_add_to_cart_variation_params.i18n_make_a_selection_text))},t.prototype.onResetDisplayedVariation=function(t){t=t.data.variationForm;t.$product.find(".product_meta").find(".sku").wc_reset_content(),t.$product.find(".product_weight, .woocommerce-product-attributes-item--weight .woocommerce-product-attributes-item__value").wc_reset_content(),t.$product.find(".product_dimensions, .woocommerce-product-attributes-item--dimensions .woocommerce-product-attributes-item__value").wc_reset_content(),t.$form.trigger("reset_image"),t.$singleVariation.slideUp(200).trigger("hide_variation")},t.prototype.onResetImage=function(t){t.data.variationForm.$form.wc_variations_image_update(!1)},t.prototype.onFindVariation=function(t,a){var i=t.data.variationForm,e=void 0!==a?a:i.getChosenAttributes(),a=e.data;e.count&&e.count===e.chosenCount?i.useAjax?(i.xhr&&i.xhr.abort(),i.$form.block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),a.product_id=parseInt(i.$form.data("product_id"),10),a.custom_data=i.$form.data("custom_data"),i.xhr=y.ajax({url:wc_add_to_cart_variation_params.wc_ajax_url.toString().replace("%%endpoint%%","get_variation"),type:"POST",data:a,success:function(t){t?i.$form.trigger("found_variation",[t]):(i.$form.trigger("reset_data"),e.chosenCount=0,i.loading||(i.$form.find(".single_variation").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),i.$form.find(".wc-no-matching-variations").slideDown(200)))},complete:function(){i.$form.unblock()}})):(i.$form.trigger("update_variation_values"),(a=i.findMatchingVariations(i.variationData,a).shift())?i.$form.trigger("found_variation",[a]):(i.$form.trigger("reset_data"),e.chosenCount=0,i.loading||(i.$form.find(".single_variation").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),i.$form.find(".wc-no-matching-variations").slideDown(200)))):(i.$form.trigger("update_variation_values"),i.$form.trigger("reset_data")),i.toggleResetLink(0<e.chosenCount)},t.prototype.onFoundVariation=function(t,a){var i=t.data.variationForm,e=i.$product.find(".product_meta").find(".sku"),r=i.$product.find(".product_weight, .woocommerce-product-attributes-item--weight .woocommerce-product-attributes-item__value"),o=i.$product.find(".product_dimensions, .woocommerce-product-attributes-item--dimensions .woocommerce-product-attributes-item__value"),n=i.$singleVariationWrap.find(".quantity"),s=!0,c=!1,t="";a.sku?e.wc_set_content(a.sku):e.wc_reset_content(),a.weight?r.wc_set_content(a.weight_html):r.wc_reset_content(),a.dimensions?o.wc_set_content(y.parseHTML(a.dimensions_html)[0].data):o.wc_reset_content(),i.$form.wc_variations_image_update(a),a.variation_is_visible?(c=_("variation-template"),a.variation_id):c=_("unavailable-variation-template"),t=(t=(t=c({variation:a})).replace("/*<![CDATA[*/","")).replace("/*]]>*/",""),i.$singleVariation.html(t),i.$form.find('input[name="variation_id"], input.variation_id').val(a.variation_id).trigger("change"),"yes"===a.is_sold_individually?(n.find("input.qty").val("1").attr("min","1").attr("max","").trigger("change"),n.hide()):(c=n.find("input.qty"),t=parseFloat(c.val()),t=isNaN(t)||(t=t>parseFloat(a.max_qty)?a.max_qty:t)<parseFloat(a.min_qty)?a.min_qty:t,c.attr("min",a.min_qty).attr("max",a.max_qty).val(t).trigger("change"),n.show()),a.is_purchasable&&a.is_in_stock&&a.variation_is_visible||(s=!1),(i.$singleVariation.text().trim()?i.$singleVariation.slideDown(200):i.$singleVariation.show()).trigger("show_variation",[a,s])},t.prototype.onChange=function(t){t=t.data.variationForm;t.$form.find('input[name="variation_id"], input.variation_id').val("").trigger("change"),t.$form.find(".wc-no-matching-variations").remove(),t.useAjax||t.$form.trigger("woocommerce_variation_select_change"),t.$form.trigger("check_variations"),t.$form.trigger("woocommerce_variation_has_changed")},t.prototype.addSlashes=function(t){return t=(t=t.replace(/'/g,"\\'")).replace(/"/g,'\\"')},t.prototype.onUpdateAttributes=function(t){var b=t.data.variationForm,$=b.getChosenAttributes().data;b.useAjax||(b.$attributeFields.each(function(t,a){var i=y(a),e=i.data("attribute_name")||i.attr("name"),r=y(a).data("show_option_none"),o=":gt(0)",a=0,n=y("<select/>"),s=i.val()||"",c=!0;i.data("attribute_html")||((_=i.clone()).find("option").prop("disabled attached",!1).prop("selected",!1),i.data("attribute_options",_.find("option"+o).get()),i.data("attribute_html",_.html())),n.html(i.data("attribute_html"));var _=y.extend(!0,{},$);_[e]="";var d,m=b.findMatchingVariations(b.variationData,_);for(d in m)if("undefined"!=typeof m[d]){var l,v=m[d].attributes;for(l in v)if(v.hasOwnProperty(l)){var g=v[l],u="";if(l===e)if(m[d].variation_is_active&&(u="enabled"),g){g=y("<div/>").html(g).text();var f=n.find("option");if(f.length)for(var h=0,p=f.length;h<p;h++){var w=y(f[h]);if(g===w.val()){w.addClass("attached "+u);break}}}else n.find("option:gt(0)").addClass("attached "+u)}}a=n.find("option.attached").length,s&&(c=!1,0!==a&&n.find("option.attached.enabled").each(function(){var t=y(this).val();if(s===t)return!(c=!0)})),0<a&&s&&c&&"no"===r&&(n.find("option:first").remove(),o=""),n.find("option"+o+":not(.attached)").remove(),i.html(n.html()),i.find("option"+o+":not(.enabled)").prop("disabled",!0),s?c?i.val(s):i.val("").trigger("change"):i.val("")}),b.$form.trigger("woocommerce_update_variation_values"))},t.prototype.getChosenAttributes=function(){var i={},e=0,r=0;return this.$attributeFields.each(function(){var t=y(this).data("attribute_name")||y(this).attr("name"),a=y(this).val()||"";0<a.length&&r++,e++,i[t]=a}),{count:e,chosenCount:r,data:i}},t.prototype.findMatchingVariations=function(t,a){for(var i=[],e=0;e<t.length;e++){var r=t[e];this.isMatch(r.attributes,a)&&i.push(r)}return i},t.prototype.isMatch=function(t,a){var i,e,r,o=!0;for(i in t){t.hasOwnProperty(i)&&(e=t[i],r=a[i],e!==n&&r!==n&&0!==e.length&&0!==r.length&&e!==r&&(o=!1))}return o},t.prototype.toggleResetLink=function(t){t?"hidden"===this.$resetVariations.css("visibility")&&this.$resetVariations.css("visibility","visible").hide().fadeIn():this.$resetVariations.css("visibility","hidden")},y.fn.wc_variation_form=function(){return new t(this),this},y.fn.wc_set_content=function(t){n===this.attr("data-o_content")&&this.attr("data-o_content",this.text()),this.text(t)},y.fn.wc_reset_content=function(){n!==this.attr("data-o_content")&&this.text(this.attr("data-o_content"))},y.fn.wc_set_variation_attr=function(t,a){n===this.attr("data-o_"+t)&&this.attr("data-o_"+t,this.attr(t)?this.attr(t):""),!1===a?this.removeAttr(t):this.attr(t,a)},y.fn.wc_reset_variation_attr=function(t){n!==this.attr("data-o_"+t)&&this.attr(t,this.attr("data-o_"+t))},y.fn.wc_maybe_trigger_slide_position_reset=function(t){var a=y(this),i=a.closest(".product").find(".images"),e=!1,t=t&&t.image_id?t.image_id:"";a.attr("current-image")!==t&&(e=!0),a.attr("current-image",t),e&&i.trigger("woocommerce_gallery_reset_slide_position")},y.fn.wc_variations_image_update=function(t){var a=this,i=a.closest(".product"),e=i.find(".images"),r=i.find(".flex-control-nav"),o=r.find("li:eq(0) img"),n=e.find(".woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder").eq(0),s=n.find(".wp-post-image"),i=n.find("a").eq(0);if(t&&t.image&&t.image.src&&1<t.image.src.length){0<r.find('li img[data-o_src="'+t.image.gallery_thumbnail_src+'"]').length&&a.wc_variations_image_reset();r=r.find('li img[src="'+t.image.gallery_thumbnail_src+'"]');if(0<r.length)return r.trigger("click"),a.attr("current-image",t.image_id),void c.setTimeout(function(){y(c).trigger("resize"),e.trigger("woocommerce_gallery_init_zoom")},20);s.wc_set_variation_attr("src",t.image.src),s.wc_set_variation_attr("height",t.image.src_h),s.wc_set_variation_attr("width",t.image.src_w),s.wc_set_variation_attr("srcset",t.image.srcset),s.wc_set_variation_attr("sizes",t.image.sizes),s.wc_set_variation_attr("title",t.image.title),s.wc_set_variation_attr("data-caption",t.image.caption),s.wc_set_variation_attr("alt",t.image.alt),s.wc_set_variation_attr("data-src",t.image.full_src),s.wc_set_variation_attr("data-large_image",t.image.full_src),s.wc_set_variation_attr("data-large_image_width",t.image.full_src_w),s.wc_set_variation_attr("data-large_image_height",t.image.full_src_h),n.wc_set_variation_attr("data-thumb",t.image.src),o.wc_set_variation_attr("src",t.image.gallery_thumbnail_src),i.wc_set_variation_attr("href",t.image.full_src)}else a.wc_variations_image_reset();c.setTimeout(function(){y(c).trigger("resize"),a.wc_maybe_trigger_slide_position_reset(t),e.trigger("woocommerce_gallery_init_zoom")},20)},y.fn.wc_variations_image_reset=function(){var t=this.closest(".product"),a=t.find(".images"),i=t.find(".flex-control-nav").find("li:eq(0) img"),e=a.find(".woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder").eq(0),t=e.find(".wp-post-image"),a=e.find("a").eq(0);t.wc_reset_variation_attr("src"),t.wc_reset_variation_attr("width"),t.wc_reset_variation_attr("height"),t.wc_reset_variation_attr("srcset"),t.wc_reset_variation_attr("sizes"),t.wc_reset_variation_attr("title"),t.wc_reset_variation_attr("data-caption"),t.wc_reset_variation_attr("alt"),t.wc_reset_variation_attr("data-src"),t.wc_reset_variation_attr("data-large_image"),t.wc_reset_variation_attr("data-large_image_width"),t.wc_reset_variation_attr("data-large_image_height"),e.wc_reset_variation_attr("data-thumb"),i.wc_reset_variation_attr("src"),a.wc_reset_variation_attr("href")},y(function(){"undefined"!=typeof wc_add_to_cart_variation_params&&y(".variations_form").each(function(){y(this).wc_variation_form()})});var _=function(t){var a=i.getElementById("tmpl-"+t).textContent;return/<#\s?data\./.test(a)||/{{{?\s?data\.(?!variation\.).+}}}?/.test(a)||/{{{?\s?data\.variation\.[\w-]*[^\s}]/.test(a)?wp.template(t):function(t){var r=t.variation||{};return a.replace(/({{{?)\s?data\.variation\.([\w-]*)\s?(}}}?)/g,function(t,a,i,e){if(a.length!==e.length)return"";i=r[i]||"";return 2===a.length?c.escape(i):i})}}}(jQuery,window,document);
/*!
 * accounting.js v0.4.2
 * Copyright 2014 Open Exchange Rates
 *
 * Freely distributable under the MIT license.
 * Portions of accounting.js are inspired or borrowed from underscore.js
 *
 * Full details and documentation:
 * http://openexchangerates.github.io/accounting.js/
 */
!function(n){var f={version:"0.4.1",settings:{currency:{symbol:"$",format:"%s%v",decimal:".",thousand:",",precision:2,grouping:3},number:{precision:0,grouping:3,thousand:",",decimal:"."}}},i=Array.prototype.map,r=Array.isArray,e=Object.prototype.toString;function p(n){return""===n||n&&n.charCodeAt&&n.substr}function l(n){return r?r(n):"[object Array]"===e.call(n)}function m(n){return n&&"[object Object]"===e.call(n)}function d(n,r){for(var e in n=n||{},r=r||{})r.hasOwnProperty(e)&&null==n[e]&&(n[e]=r[e]);return n}function g(n,r,e){var t,o,a=[];if(!n)return a;if(i&&n.map===i)return n.map(r,e);for(t=0,o=n.length;t<o;t++)a[t]=r.call(e,n[t],t,n);return a}function h(n,r){return n=Math.round(Math.abs(n)),isNaN(n)?r:n}function y(n){var r=f.settings.currency.format;return"function"==typeof n&&(n=n()),p(n)&&n.match("%v")?{pos:n,neg:n.replace("-","").replace("%v","-%v"),zero:n}:n&&n.pos&&n.pos.match("%v")?n:p(r)?f.settings.currency.format={pos:r,neg:r.replace("%v","-%v"),zero:r}:r}var t,b=f.unformat=f.parse=function(n,r){if(l(n))return g(n,function(n){return b(n,r)});if("number"==typeof(n=n||0))return n;r=r||f.settings.number.decimal;var e=new RegExp("[^0-9-"+r+"]",["g"]),e=parseFloat((""+n).replace(/\((.*)\)/,"-$1").replace(e,"").replace(r,"."));return isNaN(e)?0:e},s=f.toFixed=function(n,r){r=h(r,f.settings.number.precision);var e=Math.pow(10,r);return(Math.round(f.unformat(n)*e)/e).toFixed(r)},v=f.formatNumber=f.format=function(n,r,e,t){if(l(n))return g(n,function(n){return v(n,r,e,t)});n=b(n);var o=d(m(r)?r:{precision:r,thousand:e,decimal:t},f.settings.number),a=h(o.precision),i=n<0?"-":"",u=parseInt(s(Math.abs(n||0),a),10)+"",c=3<u.length?u.length%3:0;return i+(c?u.substr(0,c)+o.thousand:"")+u.substr(c).replace(/(\d{3})(?=\d)/g,"$1"+o.thousand)+(a?o.decimal+s(Math.abs(n),a).split(".")[1]:"")},c=f.formatMoney=function(n,r,e,t,o,a){if(l(n))return g(n,function(n){return c(n,r,e,t,o,a)});n=b(n);var i=d(m(r)?r:{symbol:r,precision:e,thousand:t,decimal:o,format:a},f.settings.currency),u=y(i.format);return(0<n?u.pos:n<0?u.neg:u.zero).replace("%s",i.symbol).replace("%v",v(Math.abs(n),h(i.precision),i.thousand,i.decimal))};f.formatColumn=function(n,r,e,t,o,a){if(!n)return[];var i=d(m(r)?r:{symbol:r,precision:e,thousand:t,decimal:o,format:a},f.settings.currency),u=y(i.format),c=u.pos.indexOf("%s")<u.pos.indexOf("%v"),s=0,n=g(n,function(n,r){if(l(n))return f.formatColumn(n,i);n=(0<(n=b(n))?u.pos:n<0?u.neg:u.zero).replace("%s",i.symbol).replace("%v",v(Math.abs(n),h(i.precision),i.thousand,i.decimal));return n.length>s&&(s=n.length),n});return g(n,function(n,r){return p(n)&&n.length<s?c?n.replace(i.symbol,i.symbol+new Array(s-n.length+1).join(" ")):new Array(s-n.length+1).join(" ")+n:n})},"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports=f),exports.accounting=f):"function"==typeof define&&define.amd?define([],function(){return f}):(f.noConflict=(t=n.accounting,function(){return n.accounting=t,f.noConflict=void 0,f}),n.accounting=f)}(this);
