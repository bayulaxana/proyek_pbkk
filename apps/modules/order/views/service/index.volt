{% extends "../layouts/base.volt" %}

{% block title %}Halaman Service{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Kelola <b>Service Laundry</b></h2></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <a href="#tambahServiceModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Tambah Service</span></a>
                        <a id="multi-uwus" href="#deleteServiceModal" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i><span>Hapus</span></a>						
                    </div>
                </div>
            </div>
           {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Nama Service</th>
                        <th>Harga Service</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {% set i = 1 %}
                    {% for t in page %}
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options" value="{{t.getId()}}">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>{{offset + i}}</td>
                            <td>{{t.getServiceName()}}</td>
                            <td>{{t.getServicePrice()}}</td>
                            <td>
                                <a href="#editServiceModal{{t.getId()}}" class="edit" data-toggle="modal" ><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value="{{t.getId()}}"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/service' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/service?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/service?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/service?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

<div id="tambahServiceModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add/service" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">				
                        <label><b>{{form.getLabel('service_name')}}</b></label>
                        {{form.render('service_name')}}
                    </div>
                    <div class="form-group">				
                        <label><b>{{form.getLabel('service_price')}}</b></label>
                        {{form.render('service_price')}}
                    </div>
                    <div class="form-group">				
                        <label><b>{{form.getLabel('service_photo')}}</b></label>
                        {{form.render('service_photo')}}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    {{form.render('Simpan')}}
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteServiceModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="service" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='service_id' id='service_id'>
                    <p>Apakah Anda yakin untuk menghapus data yang telah dipilih ?</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-danger" value="Hapus">
                </div>
            </form>
        </div>
    </div>
</div>

{% set j = 0 %}
{% for t in page %}
<div id="editServiceModal{{t.getId()}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/service" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="service_id" name="service_id" value="{{t.getId()}}">
                    <div class="form-group">
                        <label><b>Nama Service</b></label>
                        <p><input type="text" class="form-control" name="service_name" id="service_name" value="{{t.getServiceName()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Harga Service</b></label>
                        <p><input type="text" class="form-control" name="service_price" id="service_price" value="{{t.getServicePrice()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Foto Service</b></label>
                        <p><input type="file" class="form-control" name="service_photo" id="service_photo" value="{{t.getServicePhoto()}}"></p>
                    </div>								
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-success" id="Simpan" nama="Simpan" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>
{% set j = j + 1 %}
{% endfor %}

{% endblock %}