<div data-vacancy-id="{{$vacancy["id"]}}" id="vacancy-{{$vacancy["id"]}}" class="card">
    <input type="hidden" value="{{json_encode($vacancy)}}" id="vacancy-data-{{$vacancy["id"]}}">
    <div class="card-content">
        <div class="card-title activator grey-text text-darken-4 bold">
            <span>{{$vacancy["name"]}}</span>
            <ul style="display: inline-block; margin-left: 20px;" class="card-subtitle">

                <li class="edited ">
                    <div class="chip2 green white-text">New Vacancy</div>
                </li>

                @if(isset($vacancy["job_function"]["name"]))
                    <li>
                        <div class="chip2">{{ $vacancy["job_function"]["name"] }} <i
                                    class="mdi-action-work material-icons"></i></div>
                    </li>
                @endif

                @if(isset($vacancy["study_field"]["name"]))
                    <li>
                        <div class="chip2">{{ $vacancy["study_field"]["name"] }} <i
                                    class="mdi-social-school material-icons"></i></div>
                    </li>
                @endif

                @if(isset($vacancy["industry"]["name"]))
                    <li>
                        <div class="chip2">{{ $vacancy["industry"]["name"] }} <i
                                    class="mdi-communication-business material-icons"></i></div>
                    </li>
                @endif
            </ul>
            <h6>@if(isset($vacancy['city_plain_text'])) {{$vacancy['city_plain_text']}} @endif</h6>

        </div>

        <div class="card-description">
            <span class="grey-text">Description: </span> {!! strip_tags($vacancy["description"],"<br><br />")  !!}
        </div>

                                <span style="position: absolute; top: 10px; right: 20px;"
                                      class="grey-text ultra-small">{{date('d F Y', strtotime($vacancy["created_at"])) }}</span>

        <ul id="dropdown-vacancy-{{$vacancy["id"]}}" class="dropdown-content">
            <li><a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                   class="red-text vacancy-edit"><i class="mdi-editor-mode-edit"></i>&nbsp;Edit</a>
            </li>
            <li class=""><a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                            class="red-text vacancy-clone"><i class="mdi-content-content-copy"></i>&nbsp;Clone</a>
            </li>
            <li>
                <a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                   class="red-text vacancy-close"><i class="mdi-navigation-close"></i>&nbsp;Close</a>
            </li>
            <li><a class="vacancy-sort red-text"><i class="mdi-editor-wrap-text"></i>&nbsp;Order</a>
            </li>

        </ul>


    </div>
    <div class="card-action">
        <a href="/hr/{{$vacancy["permalink"]}}" class="btn waves waves-light waves-effect red"
           lang="en" target="_blank">View candidates (<span class="total-application"
                                                            data-id-vacancy="{{$vacancy['id']}}">{{$vacancy['total_application']['total']}}</span>)</a>

        <a class="btn dropdown-button waves-effect waves-light red" href="#!"
           data-activates="dropdown-vacancy-{{$vacancy["id"]}}">Options<i
                    class="mdi-navigation-arrow-drop-down right"></i></a>

    </div>
</div>