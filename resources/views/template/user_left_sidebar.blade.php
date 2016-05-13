@if(Auth::check())
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">





        <li class="user-details light-grey">
            <div class="row">
                <div class="col col s4 m4 l4">
                    @if(isset($user) && $user['avatar']!="")
                    <img src="{{$user['avatar']}}" alt="" class="circle responsive-img valign profile-image">
                @else
                        <img src="https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif" alt="" class="circle responsive-img valign profile-image">

                    @endif
                </div>
                <div class="col col s8 m8 l8" style="line-height: 1.5rem;">
                  <!--  <ul id="profile-dropdown" class="dropdown-content">
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
                    </ul> -->
                   {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                </div>
            </div>
        </li>

        @include("admin.menu.".strtolower(isset(Auth::user()->type) ? Auth::user()->type : "user"))




    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>
@endif