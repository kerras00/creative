<aside class="main-sidebar">
<section class="sidebar">
	<div class="user-panel" style="min-height: 60px">
		<div class="pull-left image">
			<img id="user_img_menu" src="{$theme.img|cat:'user.backend.png'}" class="user-image img-circle" alt="" style="background-color: #fff">
		</div>
		<div class="info">
			<p>{$backend.description|upper}</p>
			<a href="#"><span class="fa fa-circle" style="color:#56b726"></span>{if $backend.profile_name}{$backend.profile_name}{/if}</a>
		</div>
	</div> 

	<ul class="user-links list-unstyled">
		<li>
			<a href="#" title="Edit profile"> <i class="fa fa-user"></i> Perfil</a>
		</li> 
		<li>
			<a href="#" title="Edit profile"> <i class="fa fa-envelope-o"></i> Mensajes</a>
		</li> 
		<li class="logout-link"> <a href="#" title="Log out"> <i class="fa fa-power-off"></i> </a> </li> 
	</ul>

	<ul class="sidebar-menu">
		
	{if isset($registry) && count($registry)}	
		{foreach $registry as $controller_ix => $controller_attr}
			{if isset($controller_attr.methods) && count($controller_attr.methods)}

				<li id="{$controller_ix}" class="treeview">
					<a href="#">
						<i class="{$controller_attr.icon|default:'fa fa-circle'}"></i>
						<span>{$controller_attr.text}</span>
						<span class="pull-right-container">
							<span class="fa fa-angle-right pull-right"></span>
						</span>
					</a>
					<ul class="treeview-menu">
						{foreach $controller_attr.methods as $method_ix => $method_attr}
							<li id="{$method_ix}">
								<a href="/{$controller_attr.module}/{$controller_ix}/{$method_ix}/">
									<i class="{$method_attr.icon}"></i> <span>{$method_attr.text}</span>
								</a>
							</li>
						{/foreach}							
					</ul>
				</li>
			{else}
				<li id="{$method_ix}">
					<a href="/{$controller_attr.module}/{$controller_ix}/">
						<i class="{$controller_attr.icon}"></i> <span>{$controller_attr.text}</span>
					</a>
				</li>
			{/if}	
		{/foreach}
	{/if}

	</ul>
</section>
</aside>


<script>

{if isset($current) && count($current)}
$(document).ready(function(){
	{foreach $current as $key => $value}	
	$('#{$value}').addClass('active');	
	{/foreach}
});
{/if}

</script>