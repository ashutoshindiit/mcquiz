<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{ route('user.dashboard') }}" class="site_title"><i class="fa fa-home"></i> <span>{{ env('APP_NAME')}}</span></a>
    </div>
    <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
            <img src="{{ asset('images/avatar.png') }}" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{ ucwords(Auth::user()->first_name) }}</h2>
            <small>({{ ucwords(Auth::user()->roles->pluck('name')[0]) }})</small> 
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->
    <br />
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                
                <li><a href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
                
                <li><a href="{{ route('user.quiz') }}"><i class="fa fa-edit"></i> Quiz </a></li>
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->
    
</div>