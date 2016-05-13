@extends('template.layout')

@yield('header')

<div class="slider-promotion-meritocracy">

    <div class="content content-center">

        <div class="">

            <!-- TITLE + LOGO !-->
            <div class="NotGeneric-Title text-center" style="font-size: 50px; line-height: 50px;">

                <img class="text-center logo" alt="Meritocracy Logo"
                     src="/meritocracy/assets/admin/layout/img/logo-white.png" width="219" height="219">

                <p lang="en">
                    Attract & hire the people you deserve</p>
            </div>

            <!-- SUBTITLE !-->
            <div class="NotGeneric-SubTitle"
                 style="z-index: 8; max-width: 850px; margin: 0 auto;">

                <p class="text-center" lang="en">Meritocracy is a digital Employer Branding platform that allows your company to attract, inspire and hire the people you truly deserve.</p>

                <p class="text-center" lang="en">Please leave us your contact and we will be in touch with you shortly.</p>
            </div>

            <!-- FORM CONTACT YOU !-->
            <div class="tp-caption form-contact  text-center rs-parallaxlevel-0"
                 style=" border-color:rgba(255, 255, 255, 0);border-style:none;">
                <form data-classMethod="hide" method="POST" id="contact-form" class="revtp-searchform row" action="">
                    <div class="col-md-12">
                        <input required lang="en" data-classAction="fadeOut" class="animated" type="text" value=""
                               name="name" id="name" placeholder="Name"/>

                        <div class="clearfix visible-xs"></div>
                        <input required lang="en" data-classAction="fadeOut" class="animated " type="text" value=""
                               name="company" id="company" placeholder="Company"/>

                        <div class="clearfix visible-xs"></div>
                        <input required lang="en" data-classAction="fadeOut" class="animated" type="text" value=""
                               name="phone" id="references" placeholder="Phone number or Email"/>

                        <div class="clearfix visible-xs"></div>
                        <input onclick="goog_report_conversion()" required="required" lang="en" data-classAction="fadeOut" class="contact-us-button meritocracy-color animated"
                               type="submit" id="contact-us" value="Tell Me More"/>

                    </div>

                </form>
                <div class="thank-you-message animated alert alert-info col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center"></div>
            </div>
            <div class="clearfix"></div>

            <!-- INFORMATION ABOUT MERITOCRACY & EMPLOYER BRANDING !-->
            <?php require_once(__DIR__ .'/../meritocracy/templates/promotional/circle-kpi-employer-branding.html') ?>


            <div class="clearfix"></div>

            <!-- CLIENTS THAT USES MERITOCRACY !-->
            <div class="content content-center logo-block last-div row" id="about">
                <div class="col-md-12">
                    <p style=" margin-bottom: 0.5%;" class="text-center logo-block-text" lang="en">
                        Trusted by
                    </p>
                    <a target="_blank" href="https://meritocracy.is/groupm">
                        <img alt="Logo of GroupM" src="/img/company_new_logos/groupm280-.png">
                    </a>
                    <a  target="_blank" href="https://meritocracy.is/cloetta">
                        <img alt="Logo of Cloetta" src="/img/company_new_logos/cloetta280.png">
                    </a>

                    <a  target="_blank" href="https://meritocracy.is/samsung">
                        <img alt="Logo of Samsung" src="/img/company_new_logos/samsung280.png">
                    </a>
                    <a  target="_blank" href="https://meritocracy.is/teslamotors">
                        <img alt="Logo of Tesla Motors" src="/img/company_new_logos/tesla280-.png">
                    </a>
                    <a  target="_blank" href="https://meritocracy.is/tetrapak">
                        <img alt="Logo of Tetrapak" src="/img/company_new_logos/tetra280-.png">
                    </a>

                    <a  target="_blank" href="https://meritocracy.is/uber">
                        <img alt="Logo of Uber " src="/img/company_new_logos/uber280.png">
                    </a>


                </div>
            </div>

            <!-- CONTENT END !-->

        </div>
    </div>
</div>




<?php
include_once __DIR__ .'/../meritocracy/templates/admin/footer-promotional.php';
?>
