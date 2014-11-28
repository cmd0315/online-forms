<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::route('dashboard') }}">{{ HTML::image("img/bcd-logo.png", "BCD Pinpoint Logo") }}</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Messages <b class="caret"></b></a>
            <ul class="dropdown-menu message-dropdown">
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-footer">
                    <a href="#">Read All New Messages</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Alerts <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li>
                    <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">View All</a>
                </li>
            </ul>
        </li>
        @if($currentUser)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $currentUser->username}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ URL::route('profile.show', ['username' => $currentUser->username]) }}"> Profile</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('accounts.edit', $currentUser->username) }}"> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ URL::route('sessions.signout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="{{ URL::route('dashboard') }}" class="text-center">
                    <i class="fa fa-tachometer fa-lg"></i>
                    <h4>Dashboard</h4>
                </a>
            </li>
            @if($currentUser->system_admin)
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#employees-menu" class="text-center">
                        <i class="fa fa-user fa-lg"></i>
                        <h4>Employees</h4>
                    </a>
                    <ul id="employees-menu" class="collapse">
                        <li>
                            <a href="{{ URL::route('employees.create') }}">Add Employee</a>
                        </li>
                        <li>
                            <a href="{{ URL::route('employees.index') }}">Manage Employee Records</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#departments-menu" class="text-center">
                        <i class="fa fa-building fa-lg"></i>
                        <h4>Departments</h4>
                    </a>
                    <ul id="departments-menu" class="collapse">
                        <li>
                            <a href="{{ URL::route('departments.create') }}">Add Department</a>
                        </li>
                        <li>
                            <a href="{{ URL::route('departments.index') }}">Manage Department Records</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#clients-menu" class="text-center">
                        <i class="fa fa-suitcase fa-lg"></i>
                        <h4>Clients</h4>
                    </a>
                    <ul id="clients-menu" class="collapse">
                        <li>
                            <a href="{{ URL::route('clients.create') }}">Add Client</a>
                        </li>
                        <li>
                            <a href="{{ URL::route('clients.index') }}">Manage Client Records</a>
                        </li>
                    </ul>
                </li>
            @endif
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#forms-menu" class="text-center">
                    <i class="fa fa-file-text fa-lg"></i>
                    <h4>Forms</h4>
                </a>
                <ul id="forms-menu" class="collapse">
                    <li>
                        <a href="{{ URL::route('forms.index') }}">List of Forms</a>
                    </li>
                    @if($currentUser->system_admin)
                        <li>
                            <a href="{{ URL::route('rejectreasons.index') }}">Reject Reasons</a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
