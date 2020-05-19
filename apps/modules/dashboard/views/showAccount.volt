{% extends "../layouts/base.volt" %}

{% block title %}Halaman Profil{% endblock %}

{% block content %}

{% if cookies.has('username') %}
	
{% endif %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
<main id="main-container">
<div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
<div class="row-centered">
	<div class="card pb-4 login-card" style="margin-left:25vw; margin-top:15vh">
        <img class="avatar" src={{data.getProfileImg()}}>
		<h1 class="text-center text-secondary profil">Profil
            {% if session.get('auth')['role'] == 1 %} 
                <span class="text-danger">Administrator</span></h1>
            {% else %}
                <span class="text-danger">Member</span></h1>
            {% endif %}
        <h1 class="text-center text-secondary profil"><span class="text-primary">.:{{data.getUsername()}}:.</span></h1>
        <div class="row" style="margin-left:10vw;">
            <div class="col-md-6">
                <label>Nama Lengkap</label>
                <p>{{data.getName()}}</p>
                <label>Alamat Tempat Tinggal</label>
                <p>{{data.getAddress()}}</p>
            </div>
            <div class="col-md-6">
                <label>Nomor HP/Telepon</label>
                <p>{{data.getPhone()}}</p>
                <label>Alamat Email</label>
                <p>{{data.getEmail()}}</p>
            </div>
        </div>
        <div class="row justify-content-center" style="margin-left:5vw;">
            <div class="col-md">
                <a href="#editProfilModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah Profil"><b>Ubah Profil</b></i></a>
            </div>
            <div class="col-md">
                <a href="#changePasswordModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah Password"><b>Ubah Password</b></i></a>
            </div>
            <div class="col-md">
                <a href="#changeImageModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah Gambar"><b>Ubah Gambar</b></i></a>
            </div>
        </div>
	</div>
</div>
</main>
</div>

<div id="editProfilModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">						
                <h4 class="modal-title text-center">Edit Profil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height:70vh; overflow-y:auto;">
                <form action="update/user" method="POST">
                    <input type="hidden" name="user_id" id="user_id" value="{{data.getId()}}">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{data.getName()}}">
                    </div>
                    <div class="form-group">
                        <label><b>Username</b></label>
                        <input type="text" class="form-control" name="username" id="username" value="{{data.getUsername()}}">
                    </div>
                    <label><b>Jenis Kelamin</b></label>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="radio"  name="gender" id="gender" value='P'>
                                <label>Perempuan</label> 
                            </div>	
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                 <input type="radio" name="gender" id="gender" value='L'>
                                <label>Laki-Laki</label>
                            </div>	
                        </div>
                    </div>
                    <div class="form-group">
                        <label><b>Alamat</b></label>
                        <input type="text" class="form-control" name="address" id="address" value="{{data.getAddress()}}">
                    </div>
                    <div class="form-group">
                        <label><b>Email</b></label>
                        <input type="email" class="form-control" name="email" id="email" value="{{data.getEmail()}}">
                    </div>
                    <div class="form-group">
                        <label><b>Nomor HP/Telepon</b></label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{data.getPhone()}}">
                    </div>
            </div>
            <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <div class="form-group">
                        <div class="text-center">
                          <input type="submit" class="btn btn-success" id="Simpan" nama="Simpan" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
            </div>					
        </div>
    </div>
</div>

<div id="changePasswordModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">						
                <h4 class="modal-title text-center">Ganti Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height:50vh; overflow-y:auto;">
                <form action="update/password" method="POST">
                    <input type="hidden" name="user_id" id="user_id" value="{{data.getId()}}">
                    <div class="form-group">
                        <label><b>Password Saat Ini</b></label>
                        <input type="password" class="form-control" name="old_password" id="old_password">
                    </div>
                    <div class="form-group">
                        <label><b>Password Baru</b></label>
                        <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
            </div>
            <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <div class="form-group">
                        <div class="text-center">
                           <input type="submit" class="btn btn-success" id="Simpan" nama="Simpan" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
            </div>					
        </div>
    </div>
</div>

<div id="changeImageModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">						
                <h4 class="modal-title text-center">Ganti Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="height:50vh; overflow-y:auto;">
                <form action="update/image" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id" value="{{data.getId()}}">
                    <div class="form-group">
                        <label><b>Unggah Foto</b></label>
                        <input type="File" class="form-control" name="profile_img" id="profile_img">
                    </div>
            </div>
            <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <div class="form-group">
                        <div class="text-center">
                           <input type="submit" class="btn btn-success" id="Simpan" nama="Simpan" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
            </div>					
        </div>
    </div>
</div>
{% endblock %}