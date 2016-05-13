<!-- //////////////////////////////////////////////////////////////////////////// -->
@if(Auth::check())
    <input id="userId" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
    <input id="firstName" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->first_name}}">
    <input id="lastName" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->last_name}}">
    @endif
            <!-- START FOOTER -->
    <footer class="page-footer">


    </footer>
    <!-- END FOOTER -->


    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script>$.fn.poshytip={defaults:null};</script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

    <!--materialize js-->
    <script src="https://cdn.jsdelivr.net/momentjs/2.11.1/moment-with-locales.js"></script>

    <script type="text/javascript" src="/admin/js/materialize.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="/admin/js/tipped.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/chartist-js/chartist.min.js"></script>

    <script src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/js/MonthPicker.min.js" type="text/javascript"></script>


    <!-- sparkline -->
    <script type="text/javascript" src="/admin/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/sparkline/sparkline-script.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/sweetalert/dist/sweetalert.min.js"></script>

    <!-- data-tables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/data-tables/data-tables-script.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.1.1/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script>





    <!-- google map api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>


    <script src="/js/MonthPicker.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/admin/js/plugins.js"></script>
    <script type="text/javascript" src="/js/strength.min.js"></script>
    <script type="text/javascript" src="/js/jquery.barrating.min.js"></script>
    <script type="text/javascript" src="//api.filepicker.io/v2/filepicker.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdn.ravenjs.com/3.0.3/console/raven.min.js"></script>
    <script type="text/javascript" src="{{auto_version("/js/meritocracy-framework.js")}}"></script>

    <script>

        $(document).ready(function(){
           Meritocracy.init();
        });

        var OneSignal = OneSignal || [];

        OneSignal.push(["init", {
            // Your other init options here
            promptOptions: {
                showCredit: false, // Hide Powered by OneSignal
                actionMessage: trans('notif_title'),
                exampleNotificationTitleDesktop: trans('notif_title_2'),
                exampleNotificationMessageDesktop: trans('notif_desktop'),
                exampleNotificationTitleMobile: trans('notif_title_2'),
                exampleNotificationMessageMobile: trans('notif_mobile'),
                exampleNotificationCaption: trans('notif_unsub'),
                acceptButtonText: trans('continua').toUpperCase(),
                cancelButtonText: trans('cancella').toUpperCase()
            },
            welcomeNotification: {
                disable: true
            },
            path: "/",
            appId: "464434c7-dadc-4edb-8a80-fb73dcb5040d",
            safari_web_id: "web.onesignal.auto.650c091f-37ea-4fe0-8793-2961481353d2",
            autoRegister: false
        }]);

        if (!$('html').is('.lt-ie7, .lt-ie8, .lt-ie9')) {
            /*** Raven for Javascript Exception Handlers ***/
            Raven.config('https://3c874071c7ca47bbb5767984f485cb7c@app.getsentry.com/43384', {
                release: '3.2.1',
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
    @yield('custom-js')




