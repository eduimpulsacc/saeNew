/**
 * Por favor, no eliminar los creditos gracias =)
 * jquery.eValidator-1.4.js
 * @author: Xtian - naitsihcm@hotmail.com, ejugo.net
 * @since:  1.1
 * Noviembre 2011
 */
String.prototype.empty = function() {
	return !this || this == null || this == '' || this.trim() == '';
};
(function($) {
	$.fn.validate = function(options) {
		var idf = $(this).attr("id");
		var defaults = {delay:500, id: 180785, button: "#send", complete: null, beforeSubmit: null};
		var options = $.extend(defaults, options);
		var obj;
		var _createMessage = function(message) {
			obj = "validator-message-"+idf+"-"+options.id++;
			$('body').append('<div id="'+obj+'" class="validator-message hidden"></div>');
			return obj;
		};
		var _position = function(obj, rel, msj) {
			var pos = rel.offset();
			$(obj).html(msj).css({top:(pos.top), left:(pos.left + rel.width()+10)}).show();
		};
		
		$(this).submit(function() {
			var e = 0;
			$(this).find("input[type='text'],textarea,select").each(function(){
				var d = $(this).trigger("blur").data("obj-error");
				if(d && d != "") {
					e++;
				}
			});
			if(options.complete!=null) { 
				options.complete(e); 
				return false;
			} else {
				if(e > 0)
					if(options.beforeSubmit == null)
						alert("El formulario contiene " + e +" errores");
					else 
						options.beforeSubmit(e);
				return (e == 0);
			}			
		});
		
		$(this).find(".required").each(function(){
			$(this).blur(function(){
				obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "required");
				}
				obj = "#" + obj;
				if($(this).val().empty()) {
					_position(obj, $(this), "Este campo es requerido");
					$(this).data("obj-error", "required");
				} else {
					if($(this).data("obj-error") === "required"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
				
		$(this).find(".number").each(function(){
			$(this).keypress(function (e) {
			if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
					return false;
				}
				return true;
			}).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "number");
				}
				obj = "#" + obj;
				if(!(/^([0-9])*$/.test($(this).val()))) {
					_position(obj, $(this), "Este campo debe ser numerico");
					$(this).data("obj-error", "number");
				} else {
					if($(this).data("obj-error") === "number"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
		
		$(this).find(".float").each(function(){
			
			$(this).keypress(function (e) {
				var i = 0;
				var val = $(this).val();
				if((i = val.indexOf('.')) != -1){
					if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
						return false;
					} 
				} else {
					if(e.which!=8 && e.which!=190 && e.which != 46 && e.which!=0 && (e.which<48 || e.which>57)){
						return false;
					}
				}
				return true;
			}).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "float");
				}
				obj = "#" + obj;
				if(!$(this).val().empty() && !(/^\d{0,}.{0,1}\d{0,}$/.test($(this).val()))) {
					_position(obj, $(this), "Este campo debe ser flotante");
					$(this).data("obj-error", "float");
				} else {
					if($(this).data("obj-error") === "float"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
		
		
		$(this).find(".email").each(function(){
			$(this).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "email");
				}
				obj = "#" + obj;
				if(!$(this).val().empty() &&!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test($(this).val()))) {
					_position(obj, $(this), "El correo electronico no es correcto");
					$(this).data("obj-error", "email");
				} else {
					if($(this).data("obj-error") === "email"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
		
		$(this).find(".phone").each(function(){
			$(this).keypress(function (e) {
				if(e.which!=8 && e.which!=0 && e.which!=32 && e.which!=40 && e.which!=41 && e.which!=42 && e.which!=45 && (e.which<48 || e.which>57)){
					return false;
				}
				return true;
			}).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "phone");
				}
				obj = "#" + obj;
				if(!$(this).val().empty() &&!(/^([0-9-()* ])*$/.test($(this).val()))) {
					_position(obj, $(this), "El campo solo permite numeros telefonicos p.e (044) 55-9167 9830");
					$(this).data("obj-error", "phone");
				} else {
					if($(this).data("obj-error") === "phone"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
		
		$(this).find(".web").each(function(){
			$(this).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "web");
				}
				obj = "#" + obj;
				if(!$(this).val().empty() &&!(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/.test($(this).val()))) {
					_position(obj, $(this), "El campo debe ser un sitio web p.e. http://www.ejugo.net");
					$(this).data("obj-error", "web");
				} else {
					if($(this).data("obj-error") === "web"){
						$(this).data("obj-error", "") 
						$(obj).hide();
					}
				}
			});
		});
		
		$(this).find(".date").each(function(){
			$(this).keypress(function (e) {
				if(e.which!=8 && e.which!=0 && e.which!=47 && (e.which<48 || e.which>57)){
					return false;
				}
				return true;
			}).blur(function(){
				var obj = $(this).data("obj-id");
				if(!obj) {
					$(this).data("obj-id", obj = _createMessage());
					$(this).data("obj-error", "date");
				}
				obj = "#" + obj;
				if($(this).data("obj-error") === "date"){
					$(this).data("obj-error", "") 
					$(obj).hide();
				}
				if(!$(this).val().empty()) {
					var dayfield=$(this).val().split("/")[0];
					var monthfield=$(this).val().split("/")[1];
					var yearfield=$(this).val().split("/")[2];
					var dayobj = new Date(yearfield, monthfield-1, dayfield);
					if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)){
						_position(obj, $(this), "La fecha debe ser en formato DD/MM/AAAA");
						$(this).data("obj-error", "date");
					}
				} 
			});
		});
		
	};
}(jQuery));