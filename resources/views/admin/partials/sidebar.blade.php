<div class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>NovaCart</span>
    </div>

    <!-- Menu -->
    <div class="menu">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <!-- Website Home -->
        <a href="{{ route('home') }}" class="menu-item">
            <i class="fa-solid fa-globe"></i>
            <span>Website Home</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}"
           class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fa-solid fa-box"></i>
            <span>Products</span>
        </a>

        <!-- Categories -->
        <!-- Categories -->
<a href="{{ route('admin.categories.index') }}"
   class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
    <i class="fa-solid fa-layer-group"></i>
    <span>Categories</span>
</a>

       <!-- Orders -->
<a href="{{ route('admin.orders.index') }}"
   class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    <i class="fa-solid fa-cart-shopping"></i>
    <span>Orders</span>
</a>

        <!-- Customers -->
        <!-- Customers -->
<a href="{{ route('admin.customers.index') }}"
   class="menu-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
    <i class="fa-solid fa-users"></i>
    <span>Customers</span>
</a>

    </div>

    <!-- Logout -->
    <div class="logout-area">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>

        </form>

    </div>

</div>

<style>

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#0f172a,#1f2937);
    display:flex;
    flex-direction:column;
    color:white;
    box-shadow:8px 0 25px rgba(0,0,0,.3);
}

.logo{
    height:80px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:26px;
    font-weight:700;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.logo i{
    color:#6366f1;
    font-size:28px;
}

.menu{
    padding:20px 15px;
    flex:1;
}

.menu-item{
    display:flex;
    align-items:center;
    gap:15px;
    padding:13px 16px;
    margin-bottom:10px;
    border-radius:12px;
    text-decoration:none;
    color:#d1d5db;
    transition:all .3s ease;
    font-weight:500;
}

.menu-item i{
    width:22px;
    text-align:center;
}

.menu-item:hover{
    background:#4f46e5;
    color:white;
    transform:translateX(6px);
    box-shadow:0 6px 18px rgba(79,70,229,.35);
}

.menu-item.active{
    background:#6366f1;
    color:white;
    box-shadow:0 8px 20px rgba(99,102,241,.35);
}

.logout-area{
    padding:20px;
    border-top:1px solid rgba(255,255,255,.08);
}

.logout-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#dc2626;
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:all .3s ease;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
}

.logout-btn:hover{
    background:#b91c1c;
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(220,38,38,.35);
}

</style>