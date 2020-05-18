{% extends "../layouts/base.volt" %}

{% block title %}Halaman Antar-Jemput{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Kelola <b>Pickup Delivery Laundry</b></h2></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <a href="#tambahDeliveryModal"  class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Tambah Pickup Delivery</span></a>
                        <a id="multi-uwus" href="#deleteDeliveryModal" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i><span>Hapus</span></a>						
                    </div>
                </div>
            </div>
            {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Kepemilikan Pesanan</th>
                        <th>Status Pengantaran</th>
                        <th>Nama Pengantar</th>
                        <th>Tipe Pengantaran</th>
                        <th>Estimasi Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {% set i = 1 %}
                    {% for t in page %}
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options" value="{{t['ids']}}">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>{{offset + i}}</td>
                            <td>{{t['name']}}</td>
                            <td>{{t['Pickup_pd_status']}}</td>
                            <td>{{t['Pickup_pd_driver']}}</td>
                            <td>{{t['Pickup_pd_type']}}</td>
                            <td>{{t['Pickup_pd_time_est']}}</td>
                            <td>
                                <a href="#editDeliveryModal{{t['ids']}}" class="edit" data-toggle="modal" ><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value=""></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/pickup_delivery' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/pickup_delivery?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/pickup_delivery?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/pickup_delivery?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
            </div>
        </div>
    </main>
</div>

<div id="tambahDeliveryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="PickupDeliveryForm" action="add/pickup_delivery" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Pickup Delivery</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>{{form.getLabel('order_id')}}</b></label>
                        {{form.render('order_id')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('pd_status')}}</b></label>
                        {{form.render('pd_status')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('pd_driver')}}</b></label>
                        {{form.render('pd_driver')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('pd_type')}}</b></label>
                        {{form.render('pd_type')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('pd_time_est')}}</b></label>
                        {{form.render('pd_time_est')}}
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

<div id="deleteDeliveryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="pickup_delivery" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Pickup Delivery</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='pd_id' id='pd_id'>
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

{% for t in page %}
<div id="editDeliveryModal{{t['ids']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="edit/pickup_delivery" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Pickup Delivery</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="pd_id" name="pd_id" value="{{t['ids']}}">
                    <div class="form-group">
                        <label><b>Status Pickup Delivery</b></label>
                        <p><input type="text" class="form-control" name="pd_status" id="pd_status" value="{{t['Pickup_pd_status']}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Driver Pickup Delivery</b></label>
                        <p><input type="text" class="form-control" name="pd_driver" id="pd_driver" value="{{t['Pickup_pd_driver']}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Tipe Pickup Delivery</b></label>
                        <p><input type="text" class="form-control" name="pd_type" id="pd_type" value="{{t['Pickup_pd_type']}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Estimasi Waktu</b></label>
                        <p><input type="text" class="form-control" name="pd_time_est" id="pd_time_est" value="{{t['Pickup_pd_time_est']}}"></p>
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
{% endfor %}
{% endblock %}