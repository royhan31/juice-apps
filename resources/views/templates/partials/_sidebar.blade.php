<div id="sidebar-menu">

    <ul class="metismenu" id="side-menu">

        <li class="menu-title">Menu</li>

        <li class="@if(Request::is('beranda')) active @endif">
            <a href="{{route('dashboard')}}">
                <i class="fe-monitor"></i>
                <span> Beranda </span>
            </a>
        </li>
        <li class="@if(Request::is('kategori')) active @endif">
            <a href="{{route('category')}}">
                <i class="fe-list"></i>
                <span> Kategori </span>
            </a>
        </li>
        <li class="@if(Request::is('produk')) active @endif">
            <a href="{{route('product')}}">
                <i class="fe-clipboard"></i>
                <span> Produk </span>
            </a>
        </li>
        <li class="active">
            <a href="">
                <i class="fe-layers"></i>
                <span> Toping </span>
            </a>
        </li>
        <li class="active">
            <a href="">
                <i class="fe-home"></i>
                <span> Cabang </span>
            </a>
        </li>

    </ul>

</div>
