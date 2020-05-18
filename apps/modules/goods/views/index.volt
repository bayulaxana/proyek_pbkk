{% extends "../layouts/base.volt" %}

{% block title %}Kelola Barang{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Kelola <b>Barang Laundry</b></h2></div>
            </div>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <a href="#tambahBarangModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Tambah Barang</span></a>
                    <a id="multi-uwus" href="#hapusBarangModal" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i><span>Hapus</span></a>						
                </div>
            </div>
        </div>
        {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Jenis Barang</th>
                        <th>Harga per Unit</th>
                        <th>Stock Barang</th>
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
                            <td>{{t.getGoodsName()}}</td>
                            <td>{{t.getUnitPrice()}}</td>
                            <td>{{t.getGoodStock()}}</td>
                            <td>
                                <!--change to button-->
                                <a href="#editBarangModal{{t.getId()}}" class="edit" data-toggle="modal" data-remote="{{url('edit/pickup_Expense?')}}"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value="{{t.getId()}}"></i></a>
                            </td>
                        </tr> 
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/goods' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/goods?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/goods?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/goods?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
        </div>
    <main>
</div>

<div id="tambahBarangModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="GoodsForm" action="add/goods" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">									
                    <div class="form-group">
                        <label><b>{{form.getLabel('goods_name')}}</b></label>
                        {{form.render('goods_name')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('unit_price')}}</b></label>
                        {{form.render('unit_price')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('good_stock')}}</b></label>
                        {{form.render('good_stock')}}
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

<div id="hapusBarangModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="goods" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='goods_id' id='goods_id'>
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
<div id="editBarangModal{{t.getId()}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/goods" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="goods_id" name="goods_id" value="{{t.getId()}}">
                    <div class="form-group">
                        <label><b>Nama Barang</b></label>
                        <p><input type="text" class="form-control" name="goods_name" id="goods_name" value="{{t.getGoodsName()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Harga per Unit</b></label>
                        <p><input type="text" class="form-control" name="unit_price" id="unit_price" value="{{t.getUnitPrice()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Stock Barang</b></label>
                        <p><input type="text" class="form-control" name="good_stock" id="good_stock" value="{{t.getGoodStock()}}"></p>
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