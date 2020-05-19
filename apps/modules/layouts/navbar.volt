<!-- Header Content -->
        <!-- Nav tabs -->
        <nav class="navbar">
            <div class="container">

                <div class="navbar-header">
                    <button class="navbar-toggler" data-toggle="open-navbar1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a href="#">
                        <h4 style="font-weight: bold;">Laundry Service<span> Organizer</span></h4>
                    </a>
                </div>

                <div class="navbar-menu" id="open-navbar1">
                    <ul class="navbar-nav">
                        {% if session.get('auth') and session.get('auth')['role'] == 1 %}
                        <li class=""><a href="{{ url() }}">Home</a></li>
                        {% elseif session.get('auth') and session.get('auth')['role'] == 0  %}
                        <li class=""><a href="{{ url('dashboard/user') }}">Home</a></li>
                        {% else %}
                        <li class=""><a href="{{ url('home') }}">Home</a></li>
                        {% endif %}
                        {% if session.get('auth') %}
                        {% if session.get('auth')['role'] == 1 %}
                        <li class="navbar-dropdown">
                            <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-0">
                                Pengelolaan <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown" id="my-dropdown-0">
                                <li><a href="{{ url('expense') }}">Pengeluaran</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('goods') }}">Barang</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('service') }}">Service Laundry</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('order') }}">Pesanan</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('pickup_delivery') }}">Jasa Antar Jemput</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('payment') }}">Pembayaran</a></li>
                            </ul>
                        </li>
                        {% else %}
                        <li><a href="{{ url('item') }}">Item</a></li>
                        <li class="navbar-dropdown">
                            <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-1">
                                Pesanan <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown" id="my-dropdown-1">
                                <li><a href="{{ url('order/users') }}">Tambah Pesanan</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('/listorder') }}">Daftar Pesanan</a></li>
                            </ul>
                        </li>
                        {% endif %}
                        {% endif %}

                        {% if session.get('auth') %}
                        {% set val = 'profile?id=' ~ session.get('auth')['id'] %}
                        <li class="navbar-dropdown">
                            <a href="#" class="dropdown-toggler" data-dropdown="my-dropdown-2">
                                {{ session.get('auth')['username'] }} <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown" id="my-dropdown-2">
                                <li><a href="{{ url(val) }}">Profil</a></li>
                                <li class="separator"></li>
                                <li><a href="{{ url('logout') }}">Logout</a></li>
                            </ul>
                        </li>
                        {% else %}
                            <li><a href="{{url('login')}}">Login</a></li>
                        {% endif %}
                    </ul>
                </div>
            </div>
        </nav>
<!-- END Header Content -->