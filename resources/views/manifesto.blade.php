@extends('template.layout')

@yield('header')



@section('content')


    @include('template.sticky-menu')




    <div class="container-fluid jobs-container company-container" style="padding-bottom: 20px;">

        <div class="container padded">

            <div class="row">
                <div class="col col-md-4"><p class="red-label" data-translate="">{{ trans($route.'.title_text_2') }}</p>
                </div>
                <div class="col col-md-offset-2 col-md-7"><p class="grey-label" data-translate="">
                        {!! trans($route.'.subtitle_text_2') !!}   </p></div>
            </div>

            <div class="row">
                <div class="col col-md-offset-6 col-md-7"><p class="grey-label" data-translate="">
                        {!! trans($route.'.subtitle_text_3') !!}   </p></div>
            </div>

            <div class="row">
                <div class="col col-md-offset-6 col-md-7"><p class="grey-label" data-translate="">
                        {!! trans($route.'.subtitle_text_4') !!}   </p></div>
                <div id="sticky-anchor"></div>
            </div>

            <div class="row">
                <div class="col col-md-4"><p class="red-label" data-translate="">{{ trans($route.'.title_text_3') }}</p>
                </div>
                <div id="scroll-anchor"></div>
            </div>
            <div class="row">
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Francesco_Castaldo.jpg" class="image">

                        <p class="name">Francesco Castaldo</p>

                        <p class="role">Research Scientist</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/francesco-castaldo-b1222428/en" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Cristian_Cannata.jpg" class="image">

                        <p class="name">Christian Cannata</p>

                        <p class="role">Web Developer</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/christian-cannata-50484044/en" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Riccardo_Galli.jpg" class="image">

                        <p class="name">Riccardo Galli</p>

                        <p class="role">Co-Founder</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/riccardo-galli-9733b050" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Alberto_Manassero.jpg" class="image">


                        <p class="name">Alberto Manassero</p>

                        <p class="role">Co-Founder</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/manasseroalberto/en" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Chiara_Motta.jpg" class="image">

                        <p class="name">Chiara Motta</p>

                        <p class="role">Growth Manager UK</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/cmotta" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Pierpaolo_Rizzo.jpg" class="image">

                        <p class="name">Pierpaolo Rizzo</p>

                        <p class="role">Digital Specialist</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/pierpaolorizzo85" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Lorenzo_Saraniti.jpg" class="image">

                        <p class="name">Lorenzo Saraniti</p>

                        <p class="role">CTO</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/lorenzosaraniti/en" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Riccardo_Serafini.jpg" class="image">

                        <p class="name">Riccardo Serafini</p>

                        <p class="role">Account Marketing Manager</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/riccardo-serafini-b7148876" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Eliana_Tettamanti.jpg" class="image">

                        <p class="name">Eliana Tettamanti</p>

                        <p class="role">Growth Manager Italy</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/eliana-tettamanti-47684945" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-8 col-xs-8">
                    <div class="profile">
                        <img src="/img/team/Alessandro_Treves.jpg" class="image">

                        <p class="name">Alessandro Treves</p>

                        <p class="role">Visual Director</p>

                        <div class="social">
                            <ul class="soc">
                                <li><a class="soc-linkedin" href="https://www.linkedin.com/in/sandrotreves/en" target="_blank"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <div class="container-fluid testimonials-container hide">
        <div class="container">
            <div class="row">
                <div class="col col-md-16">
                    <div class="testimonials">
                        <h5>Testimonials</h5>

                        <p class="testimonials-label">
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi rhoncus nibh eget sem
                            venenatis venenatis. Nullam sed eros vel justo elementum blandit."
                        </p>

                        <p class="author">Mario Rossi - Manager Director for Samsung</p>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="container-fluid slideshow-container hide">
        <div class="container">
            <div class="row">
                <div class="col col-md-16">
                    <div class="slideshow">

                        <div id="myCarousel" class="carousel slide" data-ride="carousel">


                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <img src="/img/freccia_sx.png">

                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <img src="/img/freccia_dx.png">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    </div>
    @include('jolly')
@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/pages/homepage.js"></script>
    <script>Homepage.init();</script>
@endsection