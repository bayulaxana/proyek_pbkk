{% extends "../layouts/base.volt" %}

{% block title %}Halaman Order{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                <div class="col-sm-8"><h2>Kelola <b>Pesanan Laundry</b></h2></div>
            </div>
            <div class="row" style="height:2vw"></div>
            </div>
           {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Order Id</th>
                        <th>Kepemilikan Pesanan</th>
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
                            <td>{{offset + i}}</td>
                            <td>{{t['Orders_order_id']}}</td>
                            <td>{{t['name']}}</td>
                            <td>{{t['service_name']}}</td>
                            <td>{{t['Orders_order_total']}}</td>
                            <td>{{t['Orders_order_date']}}</td>
                            <td>{{t['Orders_finish_date']}}</td>
                            <td>{{t['Orders_order_status']}}</td>
                            <td>
                                <a href="#lihatItemModal{{t['Orders_order_id']}}" class="view" data-toggle="modal" ><i class="fa fa-eye" data-toggle="tooltip" title="Lihat" value="{{t['Orders_order_id']}}"></i></a>
                                <a href="#editOrderModal{{t['Orders_order_id']}}" class="edit" data-toggle="modal" ><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value="{{t['Orders_order_id']}}"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/order' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/order?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/order?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/order?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

{% set j = 0 %}
{% for t in page %}
<div id="editOrderModal{{t['Orders_order_id']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/order" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Pesanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="order_id" name="order_id" value="{{t['Orders_order_id']}}">
                    <div class="form-group">
                        <label><b>Tanggal Selesai Pesanan</b></label>
                        <p><input type="date" class="form-control" name="finish_date" id="finish_date" value="{{t['Orders_finish_date']}}"></p>
                    </div>	
                    <div class="form-group">
                        <label><b>Status Pesanan</b></label>
                        <p><input type="text" class="form-control" name="order_status" id="order_status" value="{{t['Orders_order_status']}}"></p>
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

<div id="lihatItemModal{{t['Orders_order_id']}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">						
                    <h4 class="modal-title">Detail Item Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                {% if detail_item[j] != null %}
                <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tipe Item</th>
                        <th>Detail Item</th>
                    </tr>
                </thead>
                <tbody>
                    {% set k = 1 %}
                    {% for l in detail_item[j] %}
                        <tr>
                            <td>{{k}}</td>
                            <td>{{l['item_type']}}</td>
                            <td>{{l['item_details']}}</td>
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