<div style="margin-top: 30px;" id="profile-page" class="section">
    <div id="profile-page-header" class="card profile-header">


        <div class="card-content">
            <div class="row">
                <div class="col s2">
                    <div class="row">
                        <div class="col s12">
                            @if($user['avatar']!="")
                                <img src="{{$user['avatar']}}" alt=""
                                     class="circle z-depth-2 responsive-img activator avatar-image">
                            @else
                                <img src="https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif" alt=""
                                     class="circle z-depth-2 responsive-img activator avatar-image">
                            @endif
                        </div>
                        <div class="col s12">
                            <a title="History" data-id="{{$application['id']}}"
                               class="btn-floating waves-effect waves-light show-history @if(empty($application['events'])) hide @endif"><i
                                        class="mdi-action-history "></i></a>
                        </div>
                    </div>

                </div>
                <div class="col s10">
                    <div class="card-title" style="margin-top:0px;">
                        {{--*/ $lastEducation=end($user['educations']) /*--}}

                        <h5 class="grey-text text-darken-4">{{$user['first_name']}} {{$user['last_name']}} @if(isset($user['age']) && $user['age']>14)
                                ({{$user['age']}})@endif</h5>
                        <button class="btn white black-text right next-profile">></button>
                        <button style="margin-right: 10px;" class="btn white black-text right previous-profile"><
                        </button>
                    </div>

                    {{--*/ $lastWork=end($user['work_experiences']) /*--}}
                    @if(count($user['work_experiences'])>1)
                        {{--*/ $penultimoWork=$user['work_experiences'][count($user['work_experiences'])-2] /*--}}
                    @endif
                    {{--*/ $lastEducation=end($user['educations']) /*--}}
                    @if(is_array($lastWork))
                        <p class="medium-small grey-text">{{$lastWork['role']}}
                            @if(!empty($lastWork['company_plain_text']))
                                {{ trans('profile.presso') }} {{$lastWork['company_plain_text']}}
                            @endif</p>
                    @endif
                    @if(isset($penultimoWork))
                        <p class="medium-small grey-text">{{$penultimoWork['role']}}
                            @if(!empty($penultimoWork['company_plain_text']))
                                {{ trans('profile.presso') }} {{$penultimoWork['company_plain_text']}}
                            @endif</p>
                    @endif
                    @if(is_array($lastEducation))
                        <p class="medium-small grey-text">
                            @if(!empty($lastEducation['study_field']['name']))
                                {{$lastEducation['study_field']['name']}}
                            @else
                                {{ trans('profile.ha_studiato') }}
                            @endif
                            {{ trans('profile.presso') }} {{$lastEducation['school_plain_text']}}</p>
                    @endif

                    <div data-surname="{{$application["user"]["last_name"] or '' }}"
                         data-name="{{$application["user"]["first_name"] or '' }}" class="pleasepressthosebuttons"
                         style="margin-top: 10px">

                        @if( isset($categoryMode) && $categoryMode >= 1)
                            <a data-id="{{$categoryMode}}"
                               class="waves-effect waves-light btn remove-application-category">  <i
                                        class="mdi-action-highlight-remove left"></i> 
                                Remove  </a>  
                            <button data-status="LIKED"  
                                    class=" btn red waves-effect waves-light event-application-button"   type="submit"
                                    data-id="{{$application["id"]}}" data-type="CONTACT">Contact 
                            </button>  

                            @if($application['status']=="STARRED") 
                            <button disabled data-status="LIKED"  
                                    class=" btn red waves-effect waves-light event-application-button disabled"  
                                    type="submit" data-id="{{$application["id"]}}" data-type="CONTACT">Liked 
                            </button>
                              
                            @endif

                            @if($application["status"]=="REJECTED")
                                 
                                <button disabled data-status="DISLIKED"  
                                        class=" btn red waves-effect waves-light PAGARE! event-application-button disabled"
                                          type="submit" data-id="{{$application["id"]}}" data-type="CONTACT">Rejected 
                                </button>  
                            @endif

                        @else
                            <a data-activates="dropdown-db" class="waves-effect waves-light drop-btn btn">
                                <i class="mdi-action-stars left"></i>
                                Save
                            </a>

                            <ul id="dropdown-db" class="dropdown-content">
                                @if(!empty($company["categories"]))
                                    @foreach($company["categories"] as $category)
                                        @if($category["active"])
                                            <li><a onclick="categorySave(this)"
                                                   data-application-id="{{$application["id"]}}"
                                                   data-name="{{$category["title"]}}" data-id="{{$category["id"]}}"
                                                   href="javascript:;"
                                                   class="-text truncate category-save">{{$category["title"]}}
                                                    @if(isset($category["categories_applications"]))
                                                        ({{ count($category["categories_applications"])}}) @endif</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                                <li><a href="javascript:;" class="-text truncate add-category">
                                        <i class="mdi-content-add left "></i>Add category </a>
                                </li>
                            </ul>


                            @if($application["status"]=="SENT")

                                <button data-status="LIKED"
                                        class="btn green waves-effect waves-light  event-application-button"
                                        type="submit"
                                        data-id="{{$application["id"]}}" data-type="STARRED" name="action">Accept
                                </button>
                                <button data-status="DISLIKED"
                                        class="btn red waves-effect waves-light  event-application-button" type="submit"
                                        data-id="{{$application["id"]}}" data-type="REJECTED">Reject
                                </button>

                            @endif
                            @if($application['status']=="STARRED")
                                <button data-status="LIKED"
                                        class=" btn red waves-effect waves-light event-application-button"
                                        type="submit" data-id="{{$application["id"]}}" data-type="CONTACT">Contact
                                </button>
                                <button data-status="HIRED"
                                        class=" btn green waves-effect waves-light PAGARE! event-application-button"
                                        type="submit" data-id="{{$application["id"]}}" data-type="HIRED">HIRE
                                </button>
                                <button data-status="DISLIKED"
                                        class="btn blue waves-effect waves-light  event-application-button"
                                        type="submit"
                                        data-id="{{$application["id"]}}" data-type="REJECTED">Reject
                                </button>
                                <button class="btn grey waves-effect waves-light event-application-button" type="submit"
                                        data-id="{{$application["id"]}}" data-type="SENT">Restore
                                </button>

                            @endif
                            @if($application["status"]=="REJECTED")
                                <button data-status="DISLIKED"
                                        class=" btn red waves-effect waves-light PAGARE! event-application-button"
                                        type="submit" data-id="{{$application["id"]}}" data-type="CONTACT">Contact
                                </button>
                                <button class="btn grey waves-effect waves-light  event-application-button"
                                        type="submit"
                                        data-id="{{$application["id"]}}" data-type="SENT">Restore
                                </button>
                            @endif

                        @endif


                    </div>


                </div>
            </div>
        </div>

    </div>
    <!--/ profile-page-header -->

    <!-- profile-page-content -->
    <div id="profile-page-content" class="row">
        <!-- profile-page-sidebar-->
        <div id="profile-page-sidebar" class="col s12 m3 l3">
            <!-- Profile About  -->
            <div class="card light-blue hide">

            </div>
            <!-- Profile About  -->

            <!-- Profile About Details  -->
            <ul id="profile-page-about-details" class="collection z-depth-1">

                @if(isset($application["duplicated"]) && count($application["duplicated"]) > 1)
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-alert-error left red-text"></i>
                            <div data-position="bottom" data-delay="50"
                                 data-tooltip="{!! implode(", ",$application["duplicated"]) !!}"
                                 class="red-text text-darken-2 bold tooltipped">Applied
                                to {{count($application["duplicated"])}} jobs at your company
                            </div>
                        </div>
                    </li>
                @endif

                @if(isset($application["contacted"]) )
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-content-reply left"></i>
                            <div class="grey-text text-darken-2 bold">Feedback sent
                                on {{$application["contacted"]}}</div>
                        </div>
                    </li>
                @endif



                @if(!empty($user['city']['name']))
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-social-domain left"></i>
                            <div class="grey-text text-darken-1">{{$user['city']['name']}}
                                , {{$user['city']['country_code']}}</div>
                        </div>
                    </li>
                @endif

                @if($user['birthdate']!="")
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-social-cake left"></i>
                            {{--*/ $date=new \DateTime($user['birthdate']) /*--}}
                            <div class="grey-text text-darken-1 ">{{$date->format("d/m/Y")}}</div>
                        </div>
                    </li>
                @endif
                @if($user['mobile_phone']!="" && $application["status"]=="STARRED" )
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-hardware-phone-iphone left"></i>
                            <div class="col s8 grey-text text-darken-1">
                                {{$user['mobile_phone']}}
                            </div>
                        </div>
                    </li>
                @endif
                @if($user['email']!="" && $application["status"]=="STARRED" )
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s8 grey-text text-darken-1">
                                {{$user['email']}}
                            </div>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->type!="COMPANY")
                    @if(isset($application['source']) && $application['source']!=""  )
                        <li class="collection-item">
                            <div class="row">
                                <i class="mdi-action-input left"></i>
                                <div class="col s8 grey-text text-darken-1">
                                    {!!$application['source']!!}
                                </div>
                            </div>
                        </li>
                    @endif
                    @if(isset($application['referer_url']) && $application['referer_url']!=""  )
                        <li class="collection-item">
                            <div class="row">
                                <i class="mdi-action-input left"></i>
                                <div class="col s8 grey-text text-darken-1">
                                    {!!$application['referer_url']!!}
                                </div>
                            </div>
                        </li>
                    @endif
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->type=="COMPANY")
                    @if(isset($application['referer_url']) && $application['referer_url']=="iFrame_Placement_Day_Parma_04/2016"  )
                        <li class="collection-item">
                            <div class="row">
                                <i class="mdi-action-input left"></i>
                                <div class="col s8 grey-text text-darken-1">
                                    {!!$application['referer_url']!!}
                                </div>
                            </div>
                        </li>
                    @endif
                @endif
                <?php

                $link = null;
                ?>
                @if(isset($user["attachments"]) && !empty(end($user["attachments"])["link"]))
                    <?php
                    $cv = end($user["attachments"]);
                    $link = "/cv/" . base64_encode($cv["link"]);
                    ?>
                @endif


                @if(isset($application["cv"]["link"]) && $application["cv"]["link"]!="")
                    <?php

                    $link = "/cv/" . base64_encode($application["cv"]["link"]);
                    ?>
                @endif

                @if($link)
                    <li class="collection-item">
                        <div class="row">
                            <a target="_blank" class="download-cv" href="{{$link}}">
                                <i class="mdi-file-file-download left"></i>
                                <div class="grey-text text-darken-2 bold">Download CV</div>

                            </a>
                        </div>
                    </li>
                @elseif(!isset($application["requestedCv"]) )
                    <li class="collection-item">
                        <div class="row">
                            <a target="_blank" href="javascript:;" class="ask-upload-cv"
                               type="submit" data-id="{{$application["id"]}}">
                                <i class="mdi-content-send left"></i>
                                <div class="grey-text text-darken-2 bold">Ask to upload CV</div>

                            </a>
                        </div>
                    </li>

                @else
                    <li class="collection-item">
                        <div class="row">
                            <i class="mdi-action-done left"></i>
                            <div class="grey-text text-darken-2 bold">Requested
                                CV
                                <?php
                                $data = new \DateTime($application["requestedCv"]);
                                if (App::getLocale() == "it")
                                    echo $data->format("d-m-Y");
                                else
                                    echo $data->format("m-d-Y");

                                ?>
                            </div>


                        </div>
                    </li>


                @endif
            </ul>

            @if($application['cover_letter']!="")
                <a target="_blank" class="download-cv" style="margin-top:20px" href="{{$application['cover_letter']}}">

                    <button class="btn green waves-effect waves-light white-text download-cv">
                        <i class="mdi-file-file-download left"></i>
                        <span class="white-text">Cover Letter</span>
                    </button>
                </a>
                @endif

                        <!-- languages -->

                @if(!empty($user['languages']))
                    <ul id="task-card" class="collection z-depth-1">

                        @foreach($user['languages'] as $language)
                            <li class="" style="padding:5px;padding-top:0px; ">
                                <div class="row">
                                    <div class="col s12 grey white-text dark-violet">
<span class="title white-text" style="font-size: 1.2rem;
font-weight: bold;
text-transform: uppercase;">
@if(isset($language['system_language']['italian_name']) && App::getLocale()=="it")
        {{$language['system_language']['italian_name']}}
    @else
        {{$language['system_language']['name']}}
    @endif
</span>
                                    </div>
                                    <div class="col s12">
                                        <span class="ultra-small">{{ trans('profile.lettura') }}</span><br>
                                        {{--*/ $stelleCount=5 /*--}}
                                        @for($i=1;$i<=$language['grade_read'];$i++)
                                            <i class="fa fa-star"></i>
                                            {{--*/ $stelleCount-=1 /*--}}
                                        @endfor
                                        @for($i=1;$i<=$stelleCount;$i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    </div>
                                    <div class="col s12">


                                        <span class="ultra-small">{{ trans('profile.scrittura') }}</span><br>
                                        {{--*/ $stelleCount=5 /*--}}
                                        @for($i=1;$i<=$language['grade_write'];$i++)
                                            <i class="fa fa-star"></i>
                                            {{--*/ $stelleCount-=1 /*--}}
                                        @endfor
                                        @for($i=1;$i<=$stelleCount;$i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor

                                    </div>
                                    <div class="col s12">

                                        <span class="ultra-small">{{ trans('profile.dialogo') }}</span><br>
                                        {{--*/ $stelleCount=5 /*--}}
                                        @for($i=1;$i<=$language['grade_speak'];$i++)
                                            <i class="fa fa-star"></i>
                                            {{--*/ $stelleCount-=1 /*--}}
                                        @endfor
                                        @for($i=1;$i<=$stelleCount;$i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    </div>


                                </div>


                            </li>

                        @endforeach

                    </ul>
                    <!-- languages -->
                @endif

        </div>
        <!-- profile-page-sidebar-->

        <!-- profile-page-wall -->
        <div id="profile-page-wall" class="col s12 m9 l9">


            <div id="card-alert" class="card white lighten-1">

                @if((!isset($application["comment"])))
                    <div class="card-comment">
                        <div class="card-content black-text ">
<span style="font-size: 20px;"
      class="card-title black-text">Here you can take notes about {{$application["user"]["first_name"]}}</span>


                        </div>
                        <div class="card-action white darken-1">
                            <a href="javascript:;" onclick="toggle('.card-ux','show',true,'.card-comment')">Add
                                note</a>
                        </div>
                    </div>
                @else
                    <div class="card-comment">
                        <div class="card-content black-text ">
                            @foreach($application["comment"] as $comment)
                                <p id="comment-{{$comment["id"]}}" class="application-comment">{{$comment["date"]}}:
                                    <span style="font-style:italic">{{$comment["text"]}}</span> &nbsp; <a
                                            id="remove-comment" data-id="{{$comment["id"]}}"
                                            href="javascript:;" class="">Remove note</a></p>

                            @endforeach
                            <ul class="comment-ul">
                                <li><a href="javascript:;"
                                       onclick="toggle('.card-ux','show',true,'.application-comment')"
                                       class="waves-effect waves-light red btn white-text">Add note</a></li>


                            </ul>

                        </div>

                    </div>
                @endif


                <div style="display: none;" class="card-ux lighten-1">

                    <div class="card-content">


                        <label lang="en" for="candidateComment">Note</label>
<textarea placeholder="Type a note about {{$application["user"]["first_name"]}}"
          class="materialize-textarea"
          name="candidateComment"
          id="candidateComment">{{$application["comment"]["text"] or ''}}</textarea>
                    </div>
                    <div class="card-action white darken-1">
                        <a data-id="{{$application["id"]}}" id="save-comment"
                           class="waves-effect waves-light red btn white-text ">Save note</a>
                        <a onclick="toggle('.card-comment','show',true,'.card-ux')"
                           class="waves-effect waves-light grey btn white-text">Cancel</a>
                    </div>


                </div>

            </div>

            <!--work collections start-->
            <div id="work-collections" class="seaction">

                <div class="row">
                    <div class="">
                        <h4 class="header col s12 m12 l12">{{ trans('profile.esperienze_lavorative') }}</h4>


                        @foreach($user['work_experiences'] as $work)
                            @if(isset($work['id']))

                                <div class="row col s12 m12 l12" data-update-route="work-experience">
                                    <div class="work-experience" method="POST" action="#">

                                        <div class="">
                                            <div class="card white">

                                                <div class="card-content black-text">

                                                    <input type="hidden" name="id" class="work_experience_id"
                                                           value="{{$work['id']}}">
<span style="font-size: 19px;" class="card-title">
    <div class="row">
        <div class="col m12 s12 l12 margin-remove-15 ">
            @if(!empty($work["role"]))
                {{$work["role"]}}
                @if (!empty($work['job_function']["name"]))
                    ({{$work['job_function']["name"]}})
                @endif
            @else
                @if (!empty($work['job_function']["name"]))
                    {{$work['job_function']["name"]}}
                @endif
            @endif


        </div>
    </div>
</span>

                                                    <div class="row">
                                                        <div class="col m12 l12 s12">
                                                            <p class=""><i class="mdi-social-domain left"></i>
                                                                @if(!empty($work['company_plain_text']) && strlen($work['company_plain_text']) > 0)
                                                                    {{$work['company_plain_text']}}
                                                                @else
                                                                    {{ trans('profile.No company specified')  }}
                                                                @endif
                                                                @if(isset($work['industry']['name']))
                                                                    ({{$work['industry']['name']}})@endif


                                                                @if(isset($work['company']['city_plain_text']))
                                                                    {{ trans('profile.presso') }} {{$work['company']['city_plain_text']}}@endif


                                                            </p>
                                                            <p><i style="font-size: 15px;"
                                                                  class="mdi-action-event small"></i>
                                                                {{ trans('profile.dal') }}
                                                                <b>{{date('m/Y', strtotime($work['start_date']))}}
                                                                    @if($work['end_date']!="2100-01-01")
                                                                        {{ trans('profile.al') }}
                                                                        <b>{{date('m/Y', strtotime($work['end_date']))}}
                                                                        </b>
                                                                    @else
                                                                        <b>{{ trans('wizard-application.attualmente_lavoro_qui') }}</b>
                                                                @endif

                                                            </p>

                                                        </div>
                                                        @if(!empty($work['comment']))
                                                            <div class="col m12 ">
                                                                <p class="grey-text comment">
                                                                    {{$work['comment']}}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>

                <!-- Floating Action Button -->
            </div>

            <!--work collections start-->
            <div id="education-collections" class="seaction">

                <div class="row">
                    <div class="">

                        @if(!empty($user['educations']))
                            <h4 class="header col s12 m12 l12">{{ trans('profile.percorso_scolastico') }}</h4>
                        @endif
                        @foreach(array_reverse($user['educations']) as $edu)

                            @if(isset($edu['id']))
                                <div class="row col s12 m12 l12">


                                    <div class="education">


                                        <div class="card red">
                                            <div class="card-content white-text">

                                                <input type="hidden" name="id" class="education_id"
                                                       value="{{$edu['id']}}">

<span style="font-size: 20px;" class="card-title">
    <div class="row">

        <div class="col m10 s10 l10 truncate margin-remove-15">
            {{$edu['school_plain_text']}}
            @if(isset($edu['study_field']['name']))
                ({{$edu['study_field']['name']}})@endif
        </div>

    </div>

</span>

                                                <div class="row">
                                                    <div class="col m8">
                                                        <p><i class="mdi-communication-location-on"
                                                              style="font-size: 16px;"></i>
                                                        @if(isset($edu['school']['city']['name']))
                                                            {{$edu['school']['city']['name']}}
                                                        @else
                                                            {{ trans('profile.No position specified') }}
                                                        @endif

                                                        <p><i style="font-size: 15px;"
                                                              class="mdi-action-event small"></i>
                                                            {{ trans('profile.dal') }}
                                                            <b>{{date('m/Y', strtotime($edu['start_date']))}}
                                                                @if($edu['end_date']!="2100-01-01")
                                                                    {{ trans('profile.al') }}
                                                                    <b>{{date('m/Y', strtotime($edu['end_date']))}}
                                                                    </b>
                                                                @else
                                                                    <b>{{ trans('wizard-application.attualmente_studio_qui') }}</b>
                                                            @endif

                                                        </p>
                                                        <p><i style="font-size: 15px;"
                                                              class="mdi-social-school small"></i>
                                                            {{$edu['grade']}}
                                                        </p>
                                                    </div>
                                                </div>


                                            </div>


                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endforeach

                    </div>
                </div>

                <!-- Floating Action Button -->
            </div>


        </div>
        <!--/ profile-page-wall -->

    </div>
</div>


<script>
    $(document).ready(function () {
        $('.drop-btn:visible').dropdown();
        $('.tooltipped').tooltip({delay: 50});

    });
</script>


<div id="modal-history-{{$application['id']}}" class="modal std-modal modal-history" style="width:60%">
    <div class="modal-content">
        <section id="cd-timeline" class="cd-container">

            @foreach(array_reverse($application['events']) as $event)
                @if($event['status']=="SENT")
                    <?php
                    $event['status'] = "RESTORED";
                    $event['comment'] = "Application Restored";
                    ?>
                @endif
                @if($event['status']=="STARRED")
                    <?php
                    $event['comment'] = "Application LIKED";
                    $event['title'] = "Application LIKED";
                    ?>
                @endif
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture {{strtolower($event['status'])}}">
                        @if($event['status']=="READ")
                            <i class="mdi-image-remove-red-eye "></i>
                        @endif

                        @if($event['status']=="COMMENT")
                            <i class="mdi-editor-insert-comment   "></i>
                        @endif

                        @if($event['status']=="CONTACT")
                            <i class="mdi-communication-email  "></i>
                        @endif

                        @if($event['status']=="RESTORED")
                            <i class="mdi-action-settings-backup-restore   "></i>
                        @endif
                        @if($event['status']=="STARRED")
                            <i class="mdi-action-thumb-up  "></i>
                        @endif

                        @if($event['status']=="REJECTED")
                            <i class="mdi-action-thumb-down "></i>
                        @endif

                        @if($event['status']=="HIRED")
                            <i class="mdi-action-work  "></i>
                        @endif


                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>{{$event['title']}}</h2>
                        <p>{{$event['comment']}}</p>
                    <span class="cd-date">
                        <?php
                        $data = new \DateTime($event['created_at']);
                        echo $data->format("d M Y H:i");
                        ?><br>
                        @if(isset($event['author']['first_name']))
                            {{$event['author']['first_name']}} {{$event['author']['last_name']}}
                        @endif
                    </span>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            @endforeach

        </section> <!-- cd-timeline -->
    </div>

</div>