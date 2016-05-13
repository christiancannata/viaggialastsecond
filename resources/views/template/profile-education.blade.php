@foreach(array_reverse($education) as $education)

    @if(isset($education['id']))
        <div class="row" data-update-route="education">


            <div style="margin-top: -15px;" class="education summary-box" method="POST"
                 action="#">


                <div class="col s12 m12 l12">
                    <div class="card  red">
                        <div class="card-content white-text">

                            <input type="hidden" name="id" class="education_id"
                                   value="{{$education['id']}}">

                                                    <span class="card-title">
                                                        <div class="row">

                                                            <div class="col m10 s10 l10 ">
                                                                {{$education['school_plain_text']}}
                                                            </div>
                                                            <div class="col m2 s2 l2 right-align">


                                                                <a style="background-color: white!important;"
                                                                   data-id="{{$education['id']}}"
                                                                   href="#"
                                                                   class="modify-education btn-floating white waves-effect waves-light"><i
                                                                            class="mdi-editor-mode-edit black-text"></i></a>


                                                                <a style="background-color: white!important;"
                                                                   data-href="/elimina/education/{{$education['id']}}"
                                                                   data-method="GET" href="#"
                                                                   class="action-button btn-floating waves-effect waves-light "><i
                                                                            class="mdi-content-clear black-text"></i></a>

                                                            </div>
                                                        </div>

                                                    </span>

                            <div class="row">
                                <div class="col m8">
                                    <p>
                                        <i class="mdi-social-school"></i>&nbsp;{{$education['comment']}}
                                    </p>

                                    @if(isset($education['grade']) && $education['grade'] !="")
                                        <p>
                                            <i class="mdi-social-school"></i>&nbsp;{{$education['grade']}}
                                        </p>
                                    @endif

                                    @if(isset($education['study_field']))
                                        <p>
                                            @if(App::getLocale("it"))
                                                <i class="mdi-social-school"></i>
                                                &nbsp;{{$education['study_field']["name_it"]}}
                                            @else
                                                <i class="mdi-social-school"></i>
                                                &nbsp;{{$education['study_field']["name"]}}
                                            @endif
                                        </p>
                                    @endif

                                    <p><i class="prefix mdi-action-event"></i>
                                        {{ trans('profile.dal') }}
                                        <b>{{date('m/Y', strtotime($education['start_date']))}}
                                        </b>
                                        @if($education['end_date']!="2100-01-01")
                                            {{ trans('profile.al') }}
                                            <b>{{date('m/Y', strtotime($education['end_date']))}}
                                            </b>
                                        @else
                                            <b>{{ trans('wizard-application.attualmente_studio_qui') }}</b>
                                        @endif

                                        <br>

                                </div>


                            </div>


                        </div>

                    </div>
                </div>
            </div>


            <div class="form hide">
                <div class="col s12 m12 l12">
                    <div class="card  red">
                        <form class="edit-education form-edit"
                              data-id="{{$education['id']}}">

                            <input type="hidden" name="id_education"
                                   value="{{$education['id']}}">
                            <div class="container">

                                <div class="row">

                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance white-text"></i>
                                        <select required
                                                id="titolo_studio_{{$education['id']}}"
                                                name="comment">
                                            <option value="" disabled
                                            >{{ trans('profile.titolo_studio') }}</option>
                                            @foreach($degrees as $function)
                                                <option value="{{$function['name']}}"
                                                        @if($function['name'] == $education['comment']) selected @endif>{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label class="white-text"
                                               for="titolo_studio_{{$education['id']}}">{{ trans('wizard-application.titolo_studio') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance white-text"></i>
                                        <input id="school" type="text"
                                               name="school_plain_text"
                                               value="{{$education['school_plain_text']}}"
                                               class="required active" required>
                                        <label class="white-text active"
                                               for="school_{{$education['id']}}">{{ trans('wizard-application.luogo_studio') }}</label>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance white-text"></i>

                                        <select required
                                                id="fac_education_{{$education['id']}}"
                                                name="study_field[id]">
                                            <option value="" disabled
                                                    selected>{{ trans('profile.facolta') }}</option>
                                            @foreach($studyFields as $function)
                                                <option value="{{$function['id']}}"
                                                        @if($function['id']==$education['study_field']['id']) selected @endif>{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label class="white-text"
                                               for="fac_education_{{$education['id']}}">{{ trans('wizard-application.facolta') }}</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix white-text"></i>
                                        <label class="white-text active"
                                               for="data_inizio_education_{{$education['id']}}">{{ trans('wizard-application.data_inizio') }}</label>
                                        <input onkeydown="return false" type="text"
                                               name="start_date"
                                               value="{{date('m/Y', strtotime($education['start_date']))}}"
                                               id="data_inizio_education_{{$education['id']}}"
                                               class="datepicker required active" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix white-text"></i>
                                        <label class="white-text active"
                                               for="data_fine_education">{{ trans('wizard-application.data_fine') }}</label>
                                        <input onkeydown="return false" type="text"
                                               name="end_date"
                                               value="{{date('m/Y', strtotime($education['end_date']))}}"
                                               id="data_fine_education"
                                               class="datepicker required active">

                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input style="margin-left:-10px;margin-top:30px"
                                               type="checkbox" name="studio_attuale"
                                               id="studio_attuale_{{$education['id']}}"
                                               @if($education['is_current']) checked @endif />
                                        <label style="margin-left:-10px;margin-top:30px"
                                               class="white-text active"
                                               for="studio_attuale_{{$education['id']}}">{{ trans('wizard-application.attualmente_studio_qui') }}</label>

                                    </div>
                                </div>


                                <?php
                                $grade = explode("/", $education['grade']);
                                ?>
                                <div class="row" style="margin-top:15px">
                                    <div class="input-field col s5 m2">
                                        <input min="1" name="grade_min"
                                               value="@if(isset($grade[0])){{$grade[0]}}@endif"
                                               placeholder="100"
                                               id="grade_min_{{$education['id']}}"
                                               type="text"
                                               class="validate">
                                        <label class="white-text active"
                                               for="grade_min_{{$education['id']}}">{{ trans('wizard-application.voto') }}</label>
                                    </div>
                                    <div class="input-field col s1 m1">
                                        <p class="white-text"
                                           style="margin-top: 0px;font-size: 2.5rem;">/</p>
                                    </div>
                                    <div class="input-field col s5 m2">
                                        <input min="1" id="grade_max_{{$education['id']}}"
                                               value="@if(isset($grade[1])){{$grade[1]}}@endif"
                                               name="grade_max"
                                               placeholder="{{ trans('wizard-application.your_grade') }}"
                                               type="text"
                                               class="required validate" maxlength="3"
                                               required>
                                    </div>


                                    <div class="col s12 m12 right-align">

                                        <!-- Dropdown Trigger -->
                                        <button name="action" type="submit"
                                                class="waves-effect waves-light btn edit-work-experience black">
                                            <i class="mdi-maps-rate-review left "></i>{{ trans('profile.aggiorna') }}
                                        </button>
                                    </div>


                                </div>


                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    @endif
@endforeach
<script>
    $(document).ready(function(){
        $('select').material_select();
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            format: 'mm/yyyy',
            max: new Date()
        });
    });
</script>