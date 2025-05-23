<div id="navbar" class="navbar navbar-default ace-save-state" style="background-color:#00008b">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <?php echo $systemTitle; ?>
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background-color:#00008b">
                        <span class="user-info">
                            <small>Welcome,</small>
                            <span id="displayUserFullName">
                                <?php echo $_SESSION['username'] ?>
                            </span>
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul
                        class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#" id="logoutBtn">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="../auth/ajax/logoutUser.js<?php echo randomNum() ?>"></script>