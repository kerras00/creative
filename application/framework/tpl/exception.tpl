<nav class="navbar navbar-inverse" style="border-radius: 0px !important;">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">:header</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#:exception_number">Error number: :exception_number</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
		<div class="col-md-12">
			<strong style="font-size: 20px; color: red">[:exception_type]</strong><br/>
			<strong>:exception_title</strong>
		</div>
		
		<div class="col-md-12">
			:exception_message
			:calleds
		</div>
</div>

<style>
	.error_info{
		display: block;
		border: 1px solid #c2c2c2;
		background-color: #fff;
		padding: 15px;
		margin: 15px auto;			
	}
	li{
		padding-bottom: 8px;
	}
</style>