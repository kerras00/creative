/**
 *
 * @copyright   © 2017 Brayan Rincon
 * @version     1.0.1
 * @author      Brayan Rincon <brayan262@gmail.com>
 */
var ExtendmeJS = (function() {
    return {
        version: '1.0.1',

        author: 'Brayan Rincon <brincon@megacreativo.com>',

        initialize: function() {
            return true;
        },

        extend: function(destination, source) {
            for (var property in source) {
                destination[property] = source[property];
            }
            return destination;
        },

        me: function(source) {
            for (var property in source) {
                this[property] = source[property];
            }
            return this;
        },

        path : ''
    };
}(typeof window !== "undefined" ? window : this));


/**
 *  Especifica o asigna una variable de tipo Object
 *  @Const
 *  @type {object}
 **/
var _abstract_ = {};

/** Contiene los tipos de Objetos. */
var _type_ = {

    /** Indica que el tipo de un objeto Null. @type {string} null */
    'null': 'null',

    /** Indica que el tipo de un objeto es Boolean. @type {string} boolean */
    'bool': 'boolean',

    /** Indica que el tipo de un objeto es Boolean. @type {string} boolean */
    'boolean': 'boolean',

    /** Indica que el tipo de un objeto es Number. @type {string} number */
    'number': 'number',

    /** Indica que el tipo de un objeto es String. @type {string} string */
    'string': 'string',

    /** Indica que el tipo de un objeto es Object. @type {string} object */
    'object': 'object',

    /** Indica que el tipo de un objeto es [object Boolean]. @type {string} [object Boolean] */
    'boolean_class': '[object Boolean]',

    /** Indica que el tipo de un objeto es [object Number]. @type {string} [object Number] */
    'number_class': '[object Number]',

    /** Indica que el tipo de un objeto es [object String]. @type {string} [object String] */
    'string_class': '[object String]',

    /** Indica que el tipo de un objeto es [object Object]. @type {string} [object Object] */
    'object_class': '[object Object]',

    /** Indica que el tipo de un objeto es Function. @type {string} Function */
    'function': Function
};



//Windows
(function (Global) {
    
    var extendme = function(source) {
        for (var property in source) {
            this[property] = source[property];
        }
        return this;
    }    
    ExtendmeJS.extend(Global, { extend: extendme });
        
    var object_proto = Object.prototype,
        array_proto = Array.prototype,
        number_proto = Number.prototype,
        string_proto = String.prototype,
        procedure = new Function("return false;");



    /**
     *  Devuelve un valor Boolean que indica si un objeto es una instancia de una clase concreta.
     *  @param {object} Pattern Obligatorio. Cualquier expresión de objeto. 
     *  @param {object} Type Cualquier clase de objeto definida.
     *  @return {boolean}
     **/
    var isInstance = function(Pattern, Type) {
        return (Pattern instanceof Type);
    };

    /**
     *  Devuelve un valor Boolean que indica el Objeto Pattern e del tipo del dato especificado y Type.
     *  @param {object} Pattern Obligatorio. Cualquier expresión de objeto. 
     *  @param {object} Type Cualquier clase de objeto definida.
     *  @return {boolean}
     **/
    var typeOf = function (Pattern, Type) {
        return (typeof Pattern == Type);
    };


    /**
     *  Devuelve una cadena que identifica el tipo de datos de una expresión.
     *  @param {object} Pattern Obligatorio. Cualquier expresión de objeto. 
     *  @return {string}
     **/
    var getType = function (Pattern) {
        switch (Pattern) {
            case null:
                return _type_.null;
            case _nothing_:
                return _nothing_;
        }
        var t = typeof Pattern;
        switch (t) {
            case 'boolean':
                return _type_.boolean;
            case 'number':
                return _type_.Number;
            case 'string':
                return _type_.string;
        }
        return _type_.Object;
    };



    var timeStamp = function() {
        var d = new Date();
        return d.getFullYear() + '/' + d.getMonth() + '/' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    };

    /**
     * Browser
     * @return {Object} Navegador
     */
    var browser = (function () {
        var user_agt = navigator.userAgent;
        return {
            ie: (user_agt.indexOf('IE') != -1),
            opera: (user_agt.indexOf('Opera') != -1),
            gecko: (user_agt.indexOf('Gecko') > -1 && user_agt.indexOf('KHTML') === -1),
            netscape: (user_agt.indexOf('Netscape') != -1),
            safari: (user_agt.indexOf('AppleWebKit') != -1),
            mobile_safari: (!!user_agt.match(/Apple.*Mobile.*Safari/)),
            name: (user_agt.appCodeName),
            cookie_enabled: (user_agt.cookieEnabled),
            windows: (navigator.platform == 'Win32' || navigator.platform == 'Win64'),
            XP: (user_agt.indexOf('NT 5.1') != -1),
            vista: (user_agt.indexOf('NT 6') != -1),
            macintosh: (user_agt.indexOf('Mac') != -1),
            windows7: (user_agt.indexOf('NT 6.1') != -1),
            linux: (user_agt.indexOf('Linux') != -1),
            iPhone: (user_agt.indexOf('iPhone') != -1),
            iPod: (user_agt.indexOf('iPod') != -1),
            iPad: (user_agt.indexOf('iPad') != -1),
            android: (user_agt.indexOf('Android') != -1)
        };
    })();

    var isset = function(Reference) {
        return !(typeof Reference === "undefined");
    };


    var random = function(len) {
        len = len ? len : 10;
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < len; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }



    var guid = function() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
    };

    /**
     * Crear un Pop Up
     */
    var popup = function (url, Arguments, WindowsName) {
        if (!isset(url) || !isset(Arguments)) {
            return false;
        }
        Properties = '';
        WindowsName = (WindowsName) ? WindowsName : '';

        for (var Property in Arguments) {
            Properties += Property + '=' + Arguments[Property] + ',';
        }

        Windows.open(url, WindowsName, Properties);
    };


    /**
     * 
     */
    var now = function() {
        return new Date().getTime();
    };


    /**
     * 
     */
    var isString = function (Sender) {
        return (!isset(Sender) ? false : Object.IsString(Sender));
    };

    /**
     * Devuelve True si el argumento pasado es un Array, False en caso contrario
     */
    var isArray = function(Sender) {
        return (!isset(Sender)) ? false : Object.is_array(Sender);
    };
       

    /**
     * 
     * @param {*} path 
     * @param {*} Type 
     * @param {*} Attributes 
     * @param {*} parent 
     */
    var include = function (path, attr, parent) {
        
        if (path.contains('.js') == true) {
			type = 'script';
			file = head.getElementsByTagName('script');
		} else if(path.contains('.css') == true){
			type = 'style';
			file = head.getElementsByTagName('style');
		} else {
			return false;
        };

        switch (type.toLowerCase()) {
            case 'script':
                var lang = 'javascript',
                    type = 'text/javascript';
                if (attr) {
                    lang = attr.lang ? attr.lang : lang;
                    type = attr.type ? attr.type : type;
                }
                try {
                    var _element = new Element('script', { type: type, language: lang, src: path }, parent || head);
                } catch (ex) { alert(ex); return false; }

                break;

            case 'style':
                var rel = 'stylesheet',
                    media = 'screen';
                if (attr) {
                    rel = attr.rel ? attr.rel.toLowerCase() : rel;
                    media = attr.media ? attr.media.toLowerCase() : media;
                }
                var _element = new Element('link', { href: path, rel: rel, media: media }, parent || head);
                break;
        }
        return _element;
    };


    /**
     * Verifica si no existe el archivo en el documento y lo incuye en el.
     * @param {String} path Directorio del archivo a incluir.
     * @param {String} type Tipo de archivo. Por defecto "script".
     * @param {Object} (Opcional) attr Atributos de archivo. Por defecto "{}".
     * @param {String} (Opcional) parent Establece en que nodo se agregará el vinculo. Por defecto "head".
     */
    var includeOnce = function (path, attr, parent) {

        if (path.contains('.js') == true) {
			type = 'script';
			file = head.getElementsByTagName('script');
		} else if(path.contains('.css') == true){
			type = 'style';
			file = head.getElementsByTagName('style');
		} else {
			return false;
        };

        for (var i = 0; i < file.lenght; i++) {
            if (file[i].src != null && file[i].src.indexOf(type) != -1) {
                return false;
            }
        }
        return include(path, attr, parent);
    };


    Global.extend({
        'object_proto': object_proto,
        'array_proto': array_proto,
        'number_proto': number_proto,
        'string_proto': string_proto
    });

    Global.extend({
        head: document.getElementsByTagName('head')[0],
        ex: ExtendmeJS,
        isset:isset,
        include: include,
        includeOnce: includeOnce
    });
    
    ExtendmeJS.extend(ex, {
        getType: getType,
        typeOf: typeOf,        
        timeStamp:timeStamp,
        browser: browser,
        isset: isset,
        random:random,
        guid: guid,
        popup:popup,
        now:now,
        isString:isString,
        isArray: isArray,
        isInstance: isInstance,
        include: include,
        includeOnce: includeOnce
    });
    
})(this);



//Object
(function () {
    
    if (!window.node) {
        var node = {
            ELEMENT_NODE: 1,
            ATTRIBUTE_NODE: 2,
            TEXT_NODE: 3,
            CDATA_SECTION_NODE: 4,
            ENTITY_REFERENCE_NODE: 5,
            ENTITY_NODE: 6,
            PROCESSING_INSTRUCTION_NODE: 7,
            COMMENT_NODE: 8,
            DOCUMENT_NODE: 9,
            DOCUMENT_type__NODE: 10,
            DOCUMENT_FRAGMENT_NODE: 11,
            NOTATION_NODE: 12
        };
        ExtendmeJS.extend(Object, { node: node });
    }

    var _toString = function(reference) { return object_proto.toString.call(reference); };

    function isString(reference) {
        return _toString(reference) == _type_.string_class;
    }

    function isNumber(reference) {
        return _toString(reference) == _type_.number_class;
    }

    function isArray(reference) {
        return reference != null && typeof reference == _type_.object && 'splice' in reference && 'join' in reference;
    }

    function isFunction(reference) {
        return IsInstance(reference, Function);
    }

    function isNull(reference) {
        return (reference == null) ? true : false;
    }


    function addMethod(name, source) {
        var _name = this[name];
        this[name] = function() {
            if (Object.isFunction(source)) {
                if (source.length == arguments.length) {
                    return source.apply(this, arguments);
                } else if (Object.is_function(_name)) {
                    return _name.apply(this, arguments);
                }
            }
        };
    }

    function clone(sender) {
        var clon = _abstract_;
        ExtendmeJS.extend(clon, sender);
        return clon;
    }

    
    ExtendmeJS.extend(Object, {
        extend: ExtendmeJS.extend,
        isString: isString,
        isNumber: isNumber,
        isArray: isArray,
        isFunction: isFunction,
        isNull: isNull,
        addMethod: addMethod,
        clone: clone
    });

    ExtendmeJS.extend(window, { addMethod: addMethod });

})();


//String
(function() {

    function rTrim() {
        return this.replace(/\s+$/, "");
    }

    function lTrim() {
        return this.replace(/^\s+/, "");
    }

    function lrTrim() {
        return this.replace(/\s+$/, "").replace(/^\s+/, "");
    }

    function trimAll() {
        var _string = this,
            result = '';
        for (var i = 0, length = _string.length; i < length; i++)
            if (_string[i] != ' ') {
                result += _string[i];
            }
        return result;
    }

    function toArray(Selector) {
        return this.split(Selector || '');
    }

    /**
     * Trunca una cadena
     */
    function truncate(len, remplacement) {
        var _len = len || 10,
            _string = remplacement || '';
        if (this.length > _len)
            return this.substring(0, _len) + _string;
        else
            return this;
    }

    function stripTags() {
        return this.replace(/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi, '');
    }

    /**
     * Transforma todos los caracteres en minúsculas
     */
    function lower() {
        return this.toLowerCase();
    }

    /**
     * Transforma todos los caracteres en mayusculas
     */
    function upper() {
        return this.toUpperCase();
    }

    /**
     * Transforma la primera letra de la cadena en mayúsculas y el resto en minúsculas
     */
    function capitalize() {
        return this.charAt(0).upper() + this.substring(1).lower();
    }

    function left(len) {
        if (isset(len)) {
            if (len <= 0) return this;
            if (len >= this.length) return this;
            return this.toString().substring(0, len);
        }
        return this;
    }

    function right(len) {
        if (isset(len)) {
            if (len <= 0) return this;
            if (len >= this.length) return this;
            return this.toString().substring(this.length - len, this.length);
        } else return this;
    }


    function isEmpty() {
        return (/^\s*$/).test(this);
    }

    /**
     * Verifica si el string contine una cadena especifica
     */
    function contains(str) {
        return this.indexOf(str) > -1;
    }

    /**
     * Escapa los caracteres y tags HTML
     */
    function escapeHtml() {
        return this.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    /**
     * 
     */
    function unescapeHtml() {
        return this.removeTags().replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&amp;/g, '&');
    }

    /**
     * Agrega tantas veces se necesito un string a otro
     */
    function repeat(iterator) {
        return (iterator < 1) ? this : new Array(iterator + 1).join(this).toString();
    }

    /**
     * Verifica si el String es una email válido
     */
    function isEmail() {
        if (this.isEmpty()) return false;
        var RegExp = (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
        return (RegExp.test(this) ? true : false);
    }

    /**
     * Verifica si el string es una fecha válida
     */
    function isDate() {

        var y = this.substring(this.lastIndexOf("-") + 1, this.length),
            m = this.substring(this.indexOf("-") + 1, this.lastIndexOf("-")),
            d = this.substring(0, this.indexOf("-"));

        if (isNaN(y) || y.length < 4 || parseFloat(y) < 1900) {
            return false;
        }
        if (isNaN(m) || parseFloat(m) < 1 || parseFloat(m) > 12) {
            return false;
        }
        if (isNaN(d) || parseInt(d, 10) < 1 || parseInt(d, 10) > 31) {
            return false;
        }
        if (m == 4 || m == 6 || m == 9 || m == 11 || m == 2) {
            if (m == 2 && d > 28 || d > 30) {
                return false;
            }
        }
    }



    /**
     * Convierte una cadena en Hexadecimal
     */
    function toHex(dec) {
        var hexadecimal = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F"),
            hexaDec = Math.floor(dec / 16),
            hexaUni = dec - (hexaDec * 16);
        return (hexadecimal[hexaDec] + hexadecimal[hexaUni]);
    }

    function encodeUrl() {
        return encodeURIComponent(this);
    }

    function decodeUrl() {
        return decodeURIComponent(this);
    }

    function len() {
        return this.length;
    }

    Object.extend(String.prototype, {
        rTrim: rTrim,
        lTrim: lTrim,
        lrTrim: lrTrim,
        trimAll: trimAll,
        truncate: truncate,
        toArray: toArray,
        stripTags: stripTags,
        lower: lower,
        upper: upper,
        left: left,
        right: right,
        capitalize: capitalize,
        isEmpty: isEmpty,
        contains: contains,
        escapeHtml: escapeHtml,
        unescapeHtml: unescapeHtml,
        repeat: repeat,
        isEmail: isEmail,
        isDate: isDate,
        toHex: toHex,
        encodeUrl: encodeUrl,
        decodeUrl: decodeUrl,
        len: len
    });
})();


var Element = function( name, attr, parent ){
	if ( name == null) {
		return null;
	}
    
    parent = parent ? parent : null;
    element = document.createElement(name.toLowerCase());
    
	ExtendmeJS.extend(element, Element.Methods);
		
	try {
		if(isset(attr) && attr != _abstract_){
			if(isset(attr.style)){						
				ExtendmeJS.extend(element.style, attr.style);
				delete attr.style;
			}
			ExtendmeJS.extend(element, attr);					
			if(parent!=null){				
				if (!parent.extend) {				
					ExtendmeJS.extend(parent, Element.Methods);
				}
				parent.add(element);
            }
		}
	} catch(ex){
		trace('Error al crear el elemento "'+ name +'":\n'+ ex.message);
	}
	return element;
};



Element.Methods = {

    extend: ExtendmeJS.extend,

    extendme: function(source) {
        for (var property in source) {
            this[property] = source[property];
        }
        return this;
    },

    add: function(element, node){
		try {
			var base = this;
            if( node ) base.insertBefore(element,node); 
            else base.appendChild(element);
		} catch (ex) {
			trace('Error en Element.Method.Append:\n' + ex.message);
			return this;
		}
		return this;
    },
    
    enabled : function( value ){
		this.enabled = value;
		if(value){
			$(this).prop('disabled', true).css('opacity','1');
 		} else {
			$(this).prop('disabled', false).css('opacity','0.85');
		}
		return (this);
	},
}



function npm(package) {
    var packages = {
        notify: [
            ExtendmeJS.path + 'dist/components/notify/notify.js',
            ExtendmeJS.path + 'dist/components/notify/notify.css'
        ],
        loading: [
            ExtendmeJS.path + 'dist/components/loading/loading.js',
            ExtendmeJS.path + 'dist/components/loading/loading.css'
        ]
    }
    var path;
    $.each(packages, function (pack, urls) {
        if (package == pack) {
            $.each(urls, function (ix, it) {
                includeOnce(it);
            });
            return true;
        }
    });
    var base = '/assets/components/';
    if (package) {
        includeOnce(base + package);
    }
}