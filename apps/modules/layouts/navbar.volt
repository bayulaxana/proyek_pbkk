<!-- Header Content -->
        <!-- Nav tabs -->
        <nav class="navbar navbar-dark navbar-expand-lg fixed-top" style="font-size: 16px; background-color: #6878a0">
            {% if session.get('auth') and session.get('auth')['role'] == 1  %}
                <a class="nav-link text-light" href="{{url()}}">Home</a>
            {% elseif session.get('auth') and session.get('auth')['role'] == 0  %}
                <a class="nav-link text-light" href="{{url('dashboard/user')}}">Home</a>
            {% else %}
                <a class="nav-link text-light" href="{{url('home')}}">Home</a>
            {% endif %}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                {% if session.get('auth') %}
                    {% if session.get('auth')['role'] == 1 %}
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('expense')}}">Pengeluaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('goods')}}">Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('service')}}">Service Laundry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('order')}}">Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('pickup_delivery')}}">Jasa Antar-Jemput</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('payment')}}">Pembayaran</a>
                        </li>
                    {% else %}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pesanan</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('order/users')}}">Tambah Pesanan</a>
                                <a class="dropdown-item" href="{{url('/listorder')}}">Daftar Pesanan</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('item')}}">Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{url('history')}}">Riwayat</a>
                        </li>
                    {% endif %}
                {% endif %}
                </ul>
                <ul class="navbar-nav ml-auto">
                    {% if session.get('auth') %}
                        {% set val = 'profile?id=' ~ session.get('auth')['id'] %}
                        <a class="nav-link text-light" href="{{url(val)}}">Selamat Datang, <span class="text-info">{{ session.get('auth')['username'] }}</span></a>
                        <a class="nav-link btn btn-danger" href="{{url('logout')}}">Log Out</a>
                    {% else %}
                        <a class="nav-link text-light" href="{{url('login')}}">Log In</a>
                    {% endif %}
                </ul>
            </div>
        </nav>
<!-- END Header Content -->