
(function($, ex)
{
	var settings = {
        inEffect: 			{opacity: 'show'},	// in effect
        inEffectDuration: 	400,				// in effect duration in miliseconds
        stayTime: 			4000,				// time in miliseconds before the item has to disappear
        text: 				'',					// content of the item
        sticky: 			false,				// should the notify item sticky or not?
        type: 				'info', 			// info, warning, error, success
        position:           'top-right',        // top-right, center, middle-bottom ... Position of the notify container holding different notify. Position can be set only once at the very first call, changing the position after the first call does nothing
        closeText:          '<span aria-hidden="true">&times;</span>',                 // text which will be shown as close button, set to '' when you want to introduce an image via css
        close:              null                // callback function when the notifymessage is closed
    };

    var methods = {
        init : function(options){
			if (options) {
                $.extend( settings, options );
            }
		},

        show : function(options){
			var localSettings = {};
            $.extend(localSettings, settings, options);

			// declare variables
            var wrapAll, outer, inner, close, icon;

			wrapAll	= (!$('.notify-container').length) ? $('<div></div>').addClass('notify-container').addClass('notify-position-' + localSettings.position).appendTo('body') : $('.notify-container');
			outer	= $('<div></div>').addClass('notify-item-wrapper');
			inner	= $('<div></div>').hide().addClass('notify-item notify-type-' + localSettings.type).appendTo(wrapAll).html('<p>'+localSettings.text+'</p>').animate(localSettings.inEffect, localSettings.inEffectDuration).wrap(outer);
            close = $('<div></div>').addClass('notify-item-close').prependTo(inner).html(localSettings.closeText).click(function () {
                ExtendJS.notify('removeNotify', inner, localSettings)
            });
			icon  = $('<div></div>').addClass('notify-item-image').addClass('notify-item-image-' + localSettings.type).prependTo(inner);

            if(navigator.userAgent.match(/MSIE 6/i)){
		    	wrapAll.css({top: document.documentElement.scrollTop});
		    }

			if(!localSettings.sticky){
				setTimeout(function(){
					ExtendJS.notify('removeNotify', inner, localSettings);
				},
				localSettings.stayTime);
			}
            return inner;
		},

        info : function (message){
            var options = {text : message, type : 'info'};
            return ExtendJS.notify('show', options);
        },

        success : function (message){
            var options = {text : message, type : 'success'};
            return ExtendJS.notify('show', options);
        },

        error : function (message){
            var options = {text : message, type : 'error'};
            return ExtendJS.notify('show', options);
        },

        warning : function (message){
            var options = {text : message, type : 'warning'};
            return ExtendJS.notify('show', options);
        },

		removeNotify: function(obj, options){
			obj.animate({opacity: '0'}, 600, function(){
				obj.parent().animate({height: '0px'}, 300, function(){
					obj.parent().remove();
				});
			});
            // callback
            if (options && options.close !== null) {
                options.close();
            }
		}
	};

    ex.notify = function( method ) {
        // Method calling logic
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.notify' );
        }
    };

})(jQuery, ExtendJS);