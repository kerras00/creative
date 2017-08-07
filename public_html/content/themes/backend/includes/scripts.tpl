<script>

	var _module = '{$module}';
	var _token = '{$token}';

	var _template_action = '<div style="text-align:center">'+
								' {if $table.view}<button class="btn btn-default" onclick="javascript:viewrecord_handler(:id)" type="button" {Helper::get("html")->tooltip(Lang::get("dashboard.info.details"))}><span class="fa fa-eye"></span> </button>{/if} ' +
								' {if $table.edit}<button class="btn btn-info" onclick="javascript:editrecord_handler(:id)" type="button" {Helper::get("html")->tooltip(Lang::get("dashboard.info.edit"))}><span class="fa fa-edit"></span> </button>{/if} ' +
								' {if $table.delete}<button class="btn btn-danger" onclick="javascript:deleterecord_handler(:id)"  type="button"  {Helper::get("html")->tooltip(Lang::get("dashboard.info.delete"))}><span class="fa fa-trash"></span> </button>{/if} ' +
							'</div>';
	
	var _template_action_search = '<div style="text-align:center">{if $table.view}<button class="btn btn-default" onclick="javascript:viewrecord_handler(:id);" title="" type="button"  {Helper::get("html")->tooltip(Lang::get("dashboard.info.details"))}><span class="fa fa-eye"></span> </button>{/if} ' +
										' {if $table.edit}<button class="btn btn-info" onclick="javascript:editrecord_handler(:id)" title="" type="button"  {Helper::get("html")->tooltip(Lang::get("dashboard.info.edit"))}><span class="fa fa-edit"></span> </button>{/if} ' +
									'</div>';
			
			
	var _template_status = '<div style="text-align:center">'+
								'<span class="label label-:status_class" {Helper::get("html")->tooltip(":status_info")}>:status_text</span></div>';
	
	var _datable_columns = [];
	var _datable_columns_pk = '';
	
	{if isset($table.columns) && count($table.columns)}
		{foreach $table.columns as $key => $value}
			_datable_columns.push('{$key}');
			{if isset($value.primary) AND $value.primary == true}_datable_columns_pk = '{$key}';{/if}
		{/foreach}
	{/if}
				
	/**
	* Bloquear o desbloquear controles
	**/
	function bloquear_handler( bloquear_control ){
		if( bloquear_control ){
			$('#modal_wiewrecord .form-control').prop('disabled', true);
			$('#modal_wiewrecord .check').prop('disabled', true);
			$('#modal_wiewrecord .form-view button').prop('disabled', true);
		} else {
			$('#modal_wiewrecord .form-control').prop('disabled', false);
			$('#modal_wiewrecord .check').prop('disabled', false);
			$('#modal_wiewrecord .form-view button').prop('disabled', false);
		}
	}
	
	function clear_handler(){
		$("#modal_wiewrecord .form-control").val("");		
		$("#modal_wiewrecord .form-control.select2").val(-1).change();
	}
	
	
	$(document).ready(function(){	

		if( typeof _option_dt_sresult !== "undefined" ){
			_dt_sresult = $('#dt_sresult').DataTable(_option_dt_sresult);
			 $('.dataTables_filter input').addClass('form-control').css('display', 'inline-block').css('width', 'auto');
		}
			

		bloquear_handler( true );

		{if $btn_add == TRUE}			
			if( typeof addrecord_handler !== "undefined" ){
				if( jQuery.isFunction( addrecord_handler ) )
					$('#btn_add').click(addrecord_handler);
			}
			if( typeof saverecord_handler !== "undefined" ){
				if( jQuery.isFunction( saverecord_handler ) )
					$('#btn_save').click(saverecord_handler);
			}		
		{/if}
	});
</script>