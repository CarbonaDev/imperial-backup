jQuery(function(t){t(".woocommerce-ordering").on("change","select.orderby",function(){t(this).closest("form").submit()}),t("input.qty:not(.product-quantity input.qty)").each(function(){var o=parseFloat(t(this).attr("min"));0<=o&&parseFloat(t(this).val())<o&&t(this).val(o)});var e="store_notice"+(t(".woocommerce-store-notice").data("notice-id")||"");"hidden"===Cookies.get(e)?t(".woocommerce-store-notice").hide():t(".woocommerce-store-notice").show(),t(".woocommerce-store-notice__dismiss-link").click(function(o){Cookies.set(e,"hidden",{path:"/"}),t(".woocommerce-store-notice").hide(),o.preventDefault()}),t(".woocommerce-input-wrapper span.description").length&&t(document.body).on("click",function(){t(".woocommerce-input-wrapper span.description:visible").prop("aria-hidden",!0).slideUp(250)}),t(".woocommerce-input-wrapper").on("click",function(o){o.stopPropagation()}),t(".woocommerce-input-wrapper :input").on("keydown",function(o){var e=t(this).parent().find("span.description");if(27===o.which&&e.length&&e.is(":visible"))return e.prop("aria-hidden",!0).slideUp(250),o.preventDefault(),!1}).on("click focus",function(){var o=t(this).parent(),e=o.find("span.description");o.addClass("currentTarget"),t(".woocommerce-input-wrapper:not(.currentTarget) span.description:visible").prop("aria-hidden",!0).slideUp(250),e.length&&e.is(":hidden")&&e.prop("aria-hidden",!1).slideDown(250),o.removeClass("currentTarget")}),t.scroll_to_notices=function(o){o.length&&t("html, body").animate({scrollTop:o.offset().top-100},1e3)},t('.woocommerce form .woocommerce-Input[type="password"]').wrap('<span class="password-input"></span>'),t(".woocommerce form input").filter(":password").parent("span").addClass("password-input"),t(".password-input").append('<span class="show-password-input"></span>'),t(".show-password-input").click(function(){t(this).toggleClass("display-password"),t(this).hasClass("display-password")?t(this).siblings(['input[type="password"]']).prop("type","text"):t(this).siblings('input[type="text"]').prop("type","password")})});
