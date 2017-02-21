(function($,window,document,undefined){'use strict';var gridContainer=$('#grid-portfolio'),filtersContainer=$('#filters-portfolio'),wrap,filtersCallback;gridContainer.cubeportfolio({defaultFilter:'*',animationType:'flipOutDelay',gapHorizontal:35,gapVertical:30,gridAdjustment:'responsive',caption:'overlayBottomReveal',displayType:'lazyLoading',displayTypeSpeed:100,lightboxDelegate:'.cbp-lightbox',lightboxGallery:true,lightboxTitleSrc:'data-title',lightboxCounter:'<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',singlePageDelegate:'.cbp-singlePage',singlePageDeeplinking:true,singlePageStickyNavigation:true,singlePageCounter:'<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',singlePageCallback:function(url,element){window.location=url;var t=this;},singlePageInlineDelegate:'.cbp-singlePageInline',singlePageInlinePosition:'above',singlePageInlineInFocus:true,singlePageInlineCallback:function(url,element){}});if(filtersContainer.hasClass('cbp-l-filters-dropdown')){wrap=filtersContainer.find('.cbp-l-filters-dropdownWrap');wrap.on({'mouseover.cbp':function(){wrap.addClass('cbp-l-filters-dropdownWrap-open');},'mouseleave.cbp':function(){wrap.removeClass('cbp-l-filters-dropdownWrap-open');}});filtersCallback=function(me){wrap.find('.cbp-filter-item').removeClass('cbp-filter-item-active');wrap.find('.cbp-l-filters-dropdownHeader').text(me.text());me.addClass('cbp-filter-item-active');wrap.trigger('mouseleave.cbp');};}else{filtersCallback=function(me){me.addClass('cbp-filter-item-active').siblings().removeClass('cbp-filter-item-active');};}
filtersContainer.on('click.cbp','.cbp-filter-item',function(){var me=$(this);if(me.hasClass('cbp-filter-item-active')){return;}
if(!$.data(gridContainer[0],'cubeportfolio').isAnimating){filtersCallback.call(null,me);}
gridContainer.cubeportfolio('filter',me.data('filter'),function(){});});gridContainer.cubeportfolio('showCounter',filtersContainer.find('.cbp-filter-item'),function(){var match=/#cbpf=(.*?)([#|?&]|$)/gi.exec(location.href),item;if(match!==null){item=filtersContainer.find('.cbp-filter-item').filter('[data-filter="'+ match[1]+'"]');if(item.length){filtersCallback.call(null,item);}}});$('.cbp-l-loadMore-button-link').on('click.cbp',function(e){e.preventDefault();var clicks,me=$(this),oMsg;if(me.hasClass('cbp-l-loadMore-button-stop')){return;}
clicks=$.data(this,'numberOfClicks');clicks=(clicks)?++clicks:1;$.data(this,'numberOfClicks',clicks);oMsg=me.text();me.text('LOADING...');$.ajax({url:me.attr('href'),type:'GET',dataType:'HTML'}).done(function(result){var items,itemsNext;items=$(result).filter(function(){return $(this).is('div'+'.cbp-loadMore-block'+ clicks);});gridContainer.cubeportfolio('appendItems',items.html(),function(){me.text(oMsg);itemsNext=$(result).filter(function(){return $(this).is('div'+'.cbp-loadMore-block'+(clicks+ 1));});if(itemsNext.length===0){me.text('NO MORE WORKS');me.addClass('cbp-l-loadMore-button-stop');}});}).fail(function(){});});})(jQuery,window,document);