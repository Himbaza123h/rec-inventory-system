<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <img src="{{ asset('assets/images/users/avatar.png') }}" alt="" class="thumb-md img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile"><i class="md md-settings"></i> Password</a></li>
                        <li><a href="logout"><i class="md md-settings-power"></i> Logout</a></li>
                    </ul>
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
                    <li class="">
                        <a href="{{ route('home') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Dashboard</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.category.index') }}" class="waves-effect waves-light "><i
                                class="ion-document"></i><span>Categories</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect waves-light"><i class="ion-bag"></i><span>Items</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="users" class="waves-effect waves-light"><i
                                        class="ion-android-contact"></i>Glasses</a></li>
                            <li><a href="supplier" class="waves-effect waves-light"><i
                                        class="ion-android-social"></i>Lens</a></li>

                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.purchase.index') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-pulse-strong"></i><span>Purchase</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.stock.index') }}" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Stock</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="" class="waves-effect waves-light"><i
                                class="ion-ios7-albums"></i><span>Invoices</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="invoices" class="waves-effect waves-light"><i
                                        class="ion-document"></i>Invoices</a>
                            </li>
                            <li><a href="pinv" class="waves-effect waves-light"><i class="ion-clipboard"></i>Proforma
                                    Invoice</a></li>
                            <li><a href="requestInvoices" class="waves-effect waves-light"><i
                                        class="ion-document-text"></i>Requested Invoices</a></li>
                        </ul>
                        </a>
                    </li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect waves-light"><i
                                class="ion-android-contacts"></i><span>People</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="users" class="waves-effect waves-light"><i
                                        class="ion-android-contact"></i>Users</a></li>
                            <li><a href="supplier" class="waves-effect waves-light"><i
                                        class="ion-android-social"></i>Suppliers</a></li>
                            <li><a href="customers" class="waves-effect waves-light"><i
                                        class="ion-android-social-user"></i>Customers</a></li>

                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="{{ route('admin.reports.index') }}" class="waves-effect waves-light"><i
                                class="ion-ios7-pulse-strong"></i><span>Reports</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="reports">General</a></li>
                            <li><a href="rqreport">Requested Item</a></li>
                            <li><a href="fmcg">Faster | Slow Items</a></li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul>
                    <li class="">
                        <a href="index" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Dashboard</span></a>
                    </li>
                    <!-- <li class="">
                                <a href="list" class="waves-effect waves-light "><i class="ion-bag"></i><span>Items</span></a>
                            </li> -->
                    <li class="">
                        <a href="sell" class="waves-effect waves-light "><i
                                class="ion-bag"></i><span>Sell</span></a>
                    </li>
                    <li class="">
                        <a href="stok" class="waves-effect waves-light "><i
                                class="ion-ios7-gear"></i><span>Stock</span></a>
                    </li>
                    <li>
                        <a href="sellinvoices" class="waves-effect waves-light"><i
                                class="ion-document"></i><span>Invoices</span></a>
                    </li>
                    <li>
                        <a href="sellpinv" class="waves-effect waves-light"><i
                                class="ion-clipboard"></i><span>Proforma
                                Invoice</span></a>
                    </li>
                    <li><a href="requestInvoices" class="waves-effect waves-light"><i
                                class="ion-document-text"></i>Requested Invoices</a></li>
                    <li class="has_sub">
                        <a href="#" class="waves-effect waves-light"><i
                                class="ion-ios7-pulse-strong"></i><span>Reports</span>
                            <span class="pull-right"><i class="md md-add"></i></span>
                        </a>
                        <ul class="list-unstyled">
                            <li><a href="sellreport">My Report</a></li>
                            <li><a href="rqreport">Requested Item</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
