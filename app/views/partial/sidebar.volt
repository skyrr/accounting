<div class="page-sidebar mini" id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper" id="main-menu-wrapper">
        <div class="user-info-wrapper">
            <div class="profile-wrapper"> <img src="/assets/img/profiles/avatar.jpg"  alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" width="69" height="69" /> </div>
            <div class="user-info">
                <div class="greeting">Welcome</div>
                <div class="username"> {{ user.getName()|capitalize }} </div>
                <div class="status">Status<a href="#">
                        <div class="status-icon green"></div>
                        Online</a></div>
            </div>
        </div>
        <!-- END MINI-PROFILE -->
        <!-- BEGIN SIDEBAR MENU -->
        <ul>
            <li class=""> <a href="{{ url.get() }}"> <i class="fa fa-home"></i> <span class="title">Головна</span> </a> </li>
            <li class=""> <a href="{{ url.get('/transactions') }}"> <i class="fa fa-usd"></i> <span class="title">Операції</span> </a> </li>
        </ul>
        <div class="clearfix"></div>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<a href="#" class="scrollup to-edge">Scroll</a>
<div class="footer-widget" style="display:none">
    <div class="pull-right">
        <a href="{{ url.get('user/logout') }}"><i class="fa fa-power-off"></i></a>
    </div>
</div>