{% extends "../layouts/base.volt" %}

{% block title %}Dashboard Admin{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
            <!--<input type="hidden" class="datas" value="{{}},{% endfor %}">-->
            <h2 class="text-center text-secondary"><span class="text-danger">Selamat Datang</span><br>di Halaman Dashboard</h2>
            <hr id="line">
            <div class="row">
                <div class="col-sm">
                    <div class="card chart">
                        <div width=100 style="height:36vh">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
