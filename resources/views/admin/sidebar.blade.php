<div class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="/admin"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
            </li>
            @if (auth()->user()->role === $roleAdmin)
            <li>
                <a href="">
                    <i class="fa fa-table fa-fw"></i>User 
                    <span class="fa arrow"></span></a>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/user/list">List</a>
                    </li>
                    <li>
                        <a id="link-create-user" href="/admin/user/create">Create</a>
                    </li>
                </ul>
            </li>
            @endif
            <li>
                <a href="#"><i class="fa fa-edit fa-fw"></i>Blog</a>
            </li>
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</div>
