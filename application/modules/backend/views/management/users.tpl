{include file="includes/data.table.tpl" 
	data=$data 
	table=$table}


{if $search}
	{include file="includes/modal-search.tpl" 
		data=$data 
		table=$table 
		controller='/backend/'|cat:$module|cat:'/'}
{/if}

{include file="includes/scripts.back.tpl" general=true}



<div id="modal_custom" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="modal_custom_title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_custom_title" style="text-transform: uppercase;">Personalizar módulo</h4>
			</div>
							
			<!-- body modal -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<table id="table_permissions" class="table display" cellspacing="0" width="100%">
							<thead>
							    <tr>
							    	<th>{Lang::get('dashboard.field')}</th>
							    	<th class="text-center"><span class="fa fa-cog"></span> {Lang::get('dashboard.access')}</th>
							    </tr>
							</thead>
							<tfoot>
							     <tr>
							    	<th>{Lang::get('dashboard.field')}</th>
							    	<th class="text-center"><span class="fa fa-cog"></span> {Lang::get('dashboard.access')}</th>
							    </tr>
							</tfoot>
						    <tbody>
						    </tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<!--<button class="btn btn-danger pull-left" data-dismiss="modal"><span class="fa fa-ban"></span> Cerrar</button>-->
				<button id="modal_custom_submit" data-dismiss="modal" type="button" class="btn btn-success"><span class="fa fa-check"></span> {Lang::get('accept')}</button>
			</div>
		</div>
	</div>
</div>

<script>

/**
 * 
 */
function addrecord_callback(){
	$('#read-dashboard').prop('checked',1).prop('disabled',1);
    $('#id').val(-1);
	modules = $.extend(true, {}, modules_intitialize);
}

var modules = {Registry::get_json()};
$.each(modules, function(module_name, module_attr){
	if( module_attr.rules ){
		$.each(module_attr.rules, function(rule_name, rule_attr){
			modules[module_name]['rules'][rule_name] = {
				text : rule_attr,
				access : 0
			};
		});
	}
});
var modules_intitialize = $.extend(true, {}, modules);

/**
 * 
 */
function customize_handler( id ){
	
	if( typeof modules[id] === "undefined" ){
		messagebox('Personalizar Módulo', 'No se permite configurar este módulo');
		$('body').addClass('modal-open');

	} else {
		
		$("#modal_custom").modal('show');
		$("#modal_custom")
			.css("z-index", parseInt($('#modal_wiewrecord').css('z-index')) + 100)
			.css("paddingTop", '25px');
		
		$('#modal_custom_title').html(modules[id]['text'] + " - <small>{Lang::get('dashboard.customize')}</small>");
		
		$('#table_permissions tbody').html('');
		
		if( modules[id].rules ){
		 	$.each(modules[id].rules, function(index, item){
				var field = '<td align="left" style="padding-top: 8px !important;">:text</td>'.replace(':text', item['text']);
				var action = '<td align="center">'+
								'<select id="access_'+index+'" data-field="'+index+'" data-module="'+id+'" class="form-control access_field" style="width: 100%;">'+
									"<option value=\"1\">{Lang::get('yes')}</option>"+
									"<option value=\"2\">{Lang::get('readonly')}</option>"+
									"<option value=\"0\" selected>{Lang::get('hidden')}</option>"+
								'</select>'+
							'</td>'+
							'<td>'+
								'<span id="label-'+index+'" class="fa fa-circle" style="margin-top:10px;color:#dd4b39"></span>'+
							'</td>';	
				$('#table_permissions').append('<tr>'+field + action+'</tr>');
				$('#access_' + index).on("change", save_access);
				$('#access_' + index).val(item['access']).change();
			});			
		}
	}
	
};


function save_access(){
	var base = $(this);
	var modulo = base.data('module');
	var field = base.data('field');
	var val = base.val();
	modules[modulo]['rules'][field]['access'] = val;
	$('#read-'+modulo).prop('checked',1);
		switch( val ){
		case '0': color = '#dd4b39'; break;
		case '1': color = '#00a65a'; break;
		case '2': color = '#f39c12'; break;
	}
	$('#label-'+field).css('color', color);
}

</script>


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
			email 			: $("#email").val(),
			pass 			: $("#pass1").val(),
			profile_id 	     : $("#profile_id").val(),
			name 			: $("#name").val(),
			last_name 		: $("#last_name").val(),
			nicname 		: $("#nicname").val(),
			status 			: $("#status").val()
		},
		action 			= "insert",
		ajax_url 		= "/api/v1/users.json/?tokenurl=" + ex.guid();
	
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
		type : ajax_type,		 
		dataType : "json",
	    beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		},
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
	    		$(data.field).focus().parent().addClass("has-error");
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
						columns.push( '<a href="javascript:viewrecord_handler('+data.data.id+')">'+data.data[item]+"</a>" );
					} else {
						columns.push( data.data[item] );
					}
				});
				
				//Template de Estatus
				columns[columns.length-1] = _template_status
			        .replace(":status_text", data.data.status_text)
			        .replace(":status_help", data.data.status_info)
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
	
    $("#profile_id").change(loaddata_profile_handler);
});	

</script>




<script>

/**
* Traer los datos mediante Ajax
*/
function loaddata_profile_handler( id ){
	id = $(id.target).val();
    
    if( id == -1 || id == null ) return false;
    
	$.ajax({
		url : "/api/v1/profiles.json/find/" + id + '?tokenurl='+ ex.guid(),
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
	    		
	    		//Recorre los permisos
	    		$.each(permissions, function( index_root, permission ){
	    			
	    			if( permission.attr == 'permission-module' ){
	    				var access = permission.content.toArray(',');
		    			$.each(access, function( index, item ){
		    				item = item.toArray(':');
		    				var field = '#' + item[0]+ '-'+permission.name;
		    				var val = item[1]==1 ? true : false;
		    				$(field).prop('checked',val);
		    			});
		    			
	    			} else if( permission.attr == 'permission-field' ){
	    				var access = permission.content.toArray(',');
	    				$.each(access, function( index, item ){
							item = item.toArray(':');

							if( modules[permission.name] )				
								if( modules[permission.name]['rules'] )
									modules[permission.name]['rules'][item[0]].access = item[1];
		    				
		    			});
	    			}
				});
				
	    		$('#read-dashboard').prop('checked',1).prop('disabled',1);
				//_token = data.response.token;				
			} else {					
				ex.notify(data.statusText, data.icon);
			}				
	    }
	});
}


function loaddata_handler( id ){
	
	$.ajax({
		url : "/api/v1/users.json/find/" + id,
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
	    		$("#profile_id").unbind('change',loaddata_profile_handler);
                
	    		$.each(data.data, function( index, item ){	    			
	    			if( $("#"+index).is("select") ){
	    				$("#"+index).val(item).change();
	    			} else {
	    				$("#"+index).val(item);
	    			}
	    		});
	    		$("#profile_id").change(loaddata_profile_handler);
                
	    		//Recorre los permisos
	    		$.each(permissions, function( index_root, permission ){
	    			
	    			if( permission.attr == 'permission-module' ){
	    				var access = permission.content.toArray(',');
		    			$.each(access, function( index, item ){
		    				item = item.toArray(':');
		    				var field = '#' + item[0]+ '-'+permission.name;
		    				var val = item[1]==1 ? true : false;
		    				$(field).prop('checked',val);
		    			});
		    			
	    			} else if( permission.attr == 'permission-field' ){
	    				var access = permission.content.toArray(',');
	    				$.each(access, function( index, item ){
							item = item.toArray(':');

							if( modules[permission.name] )				
								if( modules[permission.name]['rules'] )
									modules[permission.name]['rules'][item[0]].access = item[1];
		    				
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
		url : "/api/v1/users.json/search/" + filter + "/" + value + '?tokenurl=' + ex.guid(),
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



<script>
/**
* Eliminar un registro* 
* @return
*/
function deleterecord_handler(id){
	bootbox.confirm({
	    title: "<span style=\"text-transform: uppercase;\">:text - <small>{Lang::get('dashboard.info.delete')}</small></span>",
	    size: "small",
	    message: "{Lang::get('dashboard.actions.delete_confir')}",
	    buttons: {
	        cancel: {
	            label: '<i class="fa fa-times"></i> {Lang::get("cancel")}',
	            className: "btn-danger"
	        },
	        confirm: {
	            label: '<i class="fa fa-check"></i> {Lang::get("confir")}',
	            className: "btn-success"
	        }
	    },
	    callback: function (result) {
	    	if( result ){
	    		deleterecord_callback(id);
	    	}
	    }
	});
}

function deleterecord_callback( id ){
	$.ajax({
		url : "/api/v1/users.json/" + id,
		type : "DELETE",
		dataType: "JSON",
		beforeSend: function( e ) {
			$.loading({ text: "{Lang::get('processing')}..." });
		}
	}).done(function( data ) {
		$("#tr_" + id).addClass("delete_success");
		if( data.status == 204 ){
			setTimeout(function(){
				_dt_data.row("#tr_"+id).remove().draw( false );
			}, 1100);
		}
		$.loading("hide");
	});
}
</script>