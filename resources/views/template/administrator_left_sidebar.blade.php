<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details" style="background: #e6e6e6; !important;">
            <div class="row">

                <div class="col col s12 m12 l12">
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
                    <p class="user-roal dark-color" style="color:black">
                        @if(isset($company["name"]))
                        {{ $company["name"]}}
                            @endif
                    </p>
                </div>
            </div>
        </li>
        <li class="no-padding">
                <a href="/admin/dashboard" class="waves-effect waves-cyan"><i
                                class="mdi-action-dashboard"></i> Dashboard</a>

        </li>
        <li class="no-padding">
            <a href="/admin/statistics" class="waves-effect waves-cyan"><i
                        class="mdi-editor-insert-chart"></i> Statistiche</a>

        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a href="#" class="collapsible-header waves-effect waves-cyan"><i
                                class="mdi-action-work"></i> Companies</a>


                    <div class="collapsible-body">

                        <ul>

                            @if(!empty($companies))
                                @foreach($companies as $company)
                                    @if($company)
                                        <li><a class="truncate" href="/admin/{{$company["permalink"]}}">{{$company["name"]}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>

                    </div>
                </li>
            </ul>
        </li>



        @if(\Illuminate\Support\Facades\Auth::user()->company)
            <?php $company=\Illuminate\Support\Facades\Auth::user()->company; ?>
            <li class="li-hover">
                <div class="divider"></div>
            </li>
            <li class="li-hover"><p class="ultra-small margin more-text">
                    @if(isset($company["name"]))
                    {{$company['name']}}
                @endif</p></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion ">
                    <li class="bold ">
                        <a class="collapsible-header waves-effect waves-cyan   "><i
                                    class="mdi-action-store"></i>Branding Page </a>
                        <div class="collapsible-body ">
                            <ul>

                                <li class="bold "><a href="/hr/company-page?company-id={{$company['id']}}"
                                                                                              class="waves-effect waves-cyan"><i
                                                class="mdi-action-store"></i> Company
                                        Data </a>
                                </li>

                                <li class="bold "><a href="/hr/photogallery?company-id={{$company['id']}}"
                                                                                               class="waves-effect waves-cyan"><i
                                                class="mdi-image-photo-library "></i> Photogallery</a>
                                </li>

                                <li class="bold "><a href="/hr/team?company-id={{$company['id']}}"
                                                                                       class="waves-effect waves-cyan"><i
                                                class="mdi-social-people  "></i> Team</a>
                                </li>

                                <li class="bold "><a href="/hr/videos?company-id={{$company['id']}}"
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
                                    <a href="/hr/db/categories?company-id={{$company['id']}}" class=" waves-effect waves-cyan"><i
                                                class="mdi-action-bookmark-outline"></i> Saved candidates</a>
                                </li>
                                <li ><a href="/hr/archive-vacancies?company-id={{$company['id']}}" class="waves-effect waves-cyan"><i
                                                class="mdi-content-archive "></i> All vacancies</a>
                                </li>
                            </ul>

                        </div>
                    </li>
                </ul>
            </li>


        @endif


        <li class="li-hover">
            <div class="divider"></div>
        </li>
        <li class="li-hover"><p class="ultra-small margin more-text">MORE</p></li>
        <li class="bold"><a href="/admin/codici-sconto" class="waves-effect waves-cyan"><i
                        class="mdi-action-wallet-giftcard"></i> Codici Sconto</a>
        </li>
        <li><a href="#modal-info" class="modal-trigger"><i class="mdi-action-info"></i> Info</a>
        </li>
        <li><a href="mailto:support@meritocracy.is"><i class="mdi-communication-live-help"></i> Help</a>
        </li>
            <?php $company=\Illuminate\Support\Facades\Auth::user()->company; ?>
        <li class="bold"><a href="/user/settings?companyId={{$company['id']}}" class="waves-effect waves-cyan"><i
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
