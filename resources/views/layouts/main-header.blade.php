        <!--=================================
 header start-->
        <nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <!-- logo -->
            <div class="text-left navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('assets/images/photo.png') }}"
                        width="100px" height="140px" alt=""></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-icon-dark.png"
                        alt=""></a>
            </div>
            <!-- Top bar left -->
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item">
                    <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                        href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
                </li>
                <li class="nav-item">
                    <div class="search">
                        <a class="search-btn not_click" href="javascript:void(0);"></a>
                        <div class="search-box not-click">
                            <input type="text" class="not-click form-control" placeholder="Search" value=""
                                name="search">
                            <button class="search-button" type="submit"> <i
                                    class="fa fa-search not-click"></i></button>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- top bar right -->
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item fullscreen">
                    <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti-bell"></i>
                        <span class="badge badge-danger notification-status"> </span>
                    </a>
                    <!-- notifications -->
                    <div class="dropdown-menu dropdown-menu-right dropdown-big dropdown-notifications">
                        <div class="dropdown-header notifications" style="background-color: blue">
                            <strong style="color: rgb(224, 224, 255)">إشعارات طلبات الرفع</strong>
                            <span data-count="{{ App\Models\Notification::countNotification()->count() }}"
                                class="badge badge-pill badge-warning notif-count">{{ App\Models\Notification::countNotification()->count() }}</span>
                        </div>
                        <div class="new_message">
                            <div class="dropdown-divider"></div>

                            <h5 class="dropdown-item">
                                <small class="float-right text-muted time">

                                </small>
                            </h5>
                        </div>
                        @foreach (App\Models\Notification::where('reader_status', 0)->get() as $notification)
                            <div class="dropdown-divider"></div>

                            <p class="dropdown-item"> الاستاذ: {{ $notification->teacherName }}
                                <small class="float-right text-muted time">
                                    {{ $notification->title }}
                                </small>
                            </p>
                        @endforeach

                        {{-- <a href="#" class="dropdown-item">New registered user <small
                                class="float-right text-muted time">Just now</small> </a>
                                --}}
                    </div>
                </li>
                {{--   <li class="nav-item dropdown ">
                    <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="true"> <i class=" ti-view-grid"></i> </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-big">
                        <div class="dropdown-header">
                            <strong>Quick Links</strong>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="nav-grid">
                            <a href="#" class="nav-grid-item"><i class="ti-files text-primary"></i>
                                <h5>New Task</h5>
                            </a>
                            <a href="#" class="nav-grid-item"><i class="ti-check-box text-success"></i>
                                <h5>Assign Task</h5>
                            </a>
                        </div>
                        <div class="nav-grid">
                            <a href="#" class="nav-grid-item"><i class="ti-pencil-alt text-warning"></i>
                                <h5>Add Orders</h5>
                            </a>
                            <a href="#" class="nav-grid-item"><i class="ti-truck text-danger "></i>
                                <h5>New Orders</h5>
                            </a>
                        </div>
                    </div>
                </li> --}}
                <li class="nav-item dropdown mr-30">
                    <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="assets/images/profile-avatar.jpg" alt="avatar">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        {{-- <a class="dropdown-item" href="#"><i class="text-secondary ti-reload"></i>Activity</a>
                        <a class="dropdown-item" href="#"><i class="text-success ti-email"></i>Messages</a>
                        <a class="dropdown-item" href="#"><i class="text-warning ti-user"></i>Profile</a>
                        <a class="dropdown-item" href="#"><i class="text-dark ti-layers-alt"></i>Projects <span
                                class="badge badge-info">6</span> </a> --}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="text-info ti-settings"></i>Settings</a>
                        <form action="{{ route('logout') }}" method="POST" id="logout">
                            @csrf
                            @method('POST')
                            <button type="submit" class="dropdown-item" form="logout"><i
                                    class="text-danger ti-unlock"></i>Logout</button>
                        </form>

                    </div>

                </li>
            </ul>

        </nav>

        <!--=================================
 header End-->
        <script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            var notificationsWrapper = $('.dropdown-notifications');
            var notificationsCountElem = notificationsWrapper.find('span[data-count]');
            var notificationsCount = parseInt(notificationsCountElem.data('count'));
            var notifications = notificationsWrapper.find('h5');
            var newnotifications = notificationsWrapper.find('.new_message');
            newnotifications.hide();
            // if (notificationsCount <= 0) {
            //  notificationsWrapper.hide();
            // }
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('efc0e64daa7cd030e730', {
                cluster: 'mt1'
            });

            var channel = pusher.subscribe('file-upload');

            channel.bind('App\\Events\\FileUpload', function(data) {
             //   var existingNotifications = notifications.html();
                var newNotificationHtml = ` <h5 class="dropdown-item"> الاستاذ: ` + data.teacherName + `<small
                                class="float-right text-muted time">` + data.title + `</small></h5>`
                // var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
                //  var newNotificationHtml = `<a href="#" class="dropdown-item">`+data.teacherName+ `<small
        //                      class="float-right text-muted time">`+data.teacherName+ `</small> </a> `;
        newnotifications.show();
        notifications.html(newNotificationHtml);
                  
                notificationsCount += 1;
                notificationsCountElem.attr('data-count', notificationsCount);
                notificationsWrapper.find('.notif-count').text(notificationsCount);
                notificationsWrapper.show();
            });
        </script>
