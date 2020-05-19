<!DOCTYPE html>
<html>
<head>
	{% include '../layouts/header.volt' %}
	<title>{% block title %} {% endblock %}</title>
</head>
<body>
	{% include '../layouts/navbar.volt' %}
	{% block content %} {% endblock %}
	
	<footer class="footer-distributed">
		<div class="footer-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-linkedin"></i></a>
			<a href="#"><i class="fa fa-github"></i></a>
		</div>

		<div class="footer-left">
			<p class="footer-links">
				<a class="link-1" href="{{ url('home') }}">Laundry Service Organizer</a>
			</p>
			<p>Created with ❤ by Bayu Laksana and Bella Septina Ika &copy; 2020</p>
		</div>
	</footer>

	<script type="text/javascript" src="{{ url("js/navbar.js") }}"></script>
</body>
</html>