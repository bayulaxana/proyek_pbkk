{% extends "../layouts/base.volt" %}

{% block title %}Halaman Tambah Order{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
            <div class="table-wrapper" style="height:70vh">
            <form action="users" method="POST" enctype="multipart/form-data">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Tambah <b>Pesanan</b></h2></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <a id="multi-items" class="btn btn-success"><i class="fa fa-plus"></i><span>Tambah Item</span></a>						
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label><b>Pilih Nama Service</b></label>
                    <select class="selectpicker form-control" data-live-search="true" data-container="body" name="pilihan" id="pilihan">
                        {% for s in service %}
                            <option  title="{{s.getServiceName()}}" price="{{s.getServicePrice()}}" value="{{s.getId()}}">{{s.getServiceName()}}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="col-sm">
                    <label><b>Total Berat Cucian (/kg)</b></label>
                    <div class="form-group"><input type="text" class="form-control" name="weight_total" id="weight_total"></div>
                </div>
                <div class="col-sm">
                    <label><b>Total Pesanan</b></label>
                    <div class="form-group"><input type="text" class="form-control" name="order_total" id="order_total"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label><b>Detail Item</b></label>
                    <div class="item-fields">
                        <div class='form-group'><input type='text' class='form-control' name='item_notes[]'></div>
                    </div>
                </div>
                <div class="col-sm">
                    <label><b>Tipe Item</b></label>
                    <div class="type-fields">
                        <div class='form-group'><input type='text' class='form-control' name='item_types[]'></div>
                    </div>
                </div>
                <div class="col-sm">
                    <label><b>Foto Item</b></label>
                    <div class="photos-fields">
                        <div class='form-group'><input type='file' class='form-control' name='item_photos[]'></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label><b>Pilih Parfum</b></label>
                    <div class="parfume-fields">
                        <div class='form-group'><input type='text' class='form-control' name='parfume'></div>
                    </div>
                </div>
            </div>
            <div class="row" style="float:right">
                <a id="changes" class="btn btn-info text-light" style="margin-right:15px"><span>Simpan Perubahan</span></a>		
                <input type="submit" class="btn btn-success" name="Simpan" id="Simpan" value="Kirim" disabled>		
                </div>
            </div>
            </form>
            <div>
        </div>
        </div>
    </main>
</div>
{% endblock %}