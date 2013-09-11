MJax.BS = {};
MJax.BS.ScrollTo = function(mixSelector){
	 $('html, body').animate({
            scrollTop: ($(mixSelector).offset().top - 75)
     },
     700,
     function(){

         $('.nav > li').removeClass('active');
         var jSelected = $('.nav > li a[href="'+ mixSelector + '"]');
         jSelected.parent().addClass('active');
     });
};
MJax.Alert = MJax.BS.Alert = function(strHtml){
	var jModal = $('#divModal');
	jModal.find('#pBody').html(strHtml);
	jModal.modal('show');
};
MJax.BS.HideAlert = function(strHtml){
	var jModal = $('#divModal');
	jModal.modal('hide');
};
MJax.BS.CtlAlert = function(mixEle, strHtml, strType){
	
	var jEle = $(mixEle);
	var jAlert = $('<div class="alert mlc-bs-alert"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
	if(typeof(strType) != 'undefined'){
		jAlert.addClass('alert-' + strType);
	}
	jAlert.append(strHtml);
	jEle.before(jAlert);
};
MJax.BS.ClearCtlAlerts = function(){
	$('.mlc-bs-alert').remove();
}
MJax.BS.AnimateOpen = function(mixEle){
	var jEle = $(mixEle);
	
	var intHeight = jEle.attr('data-orig-height');
	if(typeof intHeight == 'undeifined'){
		return console.log("Error: No original height found");
	}
	jEle.animate({
            height: intHeight
    }, 2000, function(){
    	$(this).css('height', 'auto');
    });
    MJax.BS.ScrollTo(jEle);
}
MJax.BS.AnimateClosed = function(mixEle){
	var jEle = $(mixEle);
	var intHeight = jEle.height();
	jEle.attr('data-orig-height', intHeight);
	if(typeof intHeight == 'undeifined'){
		return console.log("Error: No original height found");
	}
	jEle.animate({
            height: 0
    }, 2000);
   // MJax.BS.ScrollTo(jEle);
}

//Init stuff

$(function(){
	$('body').on(
		'click',
		'[data-mlc-scroll]',
		function(){
			var strTo = $(this).attr('data-mlc-scroll');
			MJax.BS.ScrollTo(strTo);
			return false;
		}
	);
	$('.mjax-bs-animate-hiden').each(
		function(){
			var jThis = $(this);
            var intHeight = jThis.attr('data-orig-height');
            if(typeof intHeight == 'undefined'){
                jThis.attr('data-orig-height', jThis.height());
            }
			jThis.css('height', '0Px')
			.css('overflow','hidden');			
		}
	);
    $(document).on('mjax-page-load', function(){
        $('[data-spy="scroll"]').each(function () {
            var $spy = $(this).scrollspy('refresh')
        });


    });
    $(document).on('mjax-ajax-response', function(){

        //Hide all alerts
        $('.mlc-bs-alert').remove();

    });
    $.fn.typeahead.Constructor.prototype.render = function (items) {
        var that = this

        items = $(items).map(function (i, item) {
            i = $(that.options.item).attr('data-value', item.value)
            i.attr('data-text', item.text)
            i.find('a').html(that.highlighter(item.text))
            return i[0]
        })

        items.first().addClass('active')
        this.$menu.html(items)
        return this
    }
    $.fn.typeahead.Constructor.prototype.process = function (items) {
        return this.render(items).show();
        var that = this

        /*items = $.grep(items, function (item) {
            return that.matcher(item)
        })

        items = this.sorter(items)

        if (!items.length) {
            return this.shown ? this.hide() : this
        }

        return this.render(items.slice(0, this.options.items)).show()*/
    }
    $.fn.typeahead.Constructor.prototype.select =  function () {
        var val = this.$menu.find('.active').attr('data-value');
        var text = this.$menu.find('.active').attr('data-text');
        this.$element
            .val(this.updater(text))
            .change();
        $('#' + this.$element.attr('data-real-id')).val(val).change();
        return this.hide()
    }
})


