<style>
    .panel-body {
        padding: 15px;
    }
    
    .btn-group .btn:not(.dropdown-toggle) {
        border-radius: 0;
        border-radius: 0;
    }
    
    @media (min-width: 768px) {
        .modal-sm {
            width: 330px;
        }
    }
</style>

<link rel="stylesheet" type="text/css" href="/content/themes/backend/css/datatable.css">

<div ng-controller="data as showCase">
    <div class="box box-default">
        {include file="includes/data.header.tpl"}
        <div class="box-body">
            <table datatable="" id="dt_data" dt-options="showCase.dtOptions" dt-column-defs="showCase.dtColumnDefs" class="display data-table compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        {if isset($table.columns) && count($table.columns)}
                            {foreach from=$table.columns item=column}
                                <th align="{$column.align|default:'left'}" {if array_key_exists('type',$column)===TRUE AND $column.type=='label'}style="text-align: center;"{/if}>{$column.text}</th>
                            {/foreach}
                        {/if}
                        <th align="center" style="text-align: center;">
                            {Lang::get("dashboard.actions.actions")}
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        {if isset($table.columns) && count($table.columns)}
                            {foreach from=$table.columns item=column}
                                <th align="{$column.align|default:'left'}" {if array_key_exists('type',$column)===TRUE AND $column.type=='label'}style="text-align: center;"{/if}>{$column.text}</th>
                            {/foreach}
                        {/if}
                        <th align="center" style="text-align: center;">
                            {Lang::get("dashboard.actions.actions")}
                        </th>
                    </tr>
                </tfoot>

                <tbody>

                {if isset($data) && count($data)}
                    {foreach $data as $key => $record}
                        {if $record.status > -10}

                        <tr id="tr_{$record.id}">
                            {if isset($table.columns) && count($table.columns)} 

                                {foreach $table.columns as $field => $attr}

                                <td align="{$attr.align|default:'left'}">
                                    {*Si la attra es de tipo "date"*}
                                    {if array_key_exists('type',$attr)===TRUE}
                                        {if $attr.type == 'date'}
                                            {$record[$field]|date_format:$attr['format']}
                                            {*Si la attra es de tipo "number"*}
                                        {elseif $attr.type == 'number'}
                                            {* 'format' => array( int Decimanles, string Separador de deciamles, string Separador de Miles ) *} 
                                            {number_format($record[$field], $attr['format'][0], $attr['format'][1], $attr['format'][2])}
                                            {*Si la attra es de tipo "label"*} 
                                        {elseif $attr.type == 'label'}
                                            <span class="label label-{$record[$attr['labelclass']]|default:'default'}" {if $attr[ 'tooltips']}{*html::tooltips($record[$attr[ 'tooltips']])*}{/if}>
                                                {$record[$field]}
                                            </span> 
                                         {/if}
                                   
                                    {else}
                                    {*Si no existe un tipo establecido, pero se tiene un formato*} 
                                        {if isset($attr['format']) AND $attr['format']}
                                            {$record[$field]|string_format:$attr['format']}
                                        {else}
                                            {*Si no existe un tipo establecido, ni formato*}
                                            {if isset($attr['primary']) AND $attr['primary'] == TRUE}
                                                <a href="javascript:viewrecord_handler({$record.id})">{$record[$field]}</a>
                                            {else}
                                                {$record[$field]}
                                            {/if}
                                        {/if}
                                    {/if}

                                </td>

                                {/foreach}
                            {/if}

                            <td align="center">
                                {if isset($action_datatable_before) && count($action_datatable_before)}
                                    {foreach $action_datatable_before as $k => $v}
                                        <button class="btn btn-{$v['color']|default:'default'}" type="button" data-id="{$record.id}" onclick="javascript:{$v['onclick']}" 
                                        {if $v[ 'tooltip']}
                                            {*html::tooltips( "{$v['tooltip']}")*}
                                        {/if}><span class="fa fa-{$v['icon']|default:'circle'}"></span></button>
                                    {/foreach}
                                {/if}
                                {if $table.view}<button class="btn btn-default" onclick="javascript:viewrecord_handler({$record.id})" title="" type="button" {*html::tooltips( "Visualizar los detalles de este registro")*}><span class="fa fa-eye"></span> </button>{/if}
                                {if $table.edit}<button class="btn btn-info" onclick="javascript:editrecord_handler({$record.id})" title="" type="button" {*html::tooltips( "Haga click para editar este registro")*}><span class="fa fa-edit"></span> </button>{/if}
                                {if $table.delete}<button class="btn btn-danger" onclick="javascript:deleterecord_handler({$record.id})" title="" type="button" {*html::tooltips( "Haga click para eliminar este registro")*}><span class="fa fa-trash"></span> </button>{/if}
                                {if isset($action_datatable_after) && count($action_datatable_after)} {foreach $action_datatable_before as $k => $v}
                                <button class="btn btn-{$v['color']|default:'default'}" type="button" data-id="{$record.id}" onclick="javascript:{$v['onclick']}" {if $v[ 'tooltip']}{*html::tooltips( "{$v['tooltip']}")*}{/if}><span class="fa fa-{$v['icon']|default:'circle'}"></span></button>                            {/foreach} {/if}
                            </td>
                        </tr>

                        {/if} 
                    {/foreach}
                {/if}

                </tbody>
            </table>
            {if isset($paginator)}{$paginator}{/if}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<script>
    var _dt_data;
    var _option_dt_data = {
        "language": {
            "info": "Registros <strong>_START_</strong> al <strong>_END_</strong> de un total de <strong>_TOTAL_</strong> registros",
            "infoFiltered": " - filtrado de _MAX_ registros",
            "processing": "Procesando...",
            "search": "Filtrar: ",
            "sEmptyTable": "Sin datos para mostrar...",
            "sLoadingRecords": "Cargando...",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sZeroRecords": "No se encontraron resultados",
            "sSearchPlaceholder": "Filtar resultados...",
            "sDecimal": ",",
            "sInfoThousands": ",",
            "searchDelay": 100,
            "lengthMenu": 'Mostrar <select class="form-control" style="display: inline-block;width: auto;">' +
                '<option value="10">10</option>' +
                '<option value="25">25</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">Todos</option>' +
                '</select> páginas',
            "paginate": {
                "sFirst": '<span class="fa fa-square-o-left"></span>',
                "sLast": '<span class="fa fa-square-o-right"></span>',
                "sNext": '<span class="fa fa-caret-right"></span>',
                "sPrevious": '<span class="fa fa-caret-left"></span>'
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    };

    {if isset($dt_notsearching) AND $dt_notsearching == true}
        _option_dt_data.searching = false;
    {/if}
    {if isset($dt_notpaginate) AND $dt_notpaginate == true}
        _option_dt_data.paginate = false;
        _option_dt_data.info = false;
    {/if}

    $(document).ready(function() {
        _dt_data = $('#dt_data').DataTable(_option_dt_data);
        $('.dataTables_filter input').addClass('form-control').css('display', 'inline-block').css('width', 'auto');
    });
</script>