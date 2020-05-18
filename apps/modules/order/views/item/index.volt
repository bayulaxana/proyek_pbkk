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
                                        <p class="text-center"><b>Rp. {{s.getItemDetails()}}</b><p>
                                        <input type="button" value="Ubah Item">
                                        <input type="button" value="Hapus Item">
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

{% endblock %}