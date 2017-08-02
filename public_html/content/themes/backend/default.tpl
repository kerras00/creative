{include file="includes/head.tpl"}
{include file="includes/header.tpl"}
<main id="main-content">
    <div id="main-content-section" class="main-section">

        {if $breadcrumbs == true } 
            {include file=$theme.dir|cat:'includes/breadcrumbs.tpl'} 
        {/if} 

        {if strpos($view_html , ".tpl") == true } 
            {include file=$view_html nocache} 
        {else}
            {$view_html} 
        {/if}

        {if isset($outerhtml) && count($outerhtml)} 
            {foreach $outerhtml as $key => $value}
                {eval $value} 
            {/foreach}
        {/if}

    </div>
</main>

{include file="includes/footer.tpl"}

<script>
function messagebox( title, message, type ){
	
	bootbox.alert({
    	message: '</br><p>' + message + '</br></p>',
	    size: 'small',
	});
}
</script>
