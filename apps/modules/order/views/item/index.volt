{% extends "../layouts/base.volt" %}

{% block title %}Halaman Daftar Item{% endblock %}
{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="ket row">
                <div class="container-fluid" style="margin-left:30vw">
                {% if items|length > 0 %}
                    <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
                        <div class="carousel-inner row w-100 mx-auto 0 text" role="listbox">
                        {% for s in items %}
                            {% if (loop.first) %}
                                <div class="carousel-item col-md-4 active">
                            {% else %}
                            <div class="carousel-item col-md-4">
                            {% endif %}
                                <div class="card h-100">
                                    <div class="card-body">
                                        <img src={{s.getItemPhoto()}} class="service" style="height:150px;">
                                        <h4 class="card-title text-center">{{s.getItemType()}}</h4>
                                        <p class="text-center"><b>{{s.getItemDetail()}}</b><p>
                                        <a href="#editItemModal{{s.getId()}}" class="btn btn-primary" data-toggle="modal">Ubah Item</a>
                                        <a href="#deleteItemModal" class="set-hidden btn btn-danger" data-toggle="modal" value="{{s.getId()}}">Hapus Item</a>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center mt-4" style="display:block;">
                            <a class="btn btn-outline-secondary mx-1 prev" href="javascript:void(0)" title="Previous">
                            <i class="fa fa-lg fa-chevron-left"></i>
                            </a>
                            <a class="btn btn-outline-secondary mx-1 next" href="javascript:void(0)" title="Next">
                            <i class="fa fa-lg fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {% else %}
                <h2>Tidak ada data yang ditampilkan</h2>
                {% endif %}
            </div>
        </div>
    </main>
</div>

<div id="deleteItemModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="item" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='item_id' id='item_id'>
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

{% for t in items %}
<div id="editItemModal{{t.getId()}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="update/item" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Ubah Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="item_id" name="item_id" value="{{t.getId()}}">
                    <div class="form-group">
                        <label><b>Detail Item</b></label>
                        <p><input type="text" class="form-control" name="item_details" id="item_details" value="{{t.getItemDetail()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Tipe Item</b></label>
                        <p><input type="text" class="form-control" name="item_type" id="item_type" value="{{t.getItemType()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Tipe Item</b></label>
                        <p><input type="file" class="form-control" name="item_photo" id="item_photo"></p>
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