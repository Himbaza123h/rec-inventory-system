<style>
    /* Sidebar */
    .left {
        float: left;
        width: 250px;
        background: #f8f8f8;
        height: 100%;
    }

    /* Sidebar Inner */
    .sidebar-inner {
        padding: 15px;
    }

    /* User Details */
    .user-details {
        margin-bottom: 20px;
    }

    /* Sidebar Menu */
    #sidebar-menu ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    #sidebar-menu ul li {
        position: relative;
        margin-bottom: 10px;
    }

    #sidebar-menu ul li a {
        display: block;
        padding: 10px;
        /* color: #fff; */
        text-decoration: none;
    }


    /* Sidebar Menu */
    #sidebar-menu ul li ul {
        display: none;
        list-style: none;
        padding-left: 0;
        width: 200px;
        z-index: 1000;
    }



    #sidebar-menu ul li:hover ul {
        display: block;
        position: absolute;
        top: 0;
        left: 100%;
        background: #fff;
        border: 1px solid #ccc;
        z-index: 1000;
    }

    #sidebar-menu ul li ul li a {
        padding: 10px;
        display: block;
        color: #333;
    }

    #sidebar-menu ul li ul li a:hover {
        background: #333;
    }


    #sidebar-menu ul li ul li a {
        padding: 10px;
    }

    /* Active Menu */
    #sidebar-menu ul li.active>a {
        color: #fff;
        background: #337ab7;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <img src="{{ asset('assets/images/users/avatar.png') }}" alt="" class="thumb-md img-circle">
            </div>
            <div class="user-info">
                <div class="">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                </div>
                <p class="text-muted m-0">
                    @if (Auth::user()->role == 'admin')
                        Admin
                    @else
                        Seller
                    @endif
                </p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            @if (Auth::user()->role == 'admin')
                <ul>
                    <li
                        class="has_sub {{ request()->routeIs('home') || request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Dashboard</span></a>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('admin.category.index') || request()->routeIs('admin.category.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.category.index') }}" class="waves-effect waves-light "><i
                                class="ion-document"></i><span>Categories</span></a>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('admin.items.index') || request()->routeIs('admin.items.lens.index') || request()->routeIs('admin.item.lens.edit') || request()->routeIs('admin.colors.index') || request()->routeIs('admin.item.edit') ? 'active' : '' }}">
                        <a href="#" class="waves-effect waves-light"><i class="ion-bag"></i><span>Items</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyle">
                            <li><a href="{{ route('admin.items.index') }}" class="waves-effect waves-light"><i
                                        class="ion-bag"></i>Frames</a></li>

                            <li><a href="{{ route('admin.items.sunglasses.index') }}"
                                    class="waves-effect waves-light"><i class="ion-bag"></i>Sun Glasses</a></li>
                            <li><a href="{{ route('admin.items.readingglasses.index') }}"
                                    class="waves-effect waves-light"><i class="ion-bag"></i>Reading Glasses</a></li>


                            <li><a href="{{ route('admin.items.lens.index') }}" class="waves-effect waves-light"><i
                                        class="ion-bag"></i>Lens</a></li>

                            <li><a href="{{ route('admin.colors.index') }}" class="waves-effect waves-light"><i
                                        class="ion-bag"></i>Manage Colors</a></li>

                        </ul>
                    </li>



                    <li
                        class="has_sub {{ request()->routeIs('admin.purchase.index') || request()->routeIs('admin.single.order.list') || request()->routeIs('admin.pending.order.details') || request()->routeIs('admin.confirm.orders') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchase.index') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-pulse-strong"></i><span>Manage Orders</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyle">
                            <li><a href="{{ route('admin.purchase.index') }}" class="waves-effect waves-light"><i
                                        class="ion-ios7-pulse-strong"></i>Request Orders</a></li>
                            <li><a href="{{ route('admin.confirm.orders') }}" class="waves-effect waves-light"><i
                                        class="ion-ios7-pulse-strong"></i>Modify Orders</a></li>
                        </ul>
                    </li>




                    <li class="has_sub {{ request()->routeIs('admin.stock.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.stock.index') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Stock</span></a>
                    </li>

                    <li
                        class="has_sub {{ request()->routeIs('admin.invoice.index') || request()->routeIs('admin.invoice-by-sell-code.index') || request()->routeIs('admin.invoice.pro.index') || request()->routeIs('admin.invoice.req.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.invoice.index') }}" class="waves-effect waves-light">
                            <i class="ion-ios7-albums"></i>
                            <span>Invoices</span>
                        </a>
                    </li>



                    <ul class="list-unstyle">
                        <li>
                            <a href="{{ route('admin.invoice.index') }}" class="waves-effect waves-light"><i
                                    class="ion-document"></i>Frame</a>
                        </li>
                        <li><a href="" class="waves-effect waves-light"><i class="ion-clipboard"></i>Lens
                            </a></li>
                    </ul>
                    </a>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('admin.suppliers.index') || request()->routeIs('admin.sellers.index') || request()->routeIs('admin.customers.index') || request()->routeIs('admin.users.index') || request()->routeIs('admin.user.edit') || request()->routeIs('admin.supplier.edit') || request()->routeIs('admin.customer.edit') ? 'active' : '' }}">
                        <a href="#" class="waves-effect waves-light"><i
                                class="ion-android-contacts"></i><span>People</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyle">
                            <li><a href="{{ route('admin.users.index') }}" class="waves-effect waves-light"><i
                                        class="ion-android-contact"></i>Users</a></li>
                            <li><a href="{{ route('admin.sellers.index') }}" class="waves-effect waves-light"><i
                                        class="ion-android-social"></i>Sellers</a></li>
                            <li {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}><a
                                    href="{{ route('admin.suppliers.index') }}" class="waves-effect waves-light"><i
                                        class="ion-android-social"></i>Suppliers</a></li>
                            <li><a href="{{ route('admin.customers.index') }}" class="waves-effect waves-light"><i
                                        class="ion-android-social-user"></i>Customers</a></li>

                        </ul>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('admin.reports.index') || request()->routeIs('admin.stats.financial') || request()->routeIs('admin.reports.lens.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports.index') }}" class="waves-effect waves-light"><i
                                class="ion-ios7-pulse-strong"></i><span>Reports</span>
                        </a>
                    </li>
                </ul>
            @else
                <ul>
                    <li
                        class="has_sub {{ request()->routeIs('home') || request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Dashboard</span></a>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('seller.make.sales.index') || request()->routeIs('seller.checkout') || request()->routeIs('seller.lens.checkout') || request()->routeIs('seller.lens.sales.index') || request()->routeIs('seller.checkout.update') ? 'active' : '' }}">
                        <a href="{{ route('seller.make.sales.index') }}" class="waves-effect waves-light"><i
                                class="ion-bag"></i><span>Make Sales</span>
                            <span class="pull-right"></span></a>
                    </li>
                    {{-- <ul class="list-unstyle">
                            <li>
                                <a href="{{ route('seller.sales.index') }}" class="waves-effect waves-light">
                                    <i class="ion-ios7-pulse-strong"></i> Frame Sales
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('seller.lens.sales.index') }}" class="waves-effect waves-light">
                                    <i class="ion-ios7-pulse-strong"></i> Lens Sales
                                </a>
                            </li>
                        </ul>
                    </li> --}}





                    <li class="has_sub {{ request()->routeIs('seller.stock.index') ? 'active' : '' }}">
                        <a href="{{ route('seller.stock.index') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Manage Stock</span></a>
                    </li>
                    <li
                        class="has_sub {{ request()->routeIs('seller.invoice.index') || request()->routeIs('seller.invoice-by-sell-code.index') ? 'active' : '' }}">
                        <a href="{{ route('seller.invoice.index') }}" class="waves-effect waves-light"><i
                                class="ion-document"></i><span>Invoices</span></a>
                    </li>

                    {{-- <li
                        class="has_sub {{ request()->routeIs('seller.glass.performa.invoice') || request()->routeIs('seller.lens.performa.invoice') ? 'active' : '' }}">
                        <a href="{{ route('seller.reports.index') }}" class="waves-effect waves-light"><i
                                class="ion-ios7-pulse-strong"></i><span>Proforma</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyle">
                            <li>
                                <a href="{{ route('seller.glass.performa.invoice') }}"
                                    class="waves-effect waves-light">
                                    <i class="ion-ios7-pulse-strong"></i> Frame
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('seller.lens.performa.invoice') }}"
                                    class="waves-effect waves-light">
                                    <i class="ion-ios7-pulse-strong"></i> Lens
                                </a>
                            </li>
                        </ul>
                    </li> --}}


                    <li
                        class="has_sub {{ request()->routeIs('seller.customers.index') || request()->routeIs('seller.customer.edit') ? 'active' : '' }}">
                        <a href="{{ route('seller.customers.index') }}" class="waves-effect waves-light"><i
                                class="ion-android-social-user"></i>Customers</a>
                    </li>

                    <li
                        class="has_sub {{ request()->routeIs('seller.reports.index') || request()->routeIs('seller.stats.financial') || request()->routeIs('seller.reports.lens.index') ? 'active' : '' }}">
                        <a href="{{ route('seller.reports.index') }}" class="waves-effect waves-light"><i
                                class="ion-ios7-pulse-strong"></i><span>Reports</span>
                        </a>
                    </li>

                </ul>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>
