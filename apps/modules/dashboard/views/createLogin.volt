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
		{% if msg_error != null %}
			{% for i in msg_error %}
				<div id="hides" class="cards notif-block" class="alert alert-danger" style="position:absolute; margin-top: 2vh; height:5vh; width:100%">{{i}}</div>
			{% endfor %}
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
				<div class="row" style="margin-left:13vw">
					<p>Belum memiliki akun? </p>
					<a href="#registerModal" class="btn btn-success" data-toggle="modal" style="margin-left:10px">Register</a>
				</div>
			</div>
		</div>
		
	</div>
</div>

<div id="registerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">						
                <h4 class="modal-title text-center">Register</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height:70vh; overflow-y:auto;">
                <form class="UserForm" action="store/user" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><b>{{forms.getLabel('name')}}</b></label>
                        {{forms.render('name')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('address')}}</b></label>
                        {{forms.render('address')}}
                    </div>
                    <p><b>Jenis Kelamin</b></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{forms.render('P')}}
                                <label>{{forms.getLabel('P')}}</label> 
                            </div>	
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{forms.render('L')}}
                                <label>{{forms.getLabel('L')}}</label>
                            </div>	
                        </div>
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('email')}}</b></label>
                        {{forms.render('email')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('phone')}}</b></label>
                        {{forms.render('phone')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('username')}}</b></label>
                        {{forms.render('username')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('password')}}</b></label>
                        {{forms.render('password')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{forms.getLabel('profile_img')}}</b></label>
                        {{forms.render('profile_img')}}
                    </div>
            </div>
            <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <div class="form-group">
                        <div class="text-center">
                            {{forms.render('Simpan')}}
                        </div>
                    </div>
                </form>
            </div>
            </div>					
        </div>
    </div>
</div>

{% endblock %}