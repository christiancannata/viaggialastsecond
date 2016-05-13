<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details" style="background: #e6e6e6; !important;">
            <div class="row">
                <div class="col col s4 m4 l4">
                    @if(Auth::user()->type=="USER" )
                        <img src="{{Auth::user()->avatar}}" alt="" class="circle responsive-img valign profile-image">
                    @else
                        @if(isset(Auth::user()->company['logo_small']))
                        <img src="{{Auth::user()->company['logo_small']}}" alt="" class="responsive-img valign">
                        @endif
                    @endif
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a>
                        </li>
                        <li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
                        </li>
                        <li><a href="#"><i class="mdi-communication-live-help"></i> Help</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a>
                        </li>
                        <li><a href="#"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                        </li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn  dark-color" href="#"
                       data-activates="profile-dropdown" style="color:black !important;">{{Auth::user()->first_name . " ".  Auth::user()->last_name}}<i
                                class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal dark-color" style="color:black">{{Auth::user()->company["name"]}}</p>
                </div>
            </div>
        </li>
        <li class="no-padding">
                <a href="/hr" class="waves-effect waves-cyan"><i
                                class="mdi-action-dashboard"></i> Dashboard</a>

        </li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a href="#" class="collapsible-header waves-effect waves-cyan"><i
                                class="mdi-action-work"></i> Vacancies</a>


                    <div class="collapsible-body">

                        <ul>

                            @if(!empty(Auth::user()->company['vacancies']))
                                @foreach(Auth::user()->company['vacancies'] as $vacancy)
                                    @if($vacancy["is_visible_hr"])
                                        <li><a class="truncate" href="/hr/{{$vacancy["permalink"]}}">{{$vacancy["name"]}}</a>
                                        </li>
                                    @endif

                                @endforeach
                            @endif
                        </ul>

                    </div>
                </li>
            </ul>
        </li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion @if($route=="photogallery" || $route=="company-page") active @endif">
                <li class="bold ">
                    <a class="collapsible-header waves-effect waves-cyan @if(!Auth::user()->company['is_complete']) red-text @endif  @if($route=="photogallery" || $route=="company-page") active @endif"><i
                                class="mdi-action-store"></i>Branding Page </a>
                    <div class="collapsible-body ">
                        <ul>

                            <li class="bold @if($route=="company-page") active @endif"><a href="/hr/company-page"
                                                                                          class="waves-effect waves-cyan"><i
                                            class="mdi-action-store"></i> Company
                                    Data @if(!Auth::user()->company['is_complete']) <i
                                            class="mdi-alert-warning yellow-text right"></i> @endif</a>
                            </li>

                            <li class="bold @if($route=="photogallery")  active @endif"><a href="/hr/photogallery"
                                                                                           class="waves-effect waves-cyan"><i
                                            class="mdi-image-photo-library "></i> Photogallery</a>
                            </li>

                            <li class="bold @if($route=="team")  active @endif"><a href="/hr/team"
                                                                                   class="waves-effect waves-cyan"><i
                                            class="mdi-social-people  "></i> Team</a>
                            </li>
                            <li class="bold @if($route=="benefits")  active @endif"><a href="/hr/benefits"
                                                                                       class="waves-effect waves-cyan"><i
                                            class="mdi-image-edit"></i> Benefits</a>
                            </li>

                            <li class="bold @if($route=="video")  active @endif"><a href="/hr/videos"
                                                                                    class="waves-effect waves-cyan"><i
                                            class="mdi-av-video-collection  "></i> Videos</a>
                            </li>
                        </ul>
                    </div>

                </li>
            </ul>
        </li>


        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i
                                class="mdi-content-archive "></i>Archive</a>


                    <div class="collapsible-body">

                        <ul>
                            <li>
                                <a href="/hr/db/categories" class=" waves-effect waves-cyan"><i
                                            class="mdi-action-bookmark-outline"></i> Saved candidates</a>
                            </li>
                            <li ><a href="/hr/archive-vacancies" class="waves-effect waves-cyan"><i
                                            class="mdi-content-archive "></i> All vacancies</a>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>
        </li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i
                                class="mdi-editor-attach-money @if($route=="payments") active @endif" ></i>Billing</a>

                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="/hr/billing-data" class=" waves-effect waves-cyan"><i
                                            class="mdi-action-bookmark-outline"></i>Billing data</a>
                            </li>
                            <li ><a href="/hr/payments" class="waves-effect waves-cyan"><i
                                            class="mdi-content-archive "></i>Billing history</a>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>
        </li>
        <li class="li-hover">
            <div class="divider"></div>
        </li>
        <li class="li-hover"><p class="ultra-small margin more-text">MORE</p></li>
        <li><a href="#modal-info" class="modal-trigger"><i class="mdi-action-info"></i> Info</a>
        </li>
        <li><a href="mailto:support@meritocracy.is"><i class="mdi-communication-live-help"></i> Help</a>
        </li>
        <li class="bold"><a href="/user/settings" class="waves-effect waves-cyan"><i
                        class="mdi-action-settings"></i> Settings</a>
        </li>

        <li class="li-hover">
            <div class="divider"></div>
        </li>

        <li class="bold"><a href="/logout"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>

    </ul>
    <a href="#" data-activates="slide-out"
       class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i
                class="mdi-navigation-menu"></i></a>
</aside>
