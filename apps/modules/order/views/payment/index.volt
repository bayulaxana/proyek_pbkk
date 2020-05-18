{% extends "../layouts/base.volt" %}

{% block title %}Halaman Pembayaran{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Kelola <b>Pembayaran Laundry</b></h2></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <a href="#tambahBayarModal"  class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Tambah Pembayaran</span></a>
                        <a id="multi-uwus" href="#hapusPembayaranModal" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i><span>Hapus</span></a>										
                    </div>
                </div>
            </div>
           {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Order Id</th>
                        <th>Kepemilikan Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Waktu Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {% set i = 1 %}
                    {% for t in page %}
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options" value="{{t['Payment_payment_id']}}">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>{{offset + i}}</td>
                            <td>{{t['Payment_order_id']}}</td>
                            <td>{{t['name']}}</td>
                            <td>{{t['Payment_payment_status']}}</td>
                            <td>{{t['Payment_payment_time']}}</td>
                            <td>
                                <a href="#editPaymentModal{{t['Payment_payment_id']}}" class="edit" data-toggle="modal" ><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value="{{t['Payment_payment_id']}}"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/payment' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/payment?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/payment?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/payment?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

<div id="tambahBayarModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="PaymentForm" action="add/payment" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>{{form.getLabel('order_id')}}</b></label>
                        {{form.render('order_id')}}		
                    </div>
                    <div class="form-group">		
                        <label><b>{{form.getLabel('payment_status')}}</b></label>
                        {{form.render('payment_status')}}
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

<div id="hapusPembayaranModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="payment" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='payment_id' id='payment_id'>
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
<div id="editPaymentModal{{t['Payment_payment_id']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/payment" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="payment_id" name="payment_id" value="{{t['Payment_payment_id']}}">
                    <div class="form-group">
                        <label><b>Status Pesanan</b></label>
                        <p><input type="text" class="form-control" name="payment_status" id="payment_status" value="{{t['Payment_payment_status']}}"></p>
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