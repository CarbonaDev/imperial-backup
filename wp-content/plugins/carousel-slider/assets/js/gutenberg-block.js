(()=>{"use strict";var e={n:l=>{var r=l&&l.__esModule?()=>l.default:()=>l;return e.d(r,{a:r}),r},d:(l,r)=>{for(var t in r)e.o(r,t)&&!e.o(l,t)&&Object.defineProperty(l,t,{enumerable:!0,get:r[t]})},o:(e,l)=>Object.prototype.hasOwnProperty.call(e,l)};(()=>{const l=React;var r=e.n(l);const t=wp.blocks,s=wp.components,a=wp.blockEditor,o=window.i18nCarouselSliderBlock||{sliders:[],site_url:"",block_logo:"",block_title:"",select_slider:""};(0,t.registerBlockType)("carousel-slider/slider",{title:o.block_title,icon:"slides",category:"common",attributes:{sliderID:{type:"integer",default:0}},edit:e=>{let l=e.attributes.sliderID,t=[];l||(l="");let i=new URL(o.site_url);i.searchParams.append("carousel_slider_preview","1"),i.searchParams.append("carousel_slider_iframe","1"),i.searchParams.append("slider_id",l);let c=i.toString();const n=r().createElement(s.SelectControl,{label:o.select_slider,value:l,options:o.sliders,onChange:l=>{e.setAttributes({sliderID:parseInt(l)})}});let d=r().createElement("div",{className:"carousel-slider-iframe-container"},r().createElement("div",{className:"carousel-slider-iframe-overlay"}),r().createElement("iframe",{className:"carousel-slider-iframe",scrolling:"no",src:c,height:"0",width:"500"})),u=r().createElement("div",{className:"carousel-slider-editor-controls"},r().createElement("img",{className:"carousel-slider-editor-controls__logo",src:o.block_logo,alt:""}),r().createElement("div",{className:"carousel-slider-editor-controls__title"},o.block_title),r().createElement("div",{className:"carousel-slider-editor-controls__input"},n)),m=r().createElement(a.InspectorControls,null,r().createElement("div",{className:"carousel-slider-inspector-controls"},n));return""===l?t.push(u):t.push(d),t.push(m),[t]},save:e=>{let{attributes:l}=e;return l.sliderID?r().createElement("div",null,`[carousel_slide id='${l.sliderID}']`):""}})})()})();