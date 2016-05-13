<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="dark-violet">
            <div class="nav-wrapper">
                <ul class="left">
                    <li><h1 class="logo-wrapper"><a href="/hr"
                                                    class="brand-logo darken-1"><img
                                        src="https://meritocracy.is/img/logos/white-full-logo.png" alt="Meritocracy logo"></a> <span
                                    class="logo-text">Meritocracy</span></h1></li>
                </ul>
                @if(isset($company) && Auth::user()->type=="ANALYTICS")
                    <div class="header-search-wrapper">
                        <i class="mdi-action-search"></i>
                        <input type="text" name="Search" id="search" data-filter="company" data-id="{{\Illuminate\Support\Facades\Auth::user()->company['id']}}" class="header-search-input z-depth-2 search-hr"
                               placeholder="Search for resumes, vacancies, …"/>
                        @endif
                    </div>
                <ul class="right hide-on-med-and-down">
                   <!-- <li><a data-activates="chat-out"
                           class="waves-effect waves-block waves-light preview-company-page">
                            <i
                                    class="mdi-action-home"></i>
                        </a>
                    </li> -->
                    <li>
                        @if(isset(Auth::user()->company['permalink']))
                        <a href="/{{Auth::user()->company['permalink']}}" target="_blank" data-activates="chat-out"
                           class="waves-effect waves-block waves-light preview-company-page"><i
                                    class="mdi-action-home"></i></a>
                            @endif
                    </li>
                  <!--  <li ><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button"
                           data-activates="notifications-dropdown"><i class="mdi-social-notifications">
                                <small class="notification-badge">5</small>
                            </i>

                        </a>
                    </li>
                    <li><a href="#" data-activates="chat-out"
                           class="waves-effect waves-block waves-light chat-collapse"><i
                                    class="mdi-communication-chat"></i></a>
                    </li>-->

                </ul>

                <!-- notifications-dropdown
                <ul id="notifications-dropdown" class="dropdown-content">
                    <li>
                        <h5>NOTIFICATIONS <span class="new badge">5</span></h5>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#!"><i class="mdi-action-add-shopping-cart"></i> A new order has been placed!</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-stars"></i> Completed the task</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-settings"></i> Settings updated</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-editor-insert-invitation"></i> Director meeting started</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-trending-up"></i> Generate monthly report</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                    </li>
                </ul>-->
            </div>
        </nav>
    </div>
    <!-- end header nav-->
</header>
<div id="modal-info" class="modal">
    <div class="modal-content red white-text center-align">
        <a href="/hr" class="brand-logo darken-1"><img src="https://meritocracy.is/img/logos/white-full-logo.png" alt="Meritocracy logo"></a>
        <br><br><br>
        <h5>Meritocracy HR Platform</h5>
        <p>Current version: 3.2.2</p>
        <p>Latest release: 23/03/2016</p>

    </div>
    <div class="modal-footer red ">
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close white-text">Ok</a>
    </div>
</div>