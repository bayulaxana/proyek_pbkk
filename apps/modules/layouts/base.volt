<!DOCTYPE html>
<html>
<head>
	{% include '../layouts/header.volt' %}
	<title>{% block title %} {% endblock %}</title>
</head>
<body>
	{% include '../layouts/navbar.volt' %}
	{% block content %} {% endblock %}
	<div class="clearfix bottom-content">
		<div class="row" style="position: relative; margin-top:10vh; width: 100%; color: white"> 
			<div class="col-md-8">
				<p style="padding-left: 2vw;">© Copy Right by Bella Septina. Created with<span>❤</span></p>
			</div>
			<div class="col-md-4">
				<div class="row">
				<div class="col-sm">
                	<a type="button" class="text-light" href=""><i class="fa fa-globe" style="font-size:24px"></i>service.laundry.com</a><br>
                </div>
				<div class="col-sm">
					<a type="button" class="text-light" href=""><i class="fa fa-facebook-square" style="font-size:24px"></i> Service Laundry Organizer</a><br>
				</div>
				</div>
			</div>
		</div> 
	</div>
</body>
</html>