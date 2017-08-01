<table id="table_permisos" class="table display table-fixed" cellspacing="0" width="100%">
	<thead>
	    <tr>
	    	<th>{Lang::get('dashboard.module')}</th>
	    	<th class="text-center"><span class="fa fa-eye" {Helper::get('html')->tooltip(Lang::get('dashboard.info.view'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.view')}</span></th>
	    	<th class="text-center"><span class="fa fa-plus" {Helper::get('html')->tooltip(Lang::get('dashboard.info.add'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.view')}</span></th>
	    	<th class="text-center"><span class="fa fa-edit" {Helper::get('html')->tooltip(Lang::get('dashboard.info.edit'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.edit')}</span></th>
	    	<th class="text-center"><span class="fa fa-trash" {Helper::get('html')->tooltip(Lang::get('dashboard.info.delete'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.delete')}</span></th>
	    	<th class="text-center"><span class="fa fa-print" {Helper::get('html')->tooltip(Lang::get('dashboard.info.print'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.print')}</span></th>
	    	<th class="text-center"><span class="fa fa-magic" {Helper::get('html')->tooltip(Lang::get('dashboard.info.add'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.custom')}</span></th>
	    </tr>
	</thead>
	<tfoot>
	    <tr>
	    	<th>{Lang::get('dashboard.module')}</th>
	    	<th class="text-center"><span class="fa fa-eye" {Helper::get('html')->tooltip(Lang::get('dashboard.info.view'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.view')}</span></th>
	    	<th class="text-center"><span class="fa fa-plus" {Helper::get('html')->tooltip(Lang::get('dashboard.info.add'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.view')}</span></th>
	    	<th class="text-center"><span class="fa fa-edit" {Helper::get('html')->tooltip(Lang::get('dashboard.info.edit'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.edit')}</span></th>
	    	<th class="text-center"><span class="fa fa-trash" {Helper::get('html')->tooltip(Lang::get('dashboard.info.delete'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.delete')}</span></th>
	    	<th class="text-center"><span class="fa fa-print" {Helper::get('html')->tooltip(Lang::get('dashboard.info.print'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.print')}</span></th>
	    	<th class="text-center"><span class="fa fa-magic" {Helper::get('html')->tooltip(Lang::get('dashboard.info.add'))}></span> <span class="hidden-xs">{Lang::get('dashboard.actions.custom')}</span></th>
	    </tr>
	</tfoot>
    <tbody>
    
{if isset($registry) && count($registry)}
	{foreach $registry as $key => $value}
		
		
    	<tr id="tr_{$value.table}">
            <td><label for="read-{$value.text}">{$value.text}</label></td>
            <!--Lectura-->
            <td align="center">
				<input id="read-{$key}" type="checkbox" class="check read permission {$key}" data-module="{$key}" data-permission="read" {if $key=='dashboard'}readonly checked{/if}>
				<label class="check" for="read-{$key}"></label>
			</td>

            <!--Agregar-->
            <td align="center">
            	<div {if $key=='dashboard'}style="display: none"{/if}>
            		<input id="created-{$key}" type="checkbox" class="check permission {$key}" data-module="{$key}" data-permission="created">
					<label class="check" for="created-{$key}"></label>
				</div>
            </td>
            
            <!--Editar-->
            <td align="center">
            	<div {if $key=='dashboard'}style="display: none"{/if}>
                	<input id="update-{$key}" type="checkbox" class="check permission {$key}" data-module="{$key}" data-permission="update">
					<label class="check" for="update-{$key}"></label>
				</div>
            </td>
            
            <!--Eliminar-->
            <td align="center">
            	<div {if $key=='dashboard'}style="display: none"{/if}>
                	<input id="delete-{$key}" type="checkbox" class="check permission {$key}" data-module="{$key}" data-permission="delete">
					<label class="check" for="delete-{$key}"></label>
				</div>
            </td>
            
            <!--Imprimir-->
            <td align="center">
            	<div {if $key=='dashboard'}style="display: none"{/if}>
                	<input id="print-{$key}" type="checkbox" class="check permission {$key}" data-module="{$key}" data-permission="print">
					<label class="check" for="print-{$key}"></label>
				</div>
            </td>
            
            <!--Personalizar-->
            <td align="center">
            	<div {if $key=='dashboard'}style="display: none"{/if}>
                	<button class="customize btn btn-info" onclick="javascript:customize_handler('{$key}')" data-module="{$key}" type="button"><span class="fa fa-edit" ></span></button>
				</div>
            </td>
        </tr>
        
        {/foreach}
	{/if}
    </tbody>
</table>



<script>


$('.permission').change(function(e){
	var base = $(e.target);
	var data = base.data('module');
	var value = base.prop('checked');
	if( value == true  && $('.read.'+data).prop('checked') == false ) $('.read.'+data).prop('checked',value);
});

$('.read').change(function(e){
	var base = $(e.target);
	var data = base.data('module');
	var value = base.prop('checked');
	
	var default_module = $('#default_module').val();
	
	if( data == default_module ){
		$('.'+data).prop('checked',true);
		return;
	}
	
	if( value == false ){
		$('.'+data).prop('checked',value);
	}
	
});

$('#default_module').change(function(){
	var base = $(this);
	$('#read-'+base.val()).prop('checked',true)
})

	
</script>

