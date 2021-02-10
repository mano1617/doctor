<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                <!-- @lang('menus.backend.sidebar.general') -->
                Menus
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                <!-- <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li> -->

                <!-- <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="divider"></li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/log-viewer*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/log-viewer*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer'))
                        }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer/logs*'))
                        }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-title">
                    Applications
                </li> -->

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/physician/clinics'))
                    }}" href="{{ route('admin.physician.clinics.index') }}">
                        <i class="nav-icon fas fa-hospital-o"></i>
                            Clinics
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/hospitals'))
                    }}" href="{{ route('admin.hospitals.index') }}">
                        <i class="nav-icon fas fa-h-square"></i>
                            Hospitals
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/homeopathic-pharmacy'))
                    }}" href="{{ route('admin.homeopathic-pharmacy.index') }}">
                        <i class="nav-icon fas fa-h-square"></i>
                            Homoeopathic Pharmacy
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/homeopathic-associate'))
                    }}" href="{{ route('admin.homeopathic-associate.index') }}">
                        <i class="nav-icon fas fa-h-square"></i>
                            Homoeopathic Association
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/diagnostic-center'))
                    }}" href="{{ route('admin.diagnostic-center.index') }}">
                        <i class="nav-icon fas fa-h-square"></i>
                            Diagnostic Center
                    </a>
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/physicians*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/physicians*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-users"></i>Users
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/physicians'))
                        }}" href="{{ route('admin.physician.index') }}">
                                Physicians
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/physicians'))
                        }}" href="{{ route('admin.medical-student.index') }}">
                                Medical Student
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/master*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/master*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-cogs"></i>Master Pages
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/master/professional_qualifications'))
                        }}" href="{{ route('admin.mstr.pro_qualify.index') }}">
                                Professional Qualification
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/master/branch_medicines'))
                        }}" href="{{ route('admin.mstr.branch_medicine.index') }}">
                                Branch Of Medicine
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/master/designations'))
                        }}" href="{{ route('admin.mstr.designation.index') }}">
                                Designations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/master/memberships'))
                        }}" href="{{ route('admin.mstr.membership.index') }}">
                                Memberships
                            </a>
                        </li>
                    </ul>
                </li>

            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
