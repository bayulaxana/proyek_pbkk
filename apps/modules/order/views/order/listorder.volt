{% extends "../layouts/base.volt" %}

{% block title %}Halaman Lihat Order{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                <div class="col-sm-8"><h2>Daftar <b>Pesanan User</b></h2></div>
            </div>
            <div class="row" style="height:2vw"></div>
            </div>
           {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Order Id</th>
                        <th>Nama Service</th>
                        <th>Total Pesanan</th>
                        <th>Tanggal Pesanan</th>
                        <th>Estimasi Tanggal Selesai</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {% set i = 1 %}
                    {% for t in page %}
                        <tr>
                            <td>{{i}}</td>
                            <td>{{t['order_id']}}</td>
                            <td>{{t['service_name']}}</td>
                            <td>{{t['order_total']}}</td>
                            <td>{{t['order_date']}}</td>
                            <td>{{t['finish_date']}}</td>
                            <td>{{t['order_status']}}</td>
                            <td>
                                <a href="#lihatNotesModal{{t['order_id']}}" class="view" data-toggle="modal" ><i class="fa fa-eye" data-toggle="tooltip" title="Lihat Detail Item"></i></a>
                                <a href="#tambahNotesModal" class="order-hidden add" data-toggle="modal"><i class="fa fa-plus" data-toggle="tooltip" title="Tambah Catatan"></i></a>
                                <a href="#editNotesModal{{t['order_id']}}" class="edit" data-toggle="modal"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah Catatan"></i></a>
                                <a href="#hapusNotesModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Hapus Catatan"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

<div id="tambahNotesModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add/comment" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Catatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <input type="hidden" id="order_id" name="order_id" value="">
                <div class="modal-body">
                     <div class="form-group">
                        <label><b>Konten Komentar</b></label>
                        <p><input type="textarea" class="form-control" name="comment_content" id="comment_content"></p>
                    </div>	
                     <div class="form-group">
                        <label><b>Status Komentar</b></label>
                        <p><input type="text" class="form-control" name="comment_status" id="comment_status"></p>
                    </div>
                    <div class="form-group">				
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

{% set j = 0 %}
{% for t in page %}
<div id="hapusNotesModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="listorder" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Catatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value="{{detail_item[j][0]['comment_id']}}" name='comment_id' id='comment_id'>
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

<div id="editNotesModal{{t['order_id']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/comment" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Ubah Catatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <input type="hidden" id="comment_id" name="comment_id" value="{{detail_item[j][0]['comment_id']}}">
                <div class="modal-body">
                     <div class="form-group">
                        <label><b>Konten Komentar</b></label>
                        <p><input type="textarea" class="form-control" name="comment_content" id="comment_content"  value="{{detail_item[j][0]['comment_content']}}"></p>
                    </div>	
                     <div class="form-group">
                        <label><b>Status Komentar</b></label>
                        <p><input type="text" class="form-control" name="comment_status" id="comment_status"  value="{{detail_item[j][0]['comment_status']}}"></p>
                    </div>
                    <div class="form-group">				
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

<div id="lihatNotesModal{{t['order_id']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">						
                    <h4 class="modal-title">Detail Komentar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                {% if detail_item[j] != null %}
                <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Detail Komentar </th>
                        <th>Status Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    {% set k = 1 %}
                    {% for l in detail_item[j] %}
                        <tr>
                            <td>{{k}}</td>
                            <td>{{l['comment_content']}}</td>
                            <td>{{l['comment_status']}}</td>
                        </tr>
                    {% set k = k + 1 %}
                    {% endfor %}
                </tbody>
                </table>
                {% endif %}
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                </div>
            </form>
        </div>
    </div>
</div>
{% set j = j + 1 %}
{% endfor %}
{% endblock %}
