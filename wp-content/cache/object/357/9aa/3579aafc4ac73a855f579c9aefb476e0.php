Y5�b<?php exit; ?>a:1:{s:7:"content";O:8:"stdClass":24:{s:2:"ID";i:7339;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2021-02-11 09:30:05";s:13:"post_date_gmt";s:19:"2021-02-11 12:30:05";s:12:"post_content";s:27839:".footer-mid-v3{
	background:#fff!important;
	border-top:  2px solid #111;
}
#kft_footer-3 .kc_row{
	background:#3a2614!important;
}
.wa__btn_popup_txt{
	display:none;
}
.wa__btn_popup .wa__btn_popup_icon{
	background: #2db742;
}
.back-to-top{
	display:none!important;
}

.owl-prev span{
	display:none;
}
.owl-next span{
	display:none;
}

.footer-payment-text{
	margin-top: 30px;
}

/*mostrar thumbnails*/
.page .entry-featured {
    display: none !important;
}
.woocommerce li.product .entry-featured,
.woocommerce-page li.product .entry-featured{
  display:block !important;
}

.topbar-login{
	display:none!important;
}
/*variable price begone */
.product-type-variable .fswp_in_cash_price.single{
	display:none;
}

/** cima **/
.product-type-variable .wc-simulador-parcelas-offer{
	display:none;
}

/** de baixo **/
.product-type-variable .woocommerce-variation-price .wc-simulador-parcelas-offer{
	display:block!important;
}

/** tela de produtos**/
.kft-product.product-type-variable .wc-simulador-parcelas-offer {
    display: block;
}
/** cima**/
.product-type-variable 
.price .wc-simulador-parcelas-parcelamento-info-container {
	display: none !important;
}

/** de baixo**/
.product-type-variable 
.woocommerce-variation-price .wc-simulador-parcelas-parcelamento-info-container {
	display:block!important;
}

/*Campo rastreio order*/
.woocommerce-orders-table__header.woocommerce-orders-table__header-tracking span.nobr{
opacity:0;
}

.woocommerce-orders-table__cell.woocommerce-orders-table__cell-tracking {
	
	color:white;
	border-bottom: 1px solid #dcdcde;

}
.woocommerce td.product-name p.backorder_notification{
	font-size: 1.2em;
}

/*#yith-wcwtl-output*/

#yith-wcwtl-output input, #yith-wcwtl-output p, #yith-wcwtl-output label {
	display: block !important;
}

#collapse-payment-billet .gn-osc-row .gn-osc-pay-comments .gn-left-space-2 {
	content: "Optando por pagar através de boleto bancário, a confirmação será feita no próximo dia útil após o pagamento."
}

/*checkout rede*/
.form-row.form-row-first.rede-card.woocommerce-validated{
	width:100%!important;
}
.form-row.form-row-last.rede-card.woocommerce-validated{
	width:100%!important;
	align-self:center;
	
}

.payment_box.payment_method_rede_credit {
	padding: 0px!important;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: left;
}
#rede-card-expiry.wc-credit-card-form-card-expiry.jp-card-valid ,.jp-card-invalid {
	padding: 8px 6px 8px 6px !important;
width:100px;
}
#rede-card-cvc.wc-credit-card-form-card-cvc.jp-card-invalid, .jp-card-valid{
	padding: 8px 6px 8px 6px !important;
width:100px;
}

/*MENU VIEW ORDER*/
#progressbar {
    			font-family: jost,sans-serif;
          margin-bottom: 3vh;
          overflow: hidden;
          color: #4bb8a9;
          padding-left: 0px;
          margin-top: 3vh
      }

      #progressbar li {
          list-style-type: none;
          font-size: 0.8rem;
          width: 10%;
          float: left;
          position: relative;
          font-weight: 400;
          color: #4bb8a9
      }

      #progressbar #stepActive{
          color: #4bb8a9;
          margin-right: 0px !important;
          position: relative;
        	text-align: center;
      }
      #progressbar #stepActive:before {
          content: "";
          position: relative;
          color: #4bb8a9;
          width: 40px;
          height: 40px;
          margin-right: 0px !important;
        	z-index: 4 !important;
          background: #4bb8a9;
        	border: 10px solid #4bb8a9
      }

      #progressbar #stepInactive{
      	color: #989898;
        margin-right: 0px !important;
        text-align: center;
        position: relative;
      }
      #progressbar #stepInactive:before {
          content: "";
          color: rgb(151, 149, 149, 0.651);
          width: 40px;
          height: 40px;
        	margin-right: 0px !important;
        	z-index: 4 !important;
          background: #989898;
          border: 10px solid #989898;
          position: relative;
      }

      #progressbar li:before {
          line-height: 29px;
          display: block;
          font-size: 12px;
          background: rgb(151, 149, 149);
          border-radius: 50%;
          margin: auto;
        	margin-left:20%!important;
          z-index: -1;
          margin-bottom: 1vh
      }

      #progressbar li:after {
          content: '';
          height: 10px;
          background: #989898;
          position: absolute;
          left: 0%;
          right: 0%;
          margin-bottom: 2vh;
          top: 15px;
          z-index: 1;
      }

      .progress-track {
          padding: 0 8%
      }

      #progressbar li:nth-child:after {
          margin-right: auto
      }
      #progressbar li.active:after {
      		background: #4bb8a9
      }  

.woocommerce form .form-row .optional {
    visibility: hidden;
}

/*Retirada de itens no menu desktop*/
.main-navigation li.menu-item-14107, .main-navigation li.menu-item-15854, .main-navigation li.menu-item-15867, .main-navigation li.menu-item-19180{
	display: none;
}

.js .main-navigation>div>ul{
		display: flex!important;
    align-items: flex-end
}

.header-layout7 .header-content .container-fluid .kft_search_products{
	width: 175px;
}
/*caixa de frete no produto*/
.box-simulador{
margin-bottom: 25px;
border-radius:0px!important;
font-weight: 400;
}
.box-simulador h4{
	text-transform: uppercase;
	font-weight: bold;
}
.box-simulador .button.alt{
margin-right:15px;
margin-top:5px;
}

/* caixa de preços desktop*/

	.woocommerce div.product p.price{
		position: relative;
		display: flex;
		flex-direction: column;
		align-items: center;
		background-color: #f7f7f7;
		padding-top: 15px;
		padding-bottom: 1px;
    /*padding-left:15px;*/
		border-radius: 21px;
		box-shadow: 1px 2px 13px 0px;
		font-size: 1.88em !important;
		line-height: normal;
	}
	
	.woocommerce.single-product .single_variation_wrap .woocommerce-variation-price{
		text-align: center;
		width: 96%;
		margin-left: 2%;
		background-color: #f7f7f7;
		padding-top: 15px;
		padding-bottom: 1px;
		/*padding-left:15px;*/
		border-radius: 21px;
		box-shadow: 1px 2px 13px 0px;
		color: #999;
		font-size: 1.88em !important;
	}
	.woocommerce div.product-type-variable p.price{

		background-color: white !important;
		padding-top: 0px;
		border-radius: 0px !important;
		box-shadow: 0px 0px !important;
		display: block;
	}
	.woocommerce .wc-simulador-parcelas-detalhes-valor{
		font-size: x-large !important;
	}

/*
#menu-header-menu-2 li:first-child{
	display: none !important;
}

#menu-header-menu-1 li:first-child{
	display: none !important;
}
*/

.menu-header-menu-container{
	display: flex;
	flex-wrap: nowrap;
}

body .navigation-wrapper .main-navigation .menu>li a{
	font-size: 12px;
}

.woocommerce ul#shipping_method li label[for="shipping_method_0_advanced_free_shipping"]{
	font-weight: bold;
}

.menu-header-menu-container{
justify-content: center;	
}

.search-form-wrapper{
	margin-left:5px;
}

.woocommerce.cart-content .cart-collaterals .woocommerce.cart-content{
	display: none;
}

.kft-header-search{
	position: relative;
	left: 58%;
}

.top-bar-left-a{
	text-align: center;
}

.woocommerce table.cart .product-thumbnail, .woocommerce-page #content table.cart .product-thumbnail, .woocommerce-page table.cart .product-thumbnail{
	display: block;
}


.header-layout10 .header-account {
	margin-right: 20px !important;
}

.woocommerce .wc-proceed-to-checkout a.button.alt, .woocommerce .wc-proceed-to-checkout a.checkout-button{
	border-radius: 7px;
}

.woocommerce .wc-proceed-to-checkout a.button{
	border-radius: 7px;
}

.woocommerce table.cart td.actions .button, .woocommerce-page #content table.cart td.actions .button, .woocommerce-page table.cart td.actions .button{
	border-radius: 7px;
	width: 100%;
}

.checkout-login-coupon-wrapper{
	display: none;
}

.woocommerce-checkout #payment ul.payment_methods li img:first-child{
	display:none;
}

.woocommerce-checkout #payment ul.payment_methods li label[for="payment_method_loja5_woo_cielo_webservice"]{
	text-transform: uppercase
}

.woocommerce-checkout #payment ul.payment_methods li label[for="payment_method_gerencianet_oficial"]{
	text-transform: uppercase
}

.woocommerce .wc-simulador-parcelas-parcelamento-info.no-fee{
	font-style: normal;
	/*right: 5%;*/
	text-align: center;
}

input[type="email"]{
	border-radius:13px;
	box-shadow: 0px 0px 3px grey;
}

input.wpcf7-form-control.wpcf7-submit {
background-color: #7e4a22;
color: white;
border-radius:13px;
margin-left: 20px;
}

/* cart-ships */
.cart-collaterals .aviso01{
	display:none;
}
.cart-collaterals .aviso02{
	display:none;
}

.product-single-wrapper .amount{
	color: #937c5c;
}

.carousel-slider .owl-item{
	height: 200px !important;
} 
.carousel-slider-hero__cell__description{
	margin-top: 35% !important;
}

.carousel-slider-hero__cell{
	overflow: initial;
}

.carousel-slider.arrows-outside .owl-nav .owl-next, .carousel-slider.arrows-outside .owl-nav .owl-prev{
	display: none;
}

/*linha preço variavel*/
.woocommerce .entry-summary .wc-simulador-parcelas-parcelamento-info-container {
	margin-bottom:0px!important;
}

/*texto do meio do preço*/
.woocommerce .wc-simulador-parcelas-parcelamento-info.no-fee span:last-child{
	font-size:16px!important;
	font-weight:normal;
}

/*Remoção dos icones de cartão e pix*/
.woocommerce .entry-summary .wc-simulador-parcelas-parcelamento-info-container:before, .woocommerce .entry-summary .wc-simulador-parcelas-offer:before{
	display: none;
}

/*Ajuste no centro*/
.woocommerce .entry-summary .wc-simulador-parcelas-offer{
	padding-left: 0px;
}

/*Alinhamento central "no pix"*/
.woocommerce .wc-simulador-parcelas-detalhes-valor{
	text-align: center;
}

/*Alinhamento preços item*/
.woocommerce .product .item-information{
	text-align: center;
}

/*alinhando preços de produtos pra valer*/

.woocommerce .entry-summary .wc-simulador-parcelas-parcelamento-info-container {
    padding-left: 0px !important;
}

/*Espaço top produtos relacionados*/
.woocommerce.single-product .related.products h2{
	padding-top: 0px !important;
}

/*Layout da seção de cartão no checkout*/
#rede-card-animation .jp-card .jp-card-front .jp-card-shiny{
	top: 0px;
}

#rede-card-animation .jp-card .jp-card-front .jp-card-lower .jp-card-number{
	width:80%; 
	top: 0px; 
	font-size: 20px;
}

#rede-card-animation .jp-card .jp-card-front .jp-card-lower .jp-card-name{
	top: 80%;
}

#payment .payment_methods li .payment_box .wc-credit-card-form-card-number.mastercard{
	background-size: 0px;
}

/*Variação de produto maior*/
.variable-item:not(.radio-variable-item){
	width: 70px;
	height: 70px;
}

.woo-variation-swatches .variable-items-wrapper{
	display: flex;
	flex-wrap: wrap;
	margin: 0!important;
	padding: 0;
	list-style: none;
	justify-content: center;
}

form.variations_form.cart.wvs-load table.variations tbody tr{
	display: flex;
	flex-direction: column;
	flex-wrap: nowrap;
	align-content: center;
	justify-content: center;
	align-items: center;
}

.woocommerce div.product form.cart .variations td{
	display: flex;
	flex-direction: column;
}

.woocommerce div.product form.cart .variations .label{
	display: flex;
	flex-direction: row;
}

.woo-variation-swatches .variable-items-wrapper{
	display: flex;
	justify-content: center;
}

.woocommerce div.product form.cart .variations label, .woocommerce-page div.product form.cart .variations label{
	font-size: 21px !important;
	text-transform: none;
}

/*Teste variação*/
[data-wvstooltip]:hover:after,[data-wvstooltip]:hover:before{
	bottom: -60%;
}
[data-wvstooltip]:before {
	min-width: 0px;
	padding: 5px;
	font-size: 21px;
}
[data-wvstooltip]:after{
	margin-left: 0px;
	border: 0px !important;
}
.woo-variation-swatches.wvs-style-rounded .variable-items-wrapper .variable-item{
	border-radius: 0px;
}

.woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected{
	box-shadow: 0 0 0 3px rgb(126 74 34);
	margin: 4px 8px 4px 0;
  padding: 0px;
  border-radius: 2px;
} 

.woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item).selected:hover{
	box-shadow: 0 0 0 3px rgb(126 74 34);
	margin: 4px 8px 4px 0;
  padding: 0px;
  border-radius: 2px;
} 

.woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item){
	box-shadow: 0 0 0 1px rgb(147 124 92);
	margin: 4px 8px 4px 0;
  padding: 0px;
  border-radius: 2px;
}

.woo-variation-swatches .variable-items-wrapper .variable-item:not(.radio-variable-item):hover{
	box-shadow: 0 0 0 3px rgb(147 124 92);
	margin: 4px 8px 4px 0;
  padding: 0px;
  border-radius: 2px;
}

span.woo-selected-variation-item-name{
	color: #000!important;
font-size: 19px;
}

/*MINIATURA DA VARIAÇÃO DESIGN 1*/
//esconde variacao descanso
/*.variations option:invalid {
  display:none!important;
}*/

/*MANTER MENU ABERTO*/
@media only screen and (max-width: 476px){
.current-menu-ancestor > a, .current-menu-parent > a,
.current-menu-item>a { 
    background-color: #F77358 !important;
	color: white !important;
	display: block !important;
		}
	.mobile-menu-wrapper .sub-menu ul{
		display: block !important;
	}
	.sub-menu-icon, 
	.mobile-menu-wrapper .menu-item-has-children.active>.sub-menu-icon{
		top: 1px !important;
	}	
}

.rtwpvs.rtwpvs-squared .rtwpvs-terms-wrapper .rtwpvs-term{
	left: 3px;
}

.rtwpvs.rtwpvs-squared .rtwpvs-terms-wrapper .rtwpvs-term:hover{
	box-shadow: 0 0 0 1px rgb(147 124 92);
}

.rtwpvs .rtwpvs-terms-wrapper .rtwpvs-term:not(.rtwpvs-radio-term).selected{
	box-shadow: 0 0 0 1px rgb(126 74 34);
}

.rtwpvs .rtwpvs-terms-wrapper .rtwpvs-term:not(.rtwpvs-radio-term).selected:hover{
	box-shadow: 0 0 0 1px rgb(126 74 34);
}

.rtwpvs.rtwpvs-squared .rtwpvs-terms-wrapper .rtwpvs-term .out-of-stock{
	display: none !important;
}
/*mobile query*/
@media only screen and (max-width: 374px){
	
	.header-mobile-center .logo-wrap{
		transform: translateX(20%);
	}
	
	.logo-wrap{
	transform: translateX(0%);
}
	
	.related.products .products.owl-carousel.owl-loaded.owl-drag.loaded .owl-stage-outer .owl-stage{
		display: flex;
    flex-wrap: wrap;
		width: auto !important;
	}
	
	.related.products .products.owl-carousel.owl-loaded.owl-drag.loaded .owl-stage-outer .owl-stage .owl-item {
		width: 109px!important;
		margin-right: 20px !important;
    margin-left: 16px !important;
	}
	
	.kft-mobile-navigation .kft-list-products li{
		position: relative;
		z-index: 3;
		background-color: white;
	}
	
	.kft-mobile-navigation .kft-list-products{
		position: absolute;
		z-index: 3;
	}
	
	.mobile-menu-wrapper ul li.menu-item-14107{
		text-align:center!important;
		transform: translatey(-55px)!important;
	}
	
	.mobile-menu-wrapper ul li.menu-item-15854{
	display: block !important;
	transform: translatey(-80px)!important;
	border-bottom: 1px solid #ebe9eb!important;
	position: relative!important;
	z-index: 10!important;
}
	
	.mobile-menu-wrapper ul li.menu-item-15867{
	display: block !important;
	transform: translate(180px, -132px)!important;
	border-bottom: 1px solid #ebe9eb!important;
		position: relative!important;
		z-index: 10;
}
	
/*Ajuste de altura nos itens do menu mobile*/
.mobile-menu-wrapper ul li.menu-item-7503, .mobile-menu-wrapper ul li.menu-item-11547, .mobile-menu-wrapper ul li.menu-item-14311, .mobile-menu-wrapper ul li.menu-item-13717, .mobile-menu-wrapper ul li.menu-item-13721, .mobile-menu-wrapper ul li.menu-item-13722, .mobile-menu-wrapper ul li.menu-item-19180{
		display: block;
		position: relative;
		transform: translatey(-55px);
	}
	
	.kft-mobile-navigation .kft_search_products{
		top: 5px;
	}
	
	.admin-bar .kft-mobile-navigation .search-form-wrapper{
		position: relative;
		z-index: 5;
		transform: translateY(50px);
		background-color: transparent;
	}
	
	.kft-mobile-navigation .search-form-wrapper{
		position: relative;
		z-index: 5;
		transform: translateY(50px);
		background-color: transparent;
	}
	
	.kft-mobile-navigation .search-form-wrapper input[type=text]{
		border-radius: 21px;
	}
	
	.kft-mobile-navigation .kft-list-products{
		max-height: 300px;
		border: 1px solid #e5e5e5;
    border-radius: 21px;
	}
	
	.carousel-slider-hero__cell__description{
	margin-top: 325% !important;
}
	
}

@media only screen and (max-width: 500px){
	.header-mobile-center .logo-wrap{
		transform: translateX(20%);
	}
	.carousel-slider-hero__cell__description{
	margin-top: 255% !important;
}
}

@media only screen and (min-width: 375px) and (max-width: 800px){
	
	#loginuser .form-row{
		 padding: 10px 50px!important; 
		 text-align: center;
	}
	
	
	.logo-wrap{
	transform: translateX(0%);
}
	
	.related.products .products.owl-carousel.owl-loaded.owl-drag.loaded .owl-stage-outer .owl-stage{
		display: flex;
    flex-wrap: wrap;
		width: auto !important;
	}
	
	.related.products .products.owl-carousel.owl-loaded.owl-drag.loaded .owl-stage-outer .owl-stage .owl-item {
		width: 136px!important;
		margin-right: 20px !important;
    margin-left: 16px !important;
	}
	
	body.kc-css-system .kc-css-342550{
		margin-top: 0px!important;
	}
	
	.image_fadein_slider img.active{   		left: -7px !important;
	}
	
	.image_fadein_slider img{
		left: -7px !important;
	}
	
	.kft-mobile-navigation .kft-list-products li{
		position: relative;
		z-index: 3;
		background-color: white;
	}
	
	.kft-mobile-navigation .kft-list-products{
		position: absolute;
		z-index: 3;
	}
	
	.mobile-menu-wrapper ul li.menu-item-15854{
	display: block !important;
	transform: translatey(-80px);
	border-bottom: 1px solid #ebe9eb;
	position: relative;
	z-index: 10;
}
	
	.mobile-menu-wrapper ul li.menu-item-15867{
	display: block !important;
	transform: translate(180px, -132px);
	border-bottom: 1px solid #ebe9eb;
		position: relative;
		z-index: 10;
}
	
	.mobile-menu-wrapper ul li.menu-item-14107{
		text-align:center;
		transform: translatey(-55px);
	}
	
	.mobile-menu-wrapper ul li.menu-item-7503, .mobile-menu-wrapper ul li.menu-item-11547, .mobile-menu-wrapper ul li.menu-item-14311, .mobile-menu-wrapper ul li.menu-item-13717, .mobile-menu-wrapper ul li.menu-item-13721, .mobile-menu-wrapper ul li.menu-item-13722, .mobile-menu-wrapper ul li.menu-item-19180{
		display: block;
		position: relative;
		transform: translatey(-55px);
	}
	
	.kft-mobile-navigation .kft_search_products{
		top: 5px;
	}
	
	.admin-bar .kft-mobile-navigation .search-form-wrapper{
		position: relative;
		z-index: 5;
		transform: translateY(50px);
		background-color: transparent;
	}
	
	.kft-mobile-navigation .search-form-wrapper{
		position: relative;
		z-index: 5;
		transform: translateY(50px);
		background-color: transparent;
	}
	
	.kft-mobile-navigation .search-form-wrapper input[type=text]{
		border-radius: 21px;
	}
	
	.kft-mobile-navigation .kft-list-products{
		max-height: 300px;
		border: 1px solid #e5e5e5;
    border-radius: 21px;
	}
	
	
	.woocommerce-order-details a button{
		margin-left: 20% !important;
	}
	
      #progressbar li {
          list-style-type: none;
          font-size: 0.8rem;
					line-height:1.6;
          width: 15%;
          float: left;
          position: relative;
          font-weight: 400;
          color: #4bb8a9
      }

      #progressbar #stepActive{
          color: #4bb8a9;
          margin-right: 0px !important;
					width:70px;
          position: relative;
        	text-align: center;
      }
      #progressbar #stepActive:before {
          content: "";
          position: relative;
          color: #4bb8a9;
          width: 40px;
          height: 40px;
          margin-right: 0px !important;
        	z-index: 4 !important;
          background: #4bb8a9;
        	border: 5px solid #4bb8a9
      }

      #progressbar #stepInactive{
      	color: #989898;
        margin-right: 0px !important;
				width:70px;
        text-align: center;
        position: relative;
      }
      #progressbar #stepInactive:before {
          content: "";
          color: rgb(151, 149, 149, 0.651);
          width: 40px;
          height: 40px;
        	margin-right: 0px !important;
        	z-index: 4 !important;
          background: #989898;
          border: 5px solid #989898;
          position: relative;
      }

      #progressbar li:before {
          line-height: 29px;
          display: block;
          font-size: 12px;
          background: rgb(151, 149, 149);
          border-radius: 50%;
          margin: auto;
        	margin-left:20%!important;
          z-index: -1;
          margin-bottom: 1vh
      }

      #progressbar li:after {
          content: '';
          height: 10px;
          background: #989898;
          position: absolute;
          left: 0%;
          right: 0%;
          margin-bottom: 2vh;
          top: 15px;
          z-index: 1;
      }

      .progress-track {
          padding: 0 8%
      }

      #progressbar li:nth-child:after {
          margin-right: auto
      }
      #progressbar li.active:after {
      		background: #4bb8a9
      }	
}

.woocommerce form .form-row input.input-text{
	border-radius: 21px;
}

/*.woocommerce form .form-row{
		display: flex;
    flex-direction: column;
		align-items: center;
		position: relative;
    left: 40%;
}*/

.woocommerce form .password-input, .woocommerce-page form .password-input{
	width: 100%;
}



/*mobile query*/
@media only screen and (max-width: 800px){

	.woocommerce div.product p.price{
		margin: 20px 0px 20px 0px !important;
	}
	
/* Texto centralizado mobile */
	.woocommerce .wc-simulador-parcelas-parcelamento-info.no-fee{
		/*right: 10%;*/
	}
	
	
	.sticky-header .logo-sticky-enable .logo-nomal{
		display:none;
	}
	
	.sticky-header .logo-sticky-enable .logo-sticky{
		display:block;
	}
	
	.sticky-header .logo-sticky-enable .logo-sticky img{
		transform: translateX(-20%);
	}
	
	.woocommerce .related.products.owl-item active, .woocommerce .related.products.owl-item{
	width:140px!important;
}
	
	
	body .owl-carousel .owl-nav button.owl-prev{
		background-color:#fff;
		margin-left:10%;
	}
	
	.woocommerce table.shop_table_responsive tr, .woocommerce-page table.shop_table_responsive tr{
		padding: 10px;
		border: 0px solid #9C9C9C;
		margin-top: 10px;
		border-radius: 7px;
		background-color: #F7F7F7;
		box-shadow: 0px 1px 7px grey;
	}
	
	body .owl-carousel .owl-nav button.owl-next{
		background-color:#fff;
		margin-right:10%;
	}
	.mobile-menu-wrapper .sub-menu li ul {
    text-transform: none;
    font-weight: normal;
    margin-left: 30px;
}
	div.products.js_animated div.product.animated{
		width: 50%;
	}
	.woocommerce .products .product, .woocommerce-page .products .product, #right-sidebar .product_list_widget li{
		width: 50%;
	}
	
	.woocommerce div.product span.price {
    /* font-size: 14px; */
    font-size: 0.85em;
}
	.woocommerce-cart table.cart img {
    width: 800px;
}
	.woocommerce .cart-content table.shop_table td {
    padding: 0px;
    
}
.woocommerce-orders-table__cell.woocommerce-orders-table__cell-tracking{
		display:none !important;
}
	
	.woocommerce div.product p.price{
		background-color: #f7f7f7;
		padding-top: 15px;
		border-radius: 21px;
		box-shadow: 1px 2px 13px 0px;
		font-size: 1.88em !important;
		line-height: normal;
		
	}
	
	.woocommerce.single-product .single_variation_wrap .woocommerce-variation-price{
		background-color: #f7f7f7;
		padding-top: 15px;
		padding-bottom: -15px;
		border-radius: 21px;
		box-shadow: 1px 2px 13px 0px;
		color: #999;
		font-size: 1.88em !important;
	}
	.woocommerce div.product-type-variable p.price{
		background-color: white !important;
		padding-top: 0px;
		border-radius: 0px !important;
		box-shadow: 0px 0px !important;
	}
	.woocommerce .wc-simulador-parcelas-detalhes-valor{
		font-size: x-large !important;
	}
	
	div.product .single_variation_wrap .amount{
		line-height: normal;
		font-size: 28.2px;
	}
	.single-product .entry-summary .price{
		margin-top: 0px !important;
		margin-bottom: 0px !important;
	}
	
	.woocommerce .wc-simulador-parcelas-parcelamento-info.no-fee span:last-child{
		font-size: 16px !important;
		font-weight: normal;
	}
	.carousel-slider-hero__cell__description{
	margin-top: 35% !important;
}
	
}

@media only screen and (max-width: 400px){
	.woocommerce div.product p.price{
		position: relative;
		display: flex;
		flex-direction: column;
		align-items: center;
		font-size: 1.88em !important;
		line-height: normal;
	}
	
	.woocommerce div.product-type-variable p.price{
		display: flex;
		flex-direction: row;
    justify-content: center;
		font-size: 1.8em !important;
	}
	
	.woocommerce.single-product .single_variation_wrap .woocommerce-variation-price{
		position: relative;
		display: flex; /*flex*/
    align-items: center;
    flex-direction: column;
		text-align: center;
		/*padding-left: 7px;*/
    padding-bottom: 5px;
	}
	
	.product-type-variable .woocommerce-variation-price .wc-simulador-parcelas-offer:before{
		left: 15%;
	}
}

@media only screen and (min-width: 401px) and (max-width: 768px){
	.woocommerce div.product p.price{
		position: relative;
		display: flex;
		flex-direction: column;
		align-items: center;
		font-size: 1.88em !important;
		line-height: normal;
	}
	.woocommerce div.product-type-variable p.price{
		display: flex;
		flex-direction: row;
    justify-content: center;
		font-size: 1.88em !important;
	}
	.woocommerce.single-product .single_variation_wrap .woocommerce-variation-price{
		position: relative;
		display: flex;/*flex*/
    align-items: center;
    flex-direction: column;
		text-align: center;
	}
	.product-type-variable .woocommerce-variation-price .wc-simulador-parcelas-offer:before{
		left: 15%;
	}
}

@media only screen and (min-width: 500px){
	.woocommerce #verificacao{
		width: 56%;
		border: 0px;
		border-radius: 21px;
	}
	.woocommerce .col2-set .col-1, .woocommerce .col2-set .col-2, .woocommerce-page .col2-set .col-1, .woocommerce-page .col2-set .col-2{
		width: 56%;
		border: 0px;
		border-radius: 21px;
	}
}

@media only screen and (max-width: 500px){
	/*.woocommerce form .form-row{
		display: flex;
    flex-direction: column;
		align-items: center;
		position: relative;
    left: 0%!important;
}*/
}
@media only screen and (max-width: 730px){
	.carousel-slider-hero__cell__description{
	margin-top: 155% !important;
	}
}
@media only screen and (max-width: 768px){
	/*Caixa de pagamento maior no mobile*/
	.woocommerce-checkout #payment{
		width: 109.5%;
    transform: translateX(-31px);
	}
}
@media only screen and (max-width: 560px){
	.carousel-slider-hero__cell__description{
	margin-top: 155% !important;
	}
}

@media only screen and (min-width: 425px) and (max-width: 560px){
	/*Caixa de pagamento maior no mobile*/
	.woocommerce-checkout #payment{
		width: 119%;
    transform: translateX(-31px);
	}
	/*DIMINUIR ESPAÇOS*/
	.woocommerce-checkout #payment div.payment_box .form-row{
		padding: 0em 1em;
	}
	.icon-rede-input {
		top: 25px;
	}
}

@media only screen and (max-width: 424px){
	.carousel-slider-hero__cell__description{
	margin-top: 195% !important;
	}
	/*Caixa de pagamento maior no mobile*/
	.woocommerce-checkout #payment{
		width: 122%;
    transform: translateX(-31px);
	}
	/*DIMINUIR ESPAÇOS*/
	.woocommerce-checkout #payment div.payment_box .form-row{
		padding: 0em 1em;
	}
	.icon-rede-input {
		top: 25px;
	}
}
@media only screen and (max-width: 374px){
	.carousel-slider-hero__cell__description{
	margin-top: 205% !important;
	font-size: 11px;
	}
	/*Caixa de pagamento maior no mobile*/
	.woocommerce-checkout #payment{
		width: 127%;
    transform: translateX(-31px);
	}
	/*DIMINUIR ESPAÇOS*/
	.woocommerce-checkout #payment div.payment_box .form-row{
		padding: 0em 1em;
	}
	.icon-rede-input {
		top: 25px;
	}
}
/* Centralização de preço mobile */
/*@media only screen and (min-width: 376px){
	.woocommerce .wc-simulador-parcelas-parcelamento-info.no-fee{
	width: 22em; 
	right: 5%;
	}
}*/


";s:10:"post_title";s:11:"mipro-child";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:6:"closed";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:11:"mipro-child";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2022-05-25 20:24:36";s:17:"post_modified_gmt";s:19:"2022-05-25 23:24:36";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:45:"http://34.196.236.239/2021/02/11/mipro-child/";s:10:"menu_order";i:0;s:9:"post_type";s:10:"custom_css";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}}