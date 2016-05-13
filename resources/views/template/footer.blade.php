<div class="container-fluid footer hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col col-md-2 col-xs-16">
                <div class="footer-block-meritocracy-logo">
                    <img class="footer-menu-meritocracy-logo-image" src="/img/logos/black-logo.png">
                </div>

            </div>
            <div class="col col-md-4 ">
                <ul class="footer-menu">
                    <li><a href="/">Home</a></li>


                    <li><a href="/manifesto">{{ trans('common.manifesto_button') }}</a></li>
                    <li><a href="/jobs">{{ trans('common.browse_job_button') }}</a></li>
                    <li><a href="/technology">{{ trans('common.tech_button') }}</a></li>
                    <li><a href="/company">{{ trans('common.are_you_company_button') }}</a></li>
                    <li><a href="/{{App::getLocale()}}/privacy">Privacy Policy</a></li>
                    <li><a href="/{{App::getLocale()}}/cookies">Cookie Policy</a></li>
                    <li><a href="/{{App::getLocale()}}/tos">{{ trans('common.termini_servizio') }}</a></li>
                    <li><a href="http://blog.meritocracy.is/" target="_blank">Blog</a></li>

                </ul>
            </div>
            <div class="col col-md-6">
                <ul class="soc">
                    <li><a target="_blank" class="soc-linkedin"
                           href="https://www.linkedin.com/company/meritocracy_is"></a></li>
                    <li><a target="_blank" class="soc-facebook" href="https://www.facebook.com/meritocracy.is"></a></li>
                    <li><a target="_blank" class="soc-instagram" href="http://instagram.com/meritocracy.is"></a></li>
                    <li><a target="_blank" class="soc-twitter" href="https://twitter.com/Meritocracy_is"></a></li>

                </ul>
                <a href="https://heapanalytics.com/?utm_source=badge"><img
                            style="margin-top: 15px; width:108px;height:41px"
                            src="//heapanalytics.com/img/badgeLight.png" alt="Heap | Mobile and Web Analytics"/></a>

            </div>
            <div class="col col-md-4 col-xs-8">
                <address>
                    <strong>Meritocracy UK - Coverclip s.r.l</strong><br>

                    1 Fore St<br>
                    London EC2Y 5EJ, UK<br>
                    <i class="fa fa-phone"></i> +44 (0)20 3575 1161<br>
                    <a href="mailto:#">info@meritocracy.is</a>
                </address>

                <address>
                    <strong>Meritocracy IT - Coverclip s.r.l</strong><br>
                    Via Euripide 11<br>
                    20145 Milano, Italia<br>
                    P. IVA / C.F. n. 08450800969<br>
                    <i class="fa fa-phone"></i> +39 0284132619<br>
                    <a href="mailto:#">info@meritocracy.is</a>
                </address>
            </div>

            <div class="col col-md-16 col-xs-16 hide">
                <div class="header-menu-meritocracy-logo">
                    <img src="/img/logos/white-full-logo.png">

                </div>
            </div>
        </div>


    </div>
</div>

<div class="container-fluid footer hidden-md hidden-lg">
    <div class="container">
        <div class="row">
            <div class="col col-md-2">
                <div class="footer-mobile-block-meritocracy-logo ">
                    <img class="footer-mobile-menu-meritocracy-logo-image" src="/img/logos/black-logo.png">
                </div>
            </div>
            <div class="col col-md-6">
                <ul class="footer-menu">
                    <li><a href="/manifesto">{{ trans('common.manifesto_button') }}</a></li>
                    <li><a href="/jobs">{{ trans('common.browse_job_button') }}</a></li>
                    <li><a href="/technology">{{ trans('common.tech_button') }}</a></li>
                    <li><a href="/company">{{ trans('common.are_you_company_button') }}</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/cookies">Cookie Policy</a></li>
                    <li><a href="/tos">{{ trans('common.termini_servizio') }}</a></li>
                    <li><a href="http://blog.meritocracy.is/" target="_blank">Blog</a></li>
                </ul>
            </div>
            <div class="col col-md-3 social-box-mobile">
                <ul class="soc">
                    <li><a target="_blank" class="soc-linkedin" href="#"></a></li>
                    <li><a target="_blank" class="soc-facebook" href="#"></a></li>
                    <li><a target="_blank" class="soc-instagram" href="#"></a></li>
                    <li><a target="_blank" class="soc-twitter" href="#"></a></li>
                    <li><a target="_blank" class="soc-google soc-icon-last" href="#"></a></li>
                </ul>
            </div>
            <div class="col col-md-5">
                <div class="row">
                    <div class="col col-md 16 col-xs-16 text-center">
                        <h4 style="margin-top:20px;" class="text-uppercase">{{trans('common.contact_us_button')}}</h4>
                    </div>
                    <div class="col col-md 16 col-xs-8">
                        <address>
                            <strong>Meritocracy UK</strong><br>
                            22 Upper Ground<br>
                            SE1 9PD London, UK<br>
                            <abbr title="Phone">P:</abbr> +44 (0)20 3575 1161<br>
                            <a href="mailto:#">info@meritocracy.is</a>
                        </address>
                    </div>
                    <div class="col col-md 16 col-xs-8">
                        <address>
                            <strong>Meritocracy IT</strong><br>
                            Via Euripide 11<br>
                            20145 Milano, Italia<br>
                            <abbr title="Phone">P:</abbr> +39 0284132619<br>
                            <a href="mailto:#">info@meritocracy.is</a>
                        </address>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<div class="container-fluid footer" style="padding-bottom: 20px;">
    <div class="container">
        <div class="row">
            <div class="col col-md-12">
                <a target="_blank" href="https://app.meritocracy.is/terms.php"
                   style="color:white;font-size: 12px;">{{trans('common.istituzionali')}}</a>
            </div>
            <div class="col col-md-3">
                @if(App::getLocale() != "en")
                    <a data-original-locale="it" data-locale="en" onclick="changeLocale(this)" href="javascript:;"><span
                                style="font-size: 20px;" class="flag flag-icon flag-icon-gb"></span>&nbsp;&nbsp;English</a>
                @else
                    <a data-original-locale="en" data-locale="it" onclick="changeLocale(this)" href="javascript:;"><span
                                style="font-size: 20px;" class="flag flag-icon flag-icon-it"></span>&nbsp;&nbsp;Italiano</a>
                @endif
            </div>

        </div>

    </div>
</div>
@if(Auth::check())
    <input type="hidden" id="input-logged" value="1">
@endif
<div id="profiles"></div>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.fullpage.min.js"></script>
@yield('pre-page-scripts')
<script type="text/javascript" src="/js/social-share.js"></script>
<script type="text/javascript" src="/js/modernizr.js"></script>
<script type="text/javascript" src="/js/jsonGenerator.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="//platform.twitter.com/oct.js"></script>
<script type="text/javascript" src="/js/bcMobile.js"></script>
<script type="text/javascript" src="/js/utils/timezone.js"></script>
<script type="text/javascript" src="/js/strength.min.js"></script>
<script type="text/javascript" src="/js/spin.min.js"></script>
<script type="text/javascript" src="{{auto_version("/js/meritocracy-framework.js")}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{{auto_version("/js/main.js")}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<noscript>
    <img height="1" width="1" style="display:none;" alt=""
         src="https://analytics.twitter.com/i/adsct?txn_id=nubr9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
    <img height="1" width="1" style="display:none;" alt=""
         src="//t.co/i/adsct?txn_id=nubr9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
    <img height="1" width="1" style="display:none;" alt=""
         src="https://analytics.twitter.com/i/adsct?txn_id=ntwyc&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
    <img height="1" width="1" style="display:none;" alt=""
         src="//t.co/i/adsct?txn_id=ntwyc&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
</noscript>

@yield('page-scripts')
<script>

    try {
        var tz = jstz.determine(); document.cookie = "timezone=" + tz.name();
    } catch (ee) {}


</script>



@if($route!="wizard-application")
    <script src="https://cdn.ravenjs.com/3.0.3/console/raven.min.js"></script>
    <script language="javascript">
        if (!$('html').is('.lt-ie7, .lt-ie8, .lt-ie9')) {
            /*** Raven for Javascript Exception Handlers ***/
            Raven.config('https://3c874071c7ca47bbb5767984f485cb7c@app.getsentry.com/43384', {
                release:  '<?php echo gitVersion() ?>',
                fetchContext: true,
                includePaths: [/https?:\/\/meritocracy\.is/, /http?:\/\/beta\.meritocracy\.is/]

            }).install();

            Raven.setUserContext({
                email: '{{Auth::check() && Auth::user()->email or "" }}',
                id: '{{Auth::check() && Auth::user()->id or "" }}'
            });

        } else {
            alert("Your browser is out-of-date and your experience with Meritocracy may be slower or unexpected");
        }


    </script>
    @endif

<input value="<?php if(\Illuminate\Support\Facades\Input::get("redirectLink")){ ?>{{\Illuminate\Support\Facades\Input::get("redirectLink")}}<?php } ?>" type="hidden" id="redirectLogin">

<div id="fb-root"></div>
<script type="text/javascript" src="//api.filestackapi.com/filestack.js"></script>
</body>
</html>
