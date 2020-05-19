{% extends "../layouts/base.volt" %}

{% block title %}Beranda{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
            <div class="card my-3 p-4">
            <h1 class="text-center text-secondary"><span class="text-danger">Selamat Datang</span><br> 
            di ServiceLaundry.com</h1>
            <hr id="line">
            <div class="row-center">
                <div id="demo" class="carousel slide" data-ride="carousel" data-interval="10000" data-pause="hover">
                    <ol class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" style="margin-left:12vw;">
                        <div class="carousel-item active">
                            <img class="img img-fluid img-responsive" src="{{url('assets/gambar1.jpg')}}" alt="Gambar 2">
                        </div>
                        <div class="carousel-item">
                            <img class="img img-fluid img-responsive" src="{{url('assets/gambar2.jpg')}}" alt="Gambar 3">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            </div>
            <div class="card my-3">
                <div class="ket row">
                    <div class="col-sm text-center">
                        <img src="{{url('assets/images3.gif')}}" height=100>
                        <h5>Harga Murah</h5>
                        <p><b>Jasa laundry kami memberikan harga murah karena kepuasan pelanggan adalah kebanggaan bagi kami.</b></p>
                    </div>
                    <div class="col-sm text-center">
                        <img src="{{url('assets/images2.gif')}}" height=100>
                        <h5>Antar Jemput</h5>
                        <p><b>Kami siap melakukan antar jemput kepada semua calon pelanggan yang mengunakan jasa kami dengan jarak tertentu.</b></p>
                    </div>
                    <div class="col-sm text-center">
                        <img src="{{url('assets/images.gif')}}" height=100>
                        <h5>Cepat dan Bersih</h5>
                        <p><b>Kami mencuci dengan menggunakan mesin modern sehingga menghasilkan pakaian yang bersih dan cepat selesai.</b></p>
                    </div>
                </div>
            </div>
            <div class="card shadow my-3">
                <div class="card-header">
                    <h2 class="text-center text-secondary"><br>Daftar <span class="">Service Laundry</span><br></h1>
                </div>
                <div class="ket row">
                    <div class="container-fluid" style="margin-left:30vw">
                    {% if service|length > 0 %}
                        <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
                            <div class="carousel-inner row w-100 mx-auto 0 text" role="listbox">
                            {% for s in service %}
                                {% if (loop.first) %}
                                    <div class="carousel-item col-md-4 active">
                                {% else %}
                                <div class="carousel-item col-md-4">
                                {% endif %}
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <img src={{s.getServicePhoto()}} class="service" style="height:150px;">
                                            <h4 class="card-title text-center">{{s.getServiceName()}}</h4>
                                            <p class="text-center"><b>Rp. {{s.getServicePrice()}}</b><p>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row py-3">
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
                    {% endif %}
                </div>
                <div class="card-footer text-muted">
                    
                </div>
            </div>
        </div>
    </main>
</div>
{% endblock %}