<?php ?>
<div class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="/admin/user/list">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/user/list">
                    <i class="fa fa-table fa-fw"></i> User 
                    <span class="fa arrow"></span></a>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/user/list">List</a>
                    </li>
                    <li>
                        <a href="/admin/user/create">Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin/user/blog"><i class="fa fa-edit fa-fw"></i> Blog</a>
            </li>
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</div>