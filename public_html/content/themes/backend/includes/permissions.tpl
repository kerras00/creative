<div id="modal_custom" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="modal_custom_title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_custom_title" style="text-transform: uppercase;">{Lang::get('dashboard.info.permission_custom')}</h4>
			</div>
							
			<!-- body modal -->
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<span class='fa fa-circle' style='margin-top:10px;color:#dd4b39'></span> {Lang::get('dashboard.info.permission_access_hidden')}<br/>
						<span class='fa fa-circle' style='margin-top:10px;color:#f39c12'></span> {Lang::get('dashboard.info.permission_access_readonly')}<br/>
						<span class='fa fa-circle' style='margin-top:10px;color:#00a65a'></span> {Lang::get('dashboard.info.permission_access_yes')}
					</div>
					<div class="col-md-12">
						<table id="table_permissions" class="table display" cellspacing="0" width="100%">
							<thead>
							    <tr>
							    	<th>{Lang::get('dashboard.field')}</th>
							    	<th class="text-center"><span class="fa fa-cog"></span> {Lang::get('dashboard.access')}</th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
							     <tr>
							    	<th>{Lang::get('dashboard.field')}</th>
							    	<th class="text-center"><span class="fa fa-cog"></span> {Lang::get('dashboard.access')}</th>
									<th></th>
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


function addrecord_callback(){
	$('#id').val(-1);	
	modules = $.extend(true, {}, modules_intitialize);
	$('.permission').prop('checked', false);
	$('#read-dashboard').prop('checked',1).prop('disabled',1);
	$('#default_module').val( $('.read:first').data('module') ).change();
}



var modules = {Registry::get_registry_of_modules_json()};/*(function(){
	var r = {Registry::get_registry_of_modules_json()};
	$.each(modules, function(module_name, module_attr){
		if( r.fields ){
			$.each(module_attr.fields, function(field_name, field_attr){
				r[module_name]['fields'][field_name] = {
					text : field_attr,
					access : 0
				};
			});
		}
	});
	return r;
})();*/
var modules_intitialize = $.extend(true, {}, modules);



/**
 * 
 */
function customize_handler( id ){
	
	if( typeof modules[id]==="undefined" ){
		messagebox('Personalizar Módulo', '{Lang::get("dashboard.info.modules_field_undefined")}');
		$('body').addClass('modal-open');

	} else if( typeof modules[id].fields_info==="undefined" ){
		messagebox('Personalizar Módulo', '{Lang::get("dashboard.info.modules_field_undefined")}');
		$('body').addClass('modal-open');

	} else {
		
		$("#modal_custom").modal('show');
		$("#modal_custom")
			.css("z-index", parseInt($('#modal_wiewrecord').css('z-index')) + 100)
			.css("paddingTop", '25px');
		
		$('#modal_custom_title').html(modules[id]['text'] + " - <small>{Lang::get('dashboard.customize')}</small>");
		
		$('#table_permissions tbody').html('');
		
		if( modules[id].fields_info ){
		 	$.each(modules[id].fields_info, function(index, item){

				var info = '', required = '';

				if( modules[id].fields_info ){
					if( modules[id].fields_info[index] ){
						if( modules[id].fields_info[index]['info'] ){
							info = modules[id].fields_info[index]['info'];
						}
						if( modules[id].fields_info[index]['required'] ){
							required = modules[id].fields_info[index]['required'];
						}	
					}					
				}
				
				var field = '<td align="left" style="padding-top: 8px !important;">:text :info :required</td>'
					.replace(':text', item)
					.replace(':info', info != '' ? '{Helper::get("html")->icon_help("'+info+'")}' : '')
					.replace(':text', item)
					.replace(':required', required != '' ? '{Helper::get("html")->icon_required("'+item+'")}' : '');

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
				$('[data-toggle="popover"]').popover(); 
			});			
		}
	}
	
};


function save_access(){

	var base = $(this);
	var module = base.data('module');
	var field = base.data('field');
	var val = base.val();
	var color = '#dd4b39';

	modules[module]['fields'][field]['access'] = val;
	$('#read-'+module).prop('checked',1);

	switch( val ){
		case '0': color = '#dd4b39'; break;
		case '1': color = '#00a65a'; break;
		case '2': color = '#f39c12'; break;
	}
	$('#label-'+field).css('color', color);
}


</script>

