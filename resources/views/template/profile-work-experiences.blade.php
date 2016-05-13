@foreach(array_reverse($workExperiences) as $key=>$work)
    @if(isset($work['id']))

        <div class="row " data-update-route="work-experience" data-id="{{$work['id']}}">
            <div class="work-experience summary-box" method="POST" action="#">

                <div class="col s12 m12 l12">
                    <div class="card grey-meritocracy-user">

                        <div class="card-content white-text">

                            <input type="hidden" name="id" class="work_experience_id"
                                   value="{{$work['id']}}">

                            <div class="card-title">

                                <div class="row">
                                    <div class="col m10 s10 l10 ">
                                        {{$work['company_plain_text']}}

                                    </div>

                                    <div class="col m2 s2 l2 right-align">

                                        <a data-id="{{$work['id']}}"
                                           href="#"
                                           class="modify-experience btn-floating waves-effect waves-light"><i
                                                    class="mdi-editor-mode-edit"></i></a>

                                        <a data-href="/elimina/work-experience/{{$work['id']}}"
                                           data-method="GET" href="#"
                                           class="action-button btn-floating waves-effect waves-light "><i
                                                    class="mdi-content-clear"></i></a>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col m8">
                                    <p>
                                        <i class="mdi-action-work"
                                           style="font-size: 16px;"></i>&nbsp;{{$work['role']}}
                                    </p>
                                    <p><i class="mdi-communication-location-on"
                                          style="font-size: 16px;"></i>

                                        @if(isset($work['city_plain_text']))
                                            {{$work['city_plain_text']}}@endif
                                    </p>


                                    <p><i class="prefix mdi-action-event"></i>
                                        {{ trans('profile.dal') }}
                                        <b>{{date('m/Y', strtotime($work['start_date']))}}
                                        </b>


                                        @if($work['end_date']!="2100-01-01")
                                            {{ trans('profile.al') }}
                                            <b>{{date('m/Y', strtotime($work['end_date']))}}
                                            </b>
                                        @else

                                            <b>{{ trans('profile.work_there') }}</b>
                                    @endif


                                </div>

                                <div class="col m12">
                                    <p>
                                        {{$work['comment']}}
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>


            <div class="form hide">
                <div class="col s12 m12 l12">
                    <div class="card  grey-meritocracy-user">
                        <form class="edit-work-experience form-edit"
                              data-id="{{$work['id']}}">

                            <input type="hidden" name="id_work_experience"
                                   value="{{$work['id']}}">
                            <div class="container">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-work active"></i>
                                        <input type="text" value="{{$work['role']}}"
                                               name="role" id="role_{{$key}}">
                                        <label class="active"
                                               for="role_{{$key}}">{{ trans('wizard-application.ruolo') }}</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-work"></i>
                                        <select required id="job_function_{{$key}}"
                                                name="job_function[id]">
                                            <option value="" disabled>{{ trans('profile.scegli_job') }}</option>
                                            @foreach($jobFunctions as $function)
                                                <option value="{{$function['id']}}"
                                                        @if($function['id']==$work['job_function']['id']) selected @endif>{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="job_function_{{$key}}">{{ trans('wizard-application.job_function') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-store prefix active"></i>
                                        <input type="text" id="azienda_{{$key}}"
                                               name="company_plain_text"
                                               value="{{$work['company_plain_text']}}">
                                        <label class="active"
                                               for="azienda_{{$key}}">{{ trans('wizard-application.nome_azienda') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-store prefix"></i>

                                        <select name="industry[id]" id="industry_{{$key}}">
                                            <option value="" disabled
                                            >{{ trans('profile.scegli_industry') }}</option>
                                            @foreach($industries as $function)
                                                <option value="{{$function['id']}}"
                                                        @if($function['id']==$work['industry']['id']) selected @endif>{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="industry_{{$key}}">{{ trans('wizard-application.industry') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-communication-location-on prefix active"></i>
                                        <input type="text" required=""
                                               value="{{$work['city_plain_text']}}"

                                               name="city_plain_text"
                                               id="luogo_lavoro_{{$key}}" autocomplete="off"
                                               aria-required="true">
                                        <label class="active"
                                               for="luogo_lavoro_{{$key}}">{{ trans('wizard-application.luogo_lavoro') }}</label>

                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix active"></i>
                                        <label class="active"
                                               for="data_inizio_{{$key}}">{{ trans('wizard-application.data_inizio') }}</label>
                                        <input onkeydown="return false" aria-required="true"
                                               type="text"
                                               name="start_date"
                                               value="{{date('m/Y', strtotime($work['start_date']))}}"
                                               id="data_inizio_{{$key}}"
                                               class="datepicker required" required>

                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix active"></i>
                                        <label class="active"
                                               for="data_fine_{{$key}}">{{ trans('wizard-application.data_fine') }}</label>
                                        <input onkeydown="return false" aria-required="true"
                                               type="text"
                                               name="end_date"
                                               value="{{date('m/Y', strtotime($work['end_date']))}}"
                                               id="data_fine_{{$key}}"
                                               class="datepicker required"
                                               @if($work['is_current']) disabled @endif >

                                    </div>
                                    <div class="input-field col s6 m6">
                                        <input style="margin-left:-10px;margin-top:30px"
                                               type="checkbox" name="lavoro_attuale"
                                               id="lavoro_attuale_{{$key}}"
                                               @if($work['is_current']) checked @endif/>
                                        <label style="margin-left:-10px;margin-top:30px"
                                               class="active"
                                               for="lavoro_attuale_{{$key}}">{{ trans('wizard-application.attualmente_lavoro_qui') }}</label>

                                    </div>

                                    <div class="input-field col s12 m12">
                                        <i class="mdi-communication-comment  prefix active"></i>
                                                <textarea id="comment_2" name="comment"
                                                >{{$work['comment']}}</textarea>
                                        <label for="comment_2"
                                               class="active">{{ trans('wizard-application.raccontaci_esperienza') }}</label>
                                    </div>


                                    <div class="col s12 m12 right-align">

                                        <button name="action" type="submit"
                                                class="waves-effect waves-light btn edit-work-experience red">
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