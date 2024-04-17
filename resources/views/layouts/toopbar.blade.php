<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <!-- <img src="assets/images/electric.jpg" style="height: 40px;border-radius: 90px;"> -->
            <a href="index" class="logo"><span style="font-family:Century Gothic;"><strong>Rwanda Eye Clinic
                    </strong></span></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="bar">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <form class="navbar-form pull-left" role="search">
                </form>
                <div class="pull-right" style="margin-right: 25px; margin-top: 20px;">

                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        <i class="fa fa-sign-out"></i>
                        <span>Sign Out</span>
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>

            </div>




        </div>
    </div>
</div>
