<div id="sidebar-menu">

    <ul class="metismenu" id="side-menu">

        <li class="menu-title">Menu</li>
        <li>
            <a class="@if(Request::is('beranda')) active @endif" href="{{route('dashboard')}}">
                <i class="fe-monitor"></i>
                <span> Beranda </span>
            </a>
        </li>
        <li>
            <a class="@if(Request::is('kategori')) active @endif" href="{{route('category')}}">
                <i class="fe-list"></i>
                <span> Kategori </span>
            </a>
        </li>
        <li>
            <a class="@if(Request::is('produk') || Request::is('produk/*')) active @endif" href="{{route('product')}}">
                <i class="fe-clipboard"></i>
                <span> Produk </span>
            </a>
        </li>
        <li>
            <a class="@if(Request::is('toping')) active @endif" href="{{route('toping')}}">
                <i class="fe-layers"></i>
                <span> Toping </span>
            </a>
        </li>
        <li>
            <a class="@if(Request::is('cabang')) active @endif" href="{{route('branch')}}">
                <i class="fe-home"></i>
                <span> Cabang </span>
            </a>
        </li>
        <li>
            <a class="@if(Request::is('laporan')) active @endif" href="{{route('order')}}">
                <i class="fe-book"></i>
                <span> Laporan </span>
            </a>
        </li>

    </ul>

</div>
