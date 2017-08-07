</section>
</section>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; {$smarty.now|date_format:"%Y"} {App::get()->company_name}.</strong> Todos los derechos reservados.
</footer>

</div>

<script>
 var DashboardOptions = {
    navbarMenuSlimscroll: true,
    animationSpeed: 400,
    BSTooltipSelector: "[data-toggle='tooltip']",
    sidebarExpandOnHover: false,
    enableBoxRefresh: true,
    enableBSToppltip: true
};
npm('notify');
npm('loading');
</script>

<script src="{$theme.js}script.js?v={rand()}"></script>

<script src="{$assets.components}datatable/media/js/jquery.dataTables.js"></script>
<link href="{$assets.components}datatable/media/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" />

<script src="{$assets.components}jquery.numeric/jquery.numeric.js"></script>

<script type="text/javascript" src="{$assets.components}select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="{$assets.components}select2/dist/css/select2.min.css">

<script src="{$assets.components}bootbox/bootbox.js"></script>
<link rel="stylesheet" href="{$theme.css}forms.css?v={rand()}" type="text/css" />
<link rel="stylesheet" href="{$theme.css}datatable.css?v={rand()}" type="text/css" />

<script>
    $(function() {
        $('.numeric').numeric();
        $(".select2").select2({
            placeholder: "Seleccione..."
        });
        $('[data-toggle="popover"]').popover();
    });
</script>
</body>