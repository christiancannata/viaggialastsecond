@extends('template.layout_registration')



<style>
    [type="checkbox"] + label{
        margin-left: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>
@section('content')

    <input id="userId" type="hidden" value="">

    <div style="width:100%;padding-top:100px;padding-bottom:100px;" class="center loader hide">
        <h5 style="margin-bottom: 40px;display: none;" class="please-wait-text ">{{trans('common.please_wait_reg')}}</h5>
        <div class="preloader-wrapper big active center">
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

        </div>
    </div>



    <form method="post" accept-charset="UTF-8" action="" id="new_user"
          class="simple_form simple-form new_user">

        <div class="row">
            <div class="col s12 center">
                <h5>{{trans('register-company.title_step_1')}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 center">
                <a href="#" class="btn btn--full btn--linkedin mbm btn-large"
                   id="linkedin-signin"><i class="fa fa-linkedin left"></i><span> {{trans('register-company.login_con')}}
                        LinkedIn</span>
                </a>
            </div>
        </div>
        <div class="row margin">
            <div class="col s12 center">
                <span>{{trans('register-company.oppure')}}</span>
            </div>
        </div>
        <div class="row">
            <div class="card red lighten-5 response hide" id="card-alert">
                <div class="card-content red-text">
                    <p></p>
                </div>
                <button aria-label="Close" data-dismiss="alert" class="close red-text" type="button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s6 m6">
                <i class="mdi-action-account-box prefix"></i>
                <input id="first_name" name="first_name" type="text" required>
                <label for="first_name" class="center-align">{{trans('register-company.first_name')}}</label>
            </div>
            <div class="input-field col s6 m6">
                <input id="last_name" name="last_name" type="text" required>
                <label for="last_name" class="center-align">{{trans('register-company.last_name')}}</label>
            </div>
        </div>

        <div class="row margin">
            <div class="input-field col s12 m12">
                <i class="mdi-social-domain  prefix"></i>
                <input id="name" name="name" type="text" required>
                <label for="name" class="center-align">{{trans('register-company.company_name')}}</label>
            </div>

        </div>

        <div class="row margin">
            <div class="input-field col s12" style="margin-top:20px">
                <i class="mdi-communication-phone prefix"></i>
                <input id="mobile" name="mobile" type="text" required>
                <label for="mobile">{{trans('register-company.telefono')}}</label>
            </div>
        </div>

        <div class="row margin">
            <div class="input-field col s12">
                <i class="mdi-content-mail  prefix"></i>
                <input id="email" name="email" type="email" required>
                <label for="email">{{trans('register-company.email')}}</label>
            </div>
        </div>

        <div class="row margin">
            <div class="input-field col s12">
                <i class="mdi-action-lock prefix"></i>
                <input id="password" name="password" type="password" required>
                <label for="password">Password</label>
            </div>
        </div>

        <div class="row margin">
            <div class="col s12">

                <p>
                    <input class="filled-in" type="checkbox" id="condizioni" required/>
                    <label for="condizioni">
                        {!!  trans('common.condizioni') !!}
                    </label>
                </p>
                <p style="display: none;">Condizioni obbligatorie</p>
            </div>
        </div>

        <div class="row margin">
            <div class="input-field col s12">
                <button id="login-btn-form" type="submit"
                        class="btn waves-effect waves-light col s12 red btn-large">{{trans('register-company.continua')}}
                </button>
            </div>

        </div>
        <input type="hidden" id="linkedin_id" name="linkedin_id">

        <input type="hidden" id="avatar" name="avatar">
    </form>




    <form method="post" accept-charset="UTF-8" action="" id="new_company" style="display:none; padding-top: 15px;"
          class="simple_form simple-form new_user">

        <input type="hidden" id="company_id">
        <input type="hidden" value="" name="website" id="website">

        <div class="row">
            <div class="col s12 center">
                <h5>{{trans('register-company.title_step_2')}}</h5>
            </div>
        </div>



        <div class="row margin">

            <div class="col s12">
                <label lang="en">Industry</label>
                <select id="industry" name="industry[id]"
                        class="select2-industries">
                    <option value="" disabled selected>{{trans('register-company.scegli_opzione')}}</option>
                    @foreach($industries as $industry)
                        <option value="{{$industry['id']}}">{{$industry['name']}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="row margin">
            <div class="input-field col s12">
                <input type="hidden" name="city[id]" id="work_city_id">
                <input id="luogo_lavoro" name="city_plain_text" type="text"
                       class="required validate" required>
                <label for="luogo_lavoro">{{trans('register-company.city')}}</label>
            </div>
        </div>


        <div class="row margin">
            <p>
                <input type="checkbox" name="assistenza_gratuita" id="assistenza_gratuita"/>
                <label for="assistenza_gratuita">{{ trans('register-company.assistenza_gratuita') }}</label>
            </p>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <button id="login-btn-form" type="submit"
                        class="btn waves-effect waves-light col s12 red">{{trans('register-company.continua2')}}
                </button>
            </div>

        </div>
            <div class="card red lighten-5 response hide row" id="card-alert">
                <div class="card-content red-text">
                    <p></p>
                </div>
                <button aria-label="Close" data-dismiss="alert" class="close red-text" type="button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
    </form>


    @endsection


    @section('page-scripts')

            <!-- Custom Audience Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq)return;
            n = f.fbq = function () {
                n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq)f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
                document, 'script', '//connect.facebook.net/en_US/fbevents.js');
    </script>


    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/pages/registration-page.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <script>
        Registration.init();
    </script>



    <!-- 1. Include the LinkedIn JavaScript API and define a onLoad callback function -->



@endsection