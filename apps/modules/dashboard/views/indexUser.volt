{% extends "../layouts/base.volt" %}

{% block title %}Dashboard User{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
            <input type="hidden" class="ot" value="{% for a in orderDetail %}{{a}},{% endfor %}">
            <input type="hidden" class="totals" value="1">
            <input type="hidden" class="dates" value="1">
            <h2 class="text-center text-secondary"><span class="text-danger">Selamat Datang</span><br>di Halaman Dashboard</h2>
            <hr id="line">
            <div class="row">
                <div class="col-sm">
                    <div class="card chart">
                        <div width=100 style="height:80vh">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    var value1   = document.getElementsByClassName('ot')[0].value;
    var val1     = value1.split(",");

    var ctx1     = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: [val1[1]+' Pesanan Belum Selesai',val1[2]+' Pesanan Sudah Selesai', val1[3]+' Pesanan Menunggu'],
            datasets: [{
                label: '%',
                data: [val1[1]/val1[0]*100, val1[2]/val1[0]*100, val1[3]/val1[0]*100],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            title: {
                display: true,
                text: 'Grafik Pesanan User',
                fontSize: 20
            }
        }
    });
</script>
{% endblock %}
