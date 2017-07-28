
(function($, ex)
{
	var settings = {
        inEffect: 			{opacity: 'show'},	// in effect
        inEffectDuration: 	400,				// in effect duration in miliseconds
        stayTime: 			5000,				// time in miliseconds before the item has to disappear
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
            var container, outer, inner, close, icon;

			container   = (!$('.notify-container').length) ? $('<div></div>').addClass('notify-container').addClass('notify-position-' + localSettings.position).appendTo('body') : $('.notify-container');
			outer	    = $('<div></div>').addClass('notify-item-wrapper');
			inner	    = $('<div></div>').hide().addClass('notify-item notify-type-' + localSettings.type).appendTo(container).html('<p>'+localSettings.text+'</p>').animate(localSettings.inEffect, localSettings.inEffectDuration).wrap(outer);
            close       = $('<div></div>').addClass('notify-item-close').prependTo(inner).html(localSettings.closeText).click(function () {
                notify_handler('removeNotify', inner, localSettings)
            });
			icon  = $('<div></div>').addClass('notify-item-image').addClass('notify-item-image-' + localSettings.type).prependTo(inner);

            if(navigator.userAgent.match(/MSIE 6/i)){
		    	container.css({top: document.documentElement.scrollTop});
		    }

			if(!localSettings.sticky){
				setTimeout(function(){
					notify_handler('removeNotify', inner, localSettings);
				},
				localSettings.stayTime);
			}
            return inner;
		},

        info : function (options){
            var options = {text : options.message, type : 'info'};
            return notify_handler('show', options);
        },

        success : function (options){
            var options = {text : options.message, type : 'success'};
            return notify_handler('show', options);
        },

        error : function (options){
            var options = {text : options.message, type : 'error'};
            return notify_handler('show', options);
        },

        warning : function (options){
            var options = {text : options.message, type : 'warning'};
            return notify_handler('show', options);
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

    notify_handler = function (method) {
        if ( methods[method] ) {
          return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
          return methods.init.apply( this, arguments );
        }
    };
    
    ExtendmeJS.notify = function (message, type, time) {
        var attr = {
            message: message,
            position: settings.position,
            sticky: settings.sticky,
            stayTime: time ? time : settings.stayTime,
            type: type ? type : 'info',
        }; 
        
        if (time === true) {
            attr.stayTime = settings.stayTime;
            attr.sticky = true;
        }
        methods[ 'init' ](attr);
        return methods[ type ](attr);
    };
  

})(jQuery);