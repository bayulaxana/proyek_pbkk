{% extends "../layouts/base.volt" %}

{% block title %}Halaman Login{% endblock %}

{% block content %}

{% if cookies.has('username') %}
	
{% endif %}

<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
	<div class="row" style="margin-top:5vh">
		{% if flash != null  %}
			<div id="hides" class="cards notif-block" style="position:absolute; margin-top: 2vh; height:5vh; width:100%">{{flash.output()}}</div>
		{% endif %}
	</div>
	<div class="row-centered">
		<div class="card login-card" style="margin-top:25vh">
			<img class="avatar" src="{{url('assets/logo.png')}}">
			<h1 class="text-center text-secondary">Log In <span class="text-info">Akun</span></h1>
			<div class="col-md-6" style="margin-left:12vw;">
				{{ form.startForm()}}
					<div class="form-group">
						{{form.render('username') }}
					</div>
					<div class="form-group">
						{{ form.render('password') }}
					</div>
					<div class="form-group">
					{{ form.render('Login') }}
					</div style="margin-left:50px;">
						{{ form.render('remember') }}
						{{ form.getLabel('remember') }}
					</div>
				{{ form.endForm() }}
			</div>
		</div>
		<div class="floats">
			<img src="{{url('assets/login.png')}}" style="height:80vh">
		</div>
	</div>
</div>

{% endblock %}