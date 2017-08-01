<div class="box-header with-border">
	<h4 class="box-title">{$title}</h4>
</div>
<div class="row" style="margin-bottom: 10px">
	<div class="col-md-12">
		<div class="btn-group" role="group" aria-label="">
			{if $btn_add}<button id="btn_add" type="button" class="btn btn-default" {Helper::get('html')->tooltip(Lang::get('dashboard.info.add'))}><span class="fa fa-plus"></span>{if $btn_add_text} {Lang::get('dashboard.actions.add')}{/if}</button>{/if}
		   	{if $btn_print}<button id="btn_print" onclick="javascript:print_page()" type="button" class="btn btn-default" {Helper::get('html')->tooltip(Lang::get('dashboard.info.print'))}><span class="fa fa-print"></span></button>{/if}
		   	{if $btn_shared}<button id="btn_shared" type="button" class="btn btn-default" {Helper::get('html')->tooltip(Lang::get('dashboard.info.shared'))}><span class="fa fa-share-alt"></span></button>{/if}
		   	
		   	<!--Barra de Busqueda-->
		   	<div class="input-group">
		   	
				{if $search}
					<select id="filter" class="form-control select2" style="width: 30%; float:left">
					{if isset($filters) && count($filters)}
						{foreach $filters as $key => $value}
						<option value="{$key}" {if $value=='all'}selected{/if}>{$value}</option>
						{/foreach}
					{/if}
					</select>
					<input id="search" type="text" class="form-control" style="width: 70%; display: inline-block !important;float:right" placeholder="{Lang::get('dashboard.info.search')}" maxlength="50">
					<span class="input-group-btn" {Helper::get('html')->tooltip(Lang::get('dashboard.info.search'))}>
						<button id="btn_search" class="btn btn-default" type="button"><span class="fa fa-search"></span></button>
					</span>
				{/if}
					
				{if $btn_search_avanced}
					<span class="input-group-btn" data-toggle="modal" data-target="#dlg-busqueda-avanzada" {Helper::get('html')->tooltip(Lang::get('dashboard.info.avanced_search'))}>
						<button id="buscar-btn" class="btn btn-default" type="button"><span class="fa fa-filter"></span></button>
					</span>
				{/if}
			</div>

		</div>
	</div>
</div>
<style>
#filter{ float: left; }
</style>