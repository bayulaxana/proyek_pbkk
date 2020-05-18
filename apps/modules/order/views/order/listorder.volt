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
                                <a href="#lihatItemsModal" class="view" data-toggle="modal" ><i class="fa fa-eye" data-toggle="tooltip" title="Lihat Detail Item"></i></a>
                                <a href="#tambahNotesModal" class="add" data-toggle="modal" ><i class="fa fa-plus" data-toggle="tooltip" title="Tambah Catatan"></i></a>
                                <a href="#editNotesModal" class="edit" data-toggle="modal" ><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah Catatan"></i></a>
                                <a href="#hapusNotesModal" class="delete" data-toggle="modal" ><i class="fa fa-trash-o" data-toggle="tooltip" title="Hapus Catatan"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <!--<div class="text-center text-lg">
                <a href='/listorder' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/listorder?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/listorder?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/listorder?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>-->
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

<div id="tambahNotesModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add/notes" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">				
                    </div>
                    <div class="form-group">				
                    </div>
                    <div class="form-group">				
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

