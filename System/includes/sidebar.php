<?php include_once "path.php"; ?>

<div id="sidebar" class="sidebar responsive ace-save-state">

    <ul class="nav nav-list">
        <li class="" id="menuTableUser">
            <a href="../dashboard">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            <b class="arrow"></b>
        </li>

        <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role_name'], ['SUPER ADMIN', 'ADMIN'])): ?>
            <li>
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text">
                        User Management
                    </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu nav-hide" style="display: none;">
                    <li class="">
                        <a href="../roles">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Roles
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="../users">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Users
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="" id="menuTableUser">
            <a href="../departments">
                <i class="menu-icon fa fa-briefcase"></i>
                <span class="menu-text"> Departments</span>
            </a>
            <b class="arrow"></b>
        </li>
        <li class="" id="menuTableUser">
            <a href="../employees">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Employees</span>
            </a>
            <b class="arrow"></b>
        </li>
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
            data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>