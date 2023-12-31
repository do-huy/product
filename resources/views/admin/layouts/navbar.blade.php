<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm expand-header">
        <div class="header-left d-flex">
            <a href="{{ route('dashboard.index') }}" class="logo">
                SeneEcom
            </a>
            <a href="#" class="sidebarCollapse" id="toggleSidebar" data-placement="bottom">
                <span class="fas fa-bars"></span>
            </a>
        </div>
        <ul class="navbar-item flex-row ml-auto">

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="" class="nav-link user" id="Notify" data-bs-toggle="dropdown">
                    <span class="far fa-bell icon-header"></span>
                    <p class="count purple-gradient ">5</p>
                </a>
                <div class="dropdown-menu">
                    <div class="dp-main-menu">
                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/1.png') }}" alt="" class="user-note">
                            <div class="note-info-desmis">
                                <div class="user-notify-info">
                                    <p class="note-name">Server Rebooted</p>
                                    <p class="note-time">20 min ago</p>
                                </div>
                                <p class="status-link"><span class="fas fa-times"></span></p>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/2.png') }}" alt="" class="user-note">
                            <div class="note-info-desmis">
                                <div class="user-notify-info">
                                    <p class="note-name">Server Rebooted</p>
                                    <p class="note-time">20 min ago</p>
                                </div>
                                <p class="status-link"><span class="fas fa-times"></span></p>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/1.png') }}" alt="" class="user-note">
                            <div class="note-info-desmis">
                                <div class="user-notify-info">
                                    <p class="note-name">Server Rebooted</p>
                                    <p class="note-time">20 min ago</p>
                                </div>
                                <p class="status-link"><span class="fas fa-times"></span></p>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/2.png') }}" alt="" class="user-note">
                            <div class="note-info-desmis">
                                <div class="user-notify-info">
                                    <p class="note-name">Server Rebooted</p>
                                    <p class="note-time">20 min ago</p>
                                </div>
                                <p class="status-link"><span class="fas fa-times"></span></p>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/1.png') }}" alt="" class="user-note">
                            <div class="note-info-desmis">
                                <div class="user-notify-info">
                                    <p class="note-name">Server Rebooted</p>
                                    <p class="note-time">20 min ago</p>
                                </div>
                                <p class="status-link"><span class="fas fa-times"></span></p>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="" class="nav-link user" id="Notify" data-bs-toggle="dropdown">
                    <span class="fas fa-envelope-square icon-header"></span>
                    <p class="count bg-clc">5</p>
                </a>
                <div class="dropdown-menu">
                    <div class="dp-main-menu">

                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="sms-user">
                            <div class="user-message-info">
                                <p class="m-note-name">Helal Uddin</p>
                                <p class="user-role">Super Admin</p>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="sms-user">
                            <div class="user-message-info">
                                <p class="m-note-name">Helal Uddin</p>
                                <p class="user-role">Super Admin</p>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="sms-user">
                            <div class="user-message-info">
                                <p class="m-note-name">Helal Uddin</p>
                                <p class="user-role">Super Admin</p>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="sms-user">
                            <div class="user-message-info">
                                <p class="m-note-name">Helal Uddin</p>
                                <p class="user-role">Super Admin</p>
                            </div>
                        </a>

                        <a href="#" class="dropdown-item message-item">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="sms-user">
                            <div class="user-message-info">
                                <p class="m-note-name">Helal Uddin</p>
                                <p class="user-role">Super Admin</p>
                            </div>
                        </a>

                    </div>
                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="" class="nav-link user" id="Notify" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="icon-img">
                </a>
                <div class="dropdown-menu">

                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <img src="{{ asset('admin/images/notifi/avatar.jpg') }}" alt="" class="img-fluid mr-2">
                            <div class="media-body">
                                <h5>Helal Uddin</h5>
                                <p>Super admin</p>
                            </div>
                        </div>
                    </div>

                    <div class="dp-main-menu">
                        <a href="" class="dropdown-item"><span class="fas fa-user"></span>Profile</a>
                        <a href="" class="dropdown-item"><span class="fas fa-inbox"></span>Inbox</a>
                        <a href="" class="dropdown-item"><span class="fas fa-lock-open"></span>Look Screen</a>
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                <span class="fas fa-outdent"></span>
                                Đăng xuất
                            </a>
                        </form>
                    </div>

                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="" class="nav-link user" id="Notify" data-bs-toggle="dropdown">
                    <span class="fas fa-cog icon-header"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="dp-main-menu">
                        <a href="" class="dropdown-item"><span class="fas fa-plug"></span>Parmition</a>
                        <a href="" class="dropdown-item"><span class="fas fa-users"></span>Admins</a>
                        <a href="" class="dropdown-item"><span class="fas fa-object-ungroup"></span>Design Type</a>
                        <a href="" class="dropdown-item"><span class="fas fa-palette"></span>Color</a>
                    </div>
                </div>
            </li>


        </ul>
    </header>
</div>
