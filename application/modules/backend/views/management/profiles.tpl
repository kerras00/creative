{include file="includes/data.table.tpl" 
	data=$data 
	table=$table}


{if $search}
	{include file="includes/modal-search.tpl" 
		data=$data 
		table=$table 
		controller='/backend/'|cat:$module|cat:'/'}
{/if}

{include file="includes/scripts.tpl" general=true}

{include file="includes/permissions.tpl"}


<script>

/**
* Envia una peticion para crear un nuevo registro
*/
function saverecord_handler( e ){
	
	e.preventDefault()
	
	var $btn= $(this);
	$(".form-control").parent().removeClass("has-error");
	
	var data = {
			id 				: $("#id").val(),
			name 			: $("#name").val(),
			default_module 	: $("#default_module").val(),
			description 	: $("#description").val(),
			status 			: $("#status").val()
		},
		action 			= "insert",
		ajax_url 		= "/api/v1/profiles.json/";
	
	//Nuevo Registro
	if( data.id <= "-1" ){
		action 		= "insert";
		ajax_type = "POST";
	//Actualización de registro
	} else {
		action 	= "update";
		ajax_type = "PUT";
	}
	
	var permissions = {};
	$.each( $('.permission'), function(key,value){
		var modulo = $(value).data("module");
		var permission = $(value).data("permission");
		var val = $(value).prop('checked') ? 1 : 0;
		if( permissions[modulo] == undefined ) permissions[modulo] = [];
		permissions[modulo].push( permission+':'+val );
	});
	
	data.permissions = permissions;
	data.access_field  = modules;
	
	$(".form-control").parent().removeClass("has-error");
		
	$.ajax({
		url : ajax_url,
		data : data,
	    beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		},
		type : ajax_type,		 
		dataType : "json",		 
		success : function(data) {
			
			$.loading( "hide" );
			_token = data.token;
			console.log(data.statusText);
			
			
			//Unauthorized - Indica que el cliente debe estar autorizado primero antes de realizar operaciones con los recursos
			if( data.status == 401 ){
	    		ex.notify(data.statusText, data.icon);
	    		return false;
	    	}
	    	
	    	//Unprocessable Entity - Parametros incorrectos
			if( data.status == 422 ){
	    		ex.notify(data.statusText, data.icon);
	    		$("#"+data.field).focus().parent().addClass("has-error");
	    		return false;
	    	}
	    	
	    	//Internal Server Error
	    	if( data.status == 500 ){
	    		ex.notify(data.statusText, data.icon);
	    		return false;
	    	}
	    	
	    	//Created - Creado con exito
	    	if( data.status == 201 ){
	    		
				$("#modal_wiewrecord").modal("hide");
				ex.notify(data.statusText, data.icon);
				edit_mode = false;
				
				if (action == "update"){
					var row = $("#tr_" + data.data.id);
					_dt_data.row(row).remove().draw();
				}
				
				
				var columns = [];
				$.each(_datable_columns,function(index, item){
					if( _datable_columns_pk == item){
						columns.push( "<a href='javascript:viewrecord_handler(data.data.id)'>"+data.data[item]+"</a>" );
					} else {
						columns.push( data.data[item] );
					}
				});
				
				//Template de Estatus
				columns[columns.length-1] = _template_status
			        .replace(":status_text", data.data.status_text)
			        .replace(":status_help", data.data.status_help)
			        .replace(":status_class", data.data.status_class)
			    ;
			    
			    //Tempalte de Acciones
			    columns.push(
			        _template_action
			        	.replace(":id", data.data.id) //View
			        	.replace(":id", data.data.id) //Edit
			        	.replace(":id", data.data.id) //Delete
			    );
				
				var _row_node = _dt_data.row.add(columns).draw().node();
					$(_row_node).attr("id", "tr_" + data.data.id);
					
				$(_row_node).addClass("save_success");
				setTimeout(function(){
					$(_row_node).removeClass("save_success");
				}, 5500);				

			}
			
	    }
	});
	
}

$(document).ready(function(){
	$("#modal_wiewrecord_form").submit(saverecord_handler);
	$("#modal_wiewrecord").on("shown.bs.modal", function () {
	    $(this).find("input:text:visible:first").focus();
	});
	
	$("#modal_custom").on("hidden.bs.modal", function () {
	    $('body').addClass('modal-open');
	});
});	

</script>




<script>

/**
* Traer los datos mediante Ajax
*/
function loaddata_handler( id ){
	
	$.ajax({
		url : "/api/v1/profiles.json/find/" + id,
		data : {
			id 		: id,
			token 	: _token,
	    },
	    beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		},
		type : "GET",		 
		dataType : "json",		 
		success : function(data) {
			
			$.loading( "hide" );			
	    	if( data.status == 200 ){
	    		
	    		var permissions = data.data.permissions;
	    		modules = $.extend(true, {}, modules_intitialize);
	    		
	    		//UnCheck todos los permisos
	    		$('.permission').prop('checked', false);
	    		
	    		$.each(data.data, function( index, item ){	    			
	    			if( $("#"+index).is("select") ){
	    				$("#"+index).val(item).change();
	    			} else {
	    				$("#"+index).val(item);
	    			}
	    		});
	    		
	    		//Recorre los permisos
	    		$.each(permissions, function( index_root, permiso ){
	    			
	    			if( permiso.attr == 'permission-module' ){
	    				var access = permiso.content.to_array(',');
		    			$.each(access, function( index, item ){
		    				item = item.to_array(':');
		    				var field = '#' + item[0]+ '-'+permiso.name;
		    				var val = item[1]==1 ? true : false;
		    				$(field).prop('checked',val);
		    			});
		    			
	    			} else if( permiso.attr == 'permission-field' ){
	    				var access = permiso.content.to_array(',');
	    				$.each(access, function( index, item ){
		    				item = item.to_array(':');
		    				
		    				modules[permiso.name][item[0]].access = item[1];
		    				
		    			});
	    			}
		    			
	    				    			
	    		});
	    		
				//_token = data.response.token;				
			} else {					
				ex.notify(data.statusText, data.icon);
			}				
	    }
	});
}
</script>





<script>
var _dt_sresult;

function searchrecord_handler(){
	
	if( $("#search").val() == "" ){
		ex.notify("Debe ingresar un parametro de busqueda", "info");
		$("#search").focus();
		return ;
	}
	
	//$("#btn_search").prop("disabled", true);
	
	var filter = $("#filter").val(),
		value  = $("#search").val();
	
	$.ajax({
		url : "/api/v1/{$module}.json/search/" + filter + "/" + value,
	    beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		},
		type : "GET",
		dataType : "json",		 
		success : function(data) {			
			
			_dt_sresult.clear().draw();
			
			if( data.status == 200 ){
						
				$.each(data.data,function(index, item){
					
					var columns = [];
					$.each(_datable_columns,function(ix, val){
						if( _datable_columns_pk == val){
							columns.push( '<a href="javascript:viewrecord_handler('+item["id"]+')">'+item[val]+"</a>" );
						} else {
							columns.push( item[val] );
						}
					});
					
						
					//Template de Estatus
					columns[columns.length-1] = _template_status
				        .replace(":status_text", item.status_text)
				        .replace(":status_info", item.status_info)
				        .replace(":status_class", item.status_class)
				    ;
				    
				    //Tempalte de Acciones
				    columns.push(
				        _template_action_search
				        	.replace(":id", item.id) //View
				        	.replace(":id", item.id) //Edit
				        	.replace(":id", item.id) //Delete
				    );
				    
			    		
					_dt_sresult.row.add(columns).draw();
					
				});
				$("#dlg_sresult").modal("show");
				
				
			} else if( data.status == 404 ){
				//_token = data.response.token;				
				ex.notify(data.statusText, data.icon);
			}
			
			$("#btn_search").prop("disabled", false);
			$.loading("hide");	
	    }
	});	
}
</script>