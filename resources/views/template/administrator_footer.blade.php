<!-- //////////////////////////////////////////////////////////////////////////// -->
<input id="userId" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
<input id="userType" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->type}}">

<!-- START FOOTER -->
<footer class="page-footer hide">

    <div class="footer-copyright">
        <div class="container">
            Copyright © 2016 <a class="grey-text text-lighten-4"
                                href="https://meritocracy.is" target="_blank">Meritocracy</a>
            All rights reserved.

        </div>
    </div>
</footer>
<!-- END FOOTER -->


<!-- ================================================
Scripts
================================================ -->



<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!--materialize js-->
<script type="text/javascript" src="/admin/js/materialize.js"></script>

<script type="text/javascript" src="/admin/js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- chartist -->
<script type="text/javascript" src="/admin/js/plugins/chartist-js/chartist.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="/admin/js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="/admin/js/custom-script.js"></script>

<script type="text/javascript" src="/admin/js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript"
        src="//api.filepicker.io/v2/filepicker.js"></script>
<script type="text/javascript" src="/js/jquery-te-1.4.0.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#search").autocomplete({
            source: "/hr/search-candidates/all/all" ,
            minLength: 3,
            select: function (event, ui) {


                return false;
            },
            messages: {
                noResults: '',
                results: function () {
                }
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {

            if (typeof item.user.avatar == "undefined" || item.user.avatar == "") {
                item.user.avatar = "https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif";
            }
            var role = "";

            if (typeof item.user.work_experiences !== "undefined" && item.user.work_experiences.length > 0) {
                var works = item.user.work_experiences;
                var lastWorkExperience = works[works.length - 1];

            }

            if (typeof lastWorkExperience !== "undefined" && lastWorkExperience.role != "" && lastWorkExperience.company_plain_text != "") {
                role = lastWorkExperience.role + " at " + lastWorkExperience.company_plain_text;
            }

            var permalink = "/hr/" + item.vacancy.permalink + "?__d=" + window.btoa(item.id + "|" + item.status);


            return $("<li>")
                    .append("<a href='" + permalink + "' ><div class='row result-search'><div class='col m1'><img src='" + item.user.avatar + "' class='circle responsive-img valign profile-image'></div><div class='col m11'><div class='row' style='margin-bottom:0px'><div class='col m12'><h5><strong>" + item.user.first_name + " " + item.user.last_name + "</strong></h5><h6>" + role + "</h6><h4>Applied for <strong>" + item.vacancy.name + "</strong></h4></div></div></div></div></a>")
                    .appendTo(ul);
        };
    });
</script>


<script src="//www.paypalobjects.com/api/checkout.js"></script>

@yield('page-scripts')