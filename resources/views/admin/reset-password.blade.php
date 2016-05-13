<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description"
          content="{{$description}}">
   <title>{{$title}} | Meritocracy</title>

    <!-- Favicons-->
    <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->



    <!-- CORE CSS-->
    <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
    <link href="/admin/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">

    <!-- Custome CSS-->
    <link href="/admin/css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>

<body class="red">

<a href="/{{App::getLocale()}}/">
    <img src="/img/logos/white-full-logo.png" class=" responsive-img "></a>

<div id="login-page" class="row" style="min-width:0px; margin-top: 50px;">
    <div class="col s12 z-depth-2 card-panel">

        <form id="recover-password-form" method="post" data-action="recover-password" class="form-login login-form" action="/password/reset"
              accept-charset="UTF-8">
            <div class="row">
                <div class="input-field col s12 center">

                    <div style="height: 20px;" class="clear"></div>
                    <h6>Type your new password </h6>
                </div>
            </div>


            <input name="token" type="hidden" id="token" value="{{$token}}">

            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input id="password" name="password" type="password" required>
                    <label for="password">Password</label>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input id="password-r2" name="password-r2" type="password" required>
                    <label for="password-r2">Confirm your password</label>
                </div>
            </div>


            <div class="row">
                <div class="input-field col s12">
                    <button id="recover-password-btn" type="submit" class="btn waves-effect waves-light col s12 red">Change password</button>
                </div>
                <div class="col s12 error-login">

                </div>
            </div>



        </form>




    </div>
</div>


<!-- ================================================
  Scripts
  ================================================ -->

<!-- jQuery Library -->
<script type="text/javascript" src="/admin/js/plugins/jquery-1.11.2.min.js"></script>
<!-- jQuery Library -->
<!--materialize js-->


<!--materialize js-->
<script type="text/javascript" src="/admin/js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="/admin/js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/admin/js/plugins/sweetalert/dist/sweetalert.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="/admin/js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="/admin/js/custom-script.js"></script>
<script type="text/javascript" src="/admin/js/reset-password.js"></script>
<script>
    window.alert = function (message, title, type) {
        try {
            if (title != null && type != null) {
                swal({
                    title: title,
                    text: message,
                    type: type,
                    confirmButtonColor: "#F04D52",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                });
            } else {
                swal(message);
            }
        } catch (ee) {
            alert(message);
        }

    };

    $(document).ready(function (){

        $("#recover-password-form").submit(function (e) {
            var form = $(this);
            e.preventDefault();

            $("button").attr("disabled", true);

            $.ajax({
                type: "POST",
                url: "/password/reset",
                data: $(form).serializeArray(),
                success: function (data, textStatus, xhr) {
                    if (xhr.status == 201 || xhr.status == 204) {
                        swal({
                            title: "Password changed",
                            text: "Your password has been changed",
                            type: "info",
                            confirmButtonColor: "#F04D52",
                            confirmButtonText: "OK",
                            closeOnConfirm: true,
                            showCancelButton: true
                        }, function () {
                            window.location.href = "/user";
                        });
                    } else if (data.status == 401) {
                        alert(data.responseJSON.message,"Unable to reset password","error");
                    }
                },
                error: function (data, textStatus, xhr) {
                    $("button").attr("disabled", false);
                    if (data.status == 401) {
                        alert(data.responseJSON.message,"Unable to reset password","error");
                    }
                },
                dataType: "json"
            });
        });
    });
</script>


</body>
</html>