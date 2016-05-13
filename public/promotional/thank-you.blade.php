@extends('template.layout')

@yield('header')
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        /* bring your own prefixes */
        transform: translate(-50%, -50%);
    }
    .title{
        font-size: 40px; font-weight: 900;
    }
    .detail-error{
        font-size: 18px; font-weight: 200;
    }
    .clear-mobile{
        height: 100px;
    }
    @media all and (max-width:480px) {
        .custom-class { width: 100%; display:block; margin-bottom: 10px; }
        .title{
            font-size: 25px;
        }
        .detail-error{
            font-size: 15px; font-weight: 200;
        }
        .clear-mobile{
            height: 20px;
        }

    }
</style>
    <div style="font-size: 17px;" class="container centered">
        <div class="clear clear-mobile"></div>
        <div class="col-md-12 page-404">

            <div style="text-align: center !important" class="details">
                <h1 class="title" style="">Grazie per la richiesta</h1>
                <div class="text-align-center margin-top-20">
                    <p style="" class="detail-error">
                        <?= $_GET['msg'] ?>
                    </p>
                    <p>&nbsp;</p>

                    <button style="margin-right: 10px;" href="https://meritocracy.is" class="btn btn-lg custom-class meritocracy-color back">
                        Torna alla home</button>
                    <div class="clear visible-xs" ></div>

                    <div class="clear clear-mobile"></div>
                </div>
            </div>
        </div>

    </div>



<script>
    $(".container").css("background-color" , "white");
    $(document).ready(function () {
        $(".back").on("click",function(){
            window.history.back();
        });
        $(".page-footer").hide();
    });
   
</script>
<!-- BEGIN Tracking codes !-->
<!-- Google Code for Contatto-1 Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 939562273;
    var google_conversion_language = "it";
    var google_conversion_format = "1";
    var google_conversion_color = "cd534b";
    var google_conversion_label = "yJ09CNuFw2EQoaqCwAM";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/939562273/?label=yJ09CNuFw2EQoaqCwAM&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>


<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('nubr9', { tw_sale_amount: 0, tw_order_quantity: 1 });</script>
<noscript>
    <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nubr9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
    <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nubr9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->



<?php
include('../meritocracy/templates/admin/footer.php');

?>
