<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">

                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title"> اهلا بك يا </li>
                    <!-- menu item Elements-->
                {{--
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements">
                            <div class="pull-left"><i class="ti-palette"></i><span
                                    class="right-nav-text">Elements</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements" class="collapse" data-parent="#sidebarnav">
                            <li><a href="accordions.html">Accordions</a></li>
                            <li><a href="alerts.html">Alerts</a></li>
                            <li><a href="button.html">Button</a></li>
                            <li><a href="colorpicker.html">Colorpicker</a></li>
                            <li><a href="dropdown.html">Dropdown</a></li>
                            <li><a href="lists.html">lists</a></li>
                            <li><a href="modal.html">modal</a></li>
                            <li><a href="nav.html">nav</a></li>
                            <li><a href="nicescroll.html">nicescroll</a></li>
                            <li><a href="pricing-table.html">pricing table</a></li>
                            <li><a href="ratings.html">ratings</a></li>
                            <li><a href="date-picker.html">date picker</a></li>
                            <li><a href="tabs.html">tabs</a></li>
                            <li><a href="typography.html">typography</a></li>
                            <li><a href="popover-tooltips.html">Popover tooltips</a></li>
                            <li><a href="progress.html">progress</a></li>
                            <li><a href="switch.html">switch</a></li>
                            <li><a href="sweetalert2.html">sweetalert2</a></li>
                            <li><a href="touchspin.html">touchspin</a></li>
                        </ul>
                    </li>
                --}}
                    <!-- menu item calendar-->
                {{--
                      <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#calendar-menu">
                            <div class="pull-left"><i class="ti-calendar"></i><span
                                    class="right-nav-text">calendar</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="calendar-menu" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="calendar.html">Events Calendar </a> </li>
                            <li> <a href="calendar-list.html">List Calendar</a> </li>
                        </ul>
                    </li>
                --}}


                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#chart">
                            <div class="pull-left"><i class="ti-menu-alt"></i><span
                                    class="right-nav-text">الاقسام</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="chart" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.departments.index')}}"> الاقسام </a> </li>


                        </ul>
                    </li>

                    <!-- menu font icon-->

                   <!-- classrooms management -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#font-icon">
                            <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">
                                    الصفوف الدراسية </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="font-icon" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة الصفوف الدراسية </a> </li>

                        </ul>
                    </li>

                      <!-- Subjects management -->
                      <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#subjects">
                            <div class="pull-left"><i class="fa fa-book"></i><span class="right-nav-text">
                                     إدارة المواد الدراسية </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="subjects" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.subjects.index')}}">قائمة المواد الدراسية</a> </li>

                        </ul>
                    </li>
                     <!-- teachers management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#teacher">
                            <div class="pull-left"><i >
                                <svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-2.81 -2.81 33.67 33.67" xml:space="preserve" fill="#000000" stroke="#000000" transform="rotate(0)" stroke-width="0.7294039999999999"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#f2f2f2;" d="M27.961,1.867v11.204c0,0.319-0.258,0.578-0.578,0.578H12.144c-0.319,0-0.578-0.259-0.578-0.578 v-0.885l1.156-0.775v1.082h14.082V2.444H12.721v4.229c-0.051,0.039-0.106,0.073-0.154,0.117l-0.162,0.112 c-0.195-0.51-0.492-0.912-0.839-1.242V1.867c0-0.319,0.26-0.578,0.578-0.578h15.239C27.703,1.289,27.961,1.547,27.961,1.867z M14.316,9.461l0.692-0.464h-0.001c0.001-0.004,0.003-0.004,0.005-0.007c0.352-0.349,0.406-0.868,0.188-1.277l5.599-3.799 l-0.254-0.375l-5.646,3.83c-0.177-0.128-0.375-0.209-0.583-0.216c-0.296-0.01-0.597,0.09-0.823,0.317c0,0-0.005,0.006-0.007,0.006 l-0.138,0.096l-1.254,0.856V8.064c-0.233-2.769-3.442-2.728-3.442-2.728h-1.39L6.094,7.258L4.92,5.337H3.587 c-3.621,0.068-3.493,2.727-3.493,2.727v6.206h0.002c0.001,0.016-0.002,0.035-0.002,0.048c0,0.591,0.477,1.066,1.066,1.066 c0.587,0,1.064-0.477,1.064-1.066c0-0.013,0-0.032-0.002-0.048h0.002V8.53H2.89L2.882,26.613c0,0.795,0.646,1.441,1.438,1.441 c0.795,0,1.439-0.646,1.439-1.441v-11.67H6.4v11.683l0.012,0.013c0.01,0.781,0.646,1.415,1.432,1.415 c0.789,0,1.431-0.643,1.431-1.432L9.271,8.5h0.693v1.888c0,0.002,0,0.007,0,0.009c0,0.587,0.477,1.065,1.063,1.065 c0.173,0,0.328-0.049,0.475-0.125l0.005,0.007l1.84-1.234L14.316,9.461z M6.073,4.874c1.346,0,2.437-1.091,2.437-2.437 S7.419,0,6.073,0S3.636,1.092,3.636,2.437S4.727,4.874,6.073,4.874z"></path> </g> </g></svg>
                                </i><span
                                    class="right-nav-text">إدارة المعلمين</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="teacher" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.teachers.index')}}"> قائمة المعلمين </a> </li>


                        </ul>
                    </li>

                     <!-- students  management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#students">
                            <div class="pull-left"><i class="fa fa-group"></i><span class="right-nav-text">
                                    إدارة الطلاب </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="students" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.students.index')}}">قائمة الطلاب </a> </li>
                            <li> <a href="{{route('dashboard.students.create')}}"> اضافة طالب </a> </li>

                        </ul>
                    </li>



                     <!-- parents management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#parents">
                            <div class="pull-left"><i ><svg height="16px" width="16px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M165.865,85.55c23.636,0,42.779-19.159,42.779-42.77C208.644,19.142,189.501,0,165.865,0 c-23.636,0-42.779,19.142-42.779,42.779C123.086,66.391,142.229,85.55,165.865,85.55z"></path> <path class="st0" d="M222.061,97.624H109.669c-20.726,0-43.274,22.548-43.274,43.282v143.768c0,10.363,8.396,18.767,18.758,18.767 c10.363,0,18.775-8.404,18.775-18.767V166.469h8.651v320.88c0,13.616,11.035,24.651,24.644,24.651 c13.625,0,24.66-11.035,24.66-24.651V301.138h7.964v186.211c0,13.616,11.035,24.651,24.66,24.651 c13.609,0,24.644-11.035,24.644-24.651v-320.88h8.668v118.204c0,10.363,8.396,18.767,18.758,18.767 c10.379,0,18.759-8.404,18.759-18.767V140.906C265.335,120.172,242.787,97.624,222.061,97.624z"></path> <path class="st0" d="M373.041,256.72c19.206,0,34.758-15.568,34.758-34.751c0-19.206-15.552-34.759-34.758-34.759 c-19.206,0-34.758,15.552-34.758,34.759C338.283,241.152,353.835,256.72,373.041,256.72z"></path> <path class="st0" d="M412.989,278.117h-84.718c-15.616,0-32.616,16.992-32.616,32.624v75.482c0,7.812,6.333,14.145,14.137,14.145 c7.812,0,14.153-6.333,14.153-14.145v-56.212h6.525v163.407c0,10.267,8.316,18.582,18.566,18.582 c10.275,0,18.592-8.316,18.592-18.582v-94.785h6.005v94.785c0,10.267,8.316,18.582,18.582,18.582 c10.259,0,18.582-8.316,18.582-18.582V330.011h6.525v56.212c0,7.812,6.332,14.145,14.137,14.145 c7.828,0,14.144-6.333,14.144-14.145v-75.482C445.605,295.108,428.614,278.117,412.989,278.117z"></path> </g> </g></svg></i><span class="right-nav-text">
                                     إدارة أولياء الأمور </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="parents" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة اولياء الامور </a> </li>

                        </ul>
                    </li>


                    <!-- attendance management -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#attendence">
                            <div class="pull-left"><i ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                              </svg></i><span class="right-nav-text">
                                     إدارة  الحضور </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="attendence" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.attendences.index')}}">  إدارة حضور الطلاب</a> </li>
                            <li> <a href="#">إدارة حضور المعلمين </a> </li>

                        </ul>
                    </li>
                     <!-- Results management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#results">
                            <div class="pull-left"><i ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                              </svg></i><span class="right-nav-text">
                                     إدارة النتائج  </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="results" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة الصفوف الدراسية</a> </li>

                        </ul>
                    </li>
                     <!--Exam Tables management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#exam_tables">
                            <div class="pull-left"><i class="fa fa-calendar"></i><span class="right-nav-text">
                                     إدارة الجداول الامتحانية  </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="exam_tables" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.exam_tables.index')}}">قائمة الصفوف الدراسية</a> </li>
                            <li> <a href="themify-icons.html">Themify icons</a> </li>
                            <li> <a href="weather-icon.html">Weather icons</a> </li>
                        </ul>
                    </li>

                     <!--Week Tables management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#week_tables">
                            <div class="pull-left"><i class="fa fa-calendar"></i><span class="right-nav-text">
                                     إدارة جداول الدوام  </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="week_tables" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.week_tables.index')}}">قائمة الصفوف الدراسية</a> </li>
                            <li> <a href="themify-icons.html">Themify icons</a> </li>
                            <li> <a href="weather-icon.html">Weather icons</a> </li>
                        </ul>
                    </li>

                     

                     <!-- notes management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#notes">
                            <div class="pull-left"><i ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-text" viewBox="0 0 16 16">
                                <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                              </svg></i><span class="right-nav-text">
                                     الملاحظات والأسألة </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="notes" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة الصفوف الدراسية</a> </li>
                            <li> <a href="themify-icons.html">Themify icons</a> </li>
                            <li> <a href="weather-icon.html">Weather icons</a> </li>
                        </ul>
                    </li>

                     <!-- Library management -->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#library">
                            <div class="pull-left"><i ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                              </svg></i><span class="right-nav-text">
                                     المكتبة    </span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="library" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة الصفوف الدراسية</a> </li>
                            <li> <a href="themify-icons.html">Themify icons</a> </li>
                            <li> <a href="weather-icon.html">Weather icons</a> </li>
                        </ul>
                    </li>

                    <!--Social guide management -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#tables">
                            <div class="pull-left"><i ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-quote-fill" viewBox="0 0 16 16">
                                <path d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M7.194 6.766a1.7 1.7 0 0 0-.227-.272 1.5 1.5 0 0 0-.469-.324l-.008-.004A1.8 1.8 0 0 0 5.734 6C4.776 6 4 6.746 4 7.667c0 .92.776 1.666 1.734 1.666.343 0 .662-.095.931-.26-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01 1.334-1.329 1.37-2.758.941-3.706a2.5 2.5 0 0 0-.227-.4zM11 9.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01 1.334-1.329 1.37-2.758.942-3.706a2.5 2.5 0 0 0-.228-.4 1.7 1.7 0 0 0-.227-.273 1.5 1.5 0 0 0-.469-.324l-.008-.004A1.8 1.8 0 0 0 10.07 6c-.957 0-1.734.746-1.734 1.667 0 .92.777 1.666 1.734 1.666.343 0 .662-.095.931-.26z"/>
                              </svg></i></i><span class="right-nav-text">
                                    المرشد الاجتماعي   </span></div>
                            <div class="pull-right"><i ></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="tables" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('dashboard.classrooms.index')}}">قائمة الصفوف الدراسية</a> </li>
                            <li> <a href="themify-icons.html">Themify icons</a> </li>
                            <li> <a href="weather-icon.html">Weather icons</a> </li>
                        </ul>
                    </li>
                    <!-- menu title -->
                {{--
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">Widgets, Forms & Tables </li>
                    <!-- menu item Widgets-->
                    <li>
                        <a href="widgets.html"><i class="ti-blackboard"></i><span class="right-nav-text">Widgets</span>
                            <span class="badge badge-pill badge-danger float-right mt-1">59</span> </a>
                    </li>
                    <!-- menu item Form-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Form">
                            <div class="pull-left"><i class="ti-files"></i><span class="right-nav-text">Form &
                                    Editor</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Form" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="editor.html">Editor</a> </li>
                            <li> <a href="editor-markdown.html">Editor Markdown</a> </li>
                            <li> <a href="form-input.html">Form input</a> </li>
                            <li> <a href="form-validation-jquery.html">form validation jquery</a> </li>
                            <li> <a href="form-wizard.html">form wizard</a> </li>
                            <li> <a href="form-repeater.html">form repeater</a> </li>
                            <li> <a href="input-group.html">input group</a> </li>
                            <li> <a href="toastr.html">toastr</a> </li>
                        </ul>
                    </li>
                    <!-- menu item table -->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#table">
                            <div class="pull-left"><i class="ti-layout-tab-window"></i><span class="right-nav-text">data
                                    table</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="table" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="data-html-table.html">Data html table</a> </li>
                            <li> <a href="data-local.html">Data local</a> </li>
                            <li> <a href="data-table.html">Data table</a> </li>
                        </ul>
                    </li>
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">More Pages</li>
                    <!-- menu item Custom pages-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#custom-page">
                            <div class="pull-left"><i class="ti-file"></i><span class="right-nav-text">Custom
                                    pages</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="custom-page" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="projects.html">projects</a> </li>
                            <li> <a href="project-summary.html">Projects summary</a> </li>
                            <li> <a href="profile.html">profile</a> </li>
                            <li> <a href="app-contacts.html">App contacts</a> </li>
                            <li> <a href="contacts.html">Contacts</a> </li>
                            <li> <a href="file-manager.html">file manager</a> </li>
                            <li> <a href="invoice.html">Invoice</a> </li>
                            <li> <a href="blank.html">Blank page</a> </li>
                            <li> <a href="layout-container.html">layout container</a> </li>
                            <li> <a href="error.html">Error</a> </li>
                            <li> <a href="faqs.html">faqs</a> </li>
                        </ul>
                    </li>
                    <!-- menu item Authentication-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#authentication">
                            <div class="pull-left"><i class="ti-id-badge"></i><span
                                    class="right-nav-text">Authentication</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="authentication" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="login.html">login</a> </li>
                            <li> <a href="register.html">register</a> </li>
                            <li> <a href="lockscreen.html">Lock screen</a> </li>
                        </ul>
                    </li>
                    <!-- menu item maps-->
                    <li>
                        <a href="maps.html"><i class="ti-location-pin"></i><span class="right-nav-text">maps</span>
                            <span class="badge badge-pill badge-success float-right mt-1">06</span></a>
                    </li>
                    <!-- menu item timeline-->
                    <li>
                        <a href="timeline.html"><i class="ti-panel"></i><span class="right-nav-text">timeline</span>
                        </a>
                    </li>
                    <!-- menu item Multi level-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#multi-level">
                            <div class="pull-left"><i class="ti-layers"></i><span class="right-nav-text">Multi
                                    level Menu</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="multi-level" class="collapse" data-parent="#sidebarnav">
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#auth">Level
                                    item 1<div class="pull-right"><i class="ti-plus"></i></div>
                                    <div class="clearfix"></div>
                                </a>
                                <ul id="auth" class="collapse">
                                    <li>
                                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#login">Level
                                            item 1.1<div class="pull-right"><i class="ti-plus"></i></div>
                                            <div class="clearfix"></div>
                                        </a>
                                        <ul id="login" class="collapse">
                                            <li>
                                                <a href="javascript:void(0);" data-toggle="collapse"
                                                    data-target="#invoice">level item 1.1.1<div class="pull-right"><i
                                                            class="ti-plus"></i></div>
                                                    <div class="clearfix"></div>
                                                </a>
                                                <ul id="invoice" class="collapse">
                                                    <li> <a href="#">level item 1.1.1.1</a> </li>
                                                    <li> <a href="#">level item 1.1.1.2</a> </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li> <a href="#">level item 1.2</a> </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#error">level
                                    item 2<div class="pull-right"><i class="ti-plus"></i></div>
                                    <div class="clearfix"></div>
                                </a>
                                <ul id="error" class="collapse">
                                    <li> <a href="#">level item 2.1</a> </li>
                                    <li> <a href="#">level item 2.2</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
             --}}
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
