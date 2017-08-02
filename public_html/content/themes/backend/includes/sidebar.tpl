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
		<li><a href="#" title="Edit profile"> <i class="fa fa-user"></i> {Lang::get('my_profile')}</a></li> 
		<li><a href="#" title="Edit profile"> <i class="fa fa-envelope-o"></i> {Lang::get('messages')}</a></li> 
		<li class="logout-link"> <a href="#" {Helper::get('html')->tooltip(Lang::get('exit'))}> <i class="fa fa-power-off"></i> </a> </li> 
	</ul>

	<ul class="sidebar-menu">
		
	{if isset($menu) && count($menu)}	
		{foreach $menu as $module_name => $module_attr}
			{if isset($module_attr.modules) && count($module_attr.modules)}				
				<li id="{$module_name}" class="treeview{if $active_menu==$module_name} active{/if}">
					<a href="#">
						<i class="{$module_attr.icon|default:'fa fa-circle'}"></i>
						<span>{$module_attr.text}</span>
						<span class="pull-right-container">
							<span class="fa fa-angle-right pull-right"></span>
						</span>
					</a>
					<ul class="treeview-menu">
						{foreach $module_attr.modules as $module_ix => $module}
							<li id="{$module_ix}">
								<a href="/{$module_attr.module}/{$module_name}/{$module_ix}/">
									<i class="{$module['icon']}"></i> <span>{$module['text']}</span>
								</a>
							</li>
						{/foreach}							
					</ul>
				</li>
			{else}
				<li id="{$method_ix}">
					<a href="/{$module_attr.module}/{$module_name}/">
						<i class="{$module_attr.icon}"></i> <span>{$module_attr.text}</span>
					</a>
				</li>
			{/if}	
		{/foreach}
	{/if}

	</ul>
</section>
</aside>