<section id="content">

    <!--start container-->
    <div class="container">

        <!--card stats start-->
        <div id="card-stats">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h4>{{$company}}</h4>
                </div>

                @if($cached)
                    <div class="col s12 m12 l12">
                        <div class="card orange lighten-5" id="card-alert">
                            <div class="card-content orange-text text-left">
                                <p style="text-align:left !important;"><strong>ATTENZIONE : Ultimo aggiornamento Dati
                                        il {{$cached}}.</strong> Prossimo aggiornamento dati: <?php
                                    $prossimoAggiornamento = new \DateTime($cached);
                                    $prossimoAggiornamento->add(new \DateInterval("PT3H"));
                                    echo $prossimoAggiornamento->format("d-m-Y H:i");
                                    ?>

                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content  green white-text">
                            <p class="card-stats-title"><i class="mdi-social-group-add"></i> Candidature <br>

                                Dal {{$dal}} al {{$al}}
                            </p>
                            <h4 class="card-stats-number">{{$trendApplicationPeriod2}}</h4>
                            <p class="card-stats-compare">
                              <!--  @if($trendApplicationPercentage>0)
                                    <i class="mdi-hardware-keyboard-arrow-up"></i>
                                @else
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                @endif
                                @if($trendApplicationPercentage!="-")
                                    {{number_format($trendApplicationPercentage,2)}}% <span
                                            class="green-text text-lighten-5"><br>@if($dal && $al)
                                        @else
                                        @endif
                                        @endif --></span>
                            </p>
                        </div>
                        <div class="card-action  green darken-2">
                            <?php $visitsArray = ""; ?>
                            <?php if(count($applications)<=2){ ?>
                            Grafico non disponibile
                            <?php }else{ ?>
                            @foreach($applications as $key=>$visit)<?php $visitsArray .= $visit['applications']; ?>@if($key<count($applications)-1)<?php $visitsArray .= ","; ?>@endif @endforeach
                            <?php } ?>
                            <div class="center-align sparklines" values="{{$visitsArray}}"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content pink lighten-1 white-text">
                            <p class="card-stats-title"><i class="mdi-editor-insert-chart "></i>
                                Visite<br>Dal {{$dal}} al {{$al}}</p>
                            <h4 class="card-stats-number">{{$trendVisitsPeriod2}}</h4>
                            <p class="card-stats-compare">
                              <!--  @if($trendVisitsPercentage>0)
                                    <i class="mdi-hardware-keyboard-arrow-up"></i>
                                @else
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                @endif
                                {{number_format($trendVisitsPercentage,2)}}% <span
                                        class="deep-purple-text text-lighten-5"><br>@if($dal && $al)
                                    @else

                                    @endif --></span>
                            </p>
                        </div>
                        <div class="card-action  pink darken-2">
                            <?php $visitsArray = ""; ?>

                            @foreach($visits as $key=>$visit)<?php $visitsArray .= $visit['pageView']; ?>@if($key<count($visits)-1)<?php $visitsArray .= ","; ?>@endif @endforeach

                            <div class="center-align sparklines" values="{{$visitsArray}}"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content blue-grey white-text">
                            <p class="card-stats-title"><i class="mdi-social-school "></i> Qualità
                                candidati<br>Dal {{$dal}} al {{$al}}</p>
                            <h4 class="card-stats-number">{{number_format($punteggioMedio,2)}} pt.</h4>
                            <p class="card-stats-compare">
                              <!--  @if($trendScorePercentage>0)
                                    <i class="mdi-hardware-keyboard-arrow-up"></i>
                                @else
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                @endif
                                {{number_format($trendScorePercentage,2)}}%<span
                                        class="blue-grey-text text-lighten-5"><br>@if($dal && $al)

                                    @else

                                    @endif --></span>
                            </p>
                        </div>
                        <div class="card-action blue-grey darken-2">
                            <?php $visitsArray = ""; ?>
                            @if(count($scores)<=2)
                                Grafico non disponibile @else
                            @foreach($scores as $key=>$visit)<?php $visitsArray .= number_format($visit['height_stats']['avg'], 2); ?>@if($key<count($scores)-1)<?php $visitsArray .= ","; ?>@endif @endforeach

                                <div class="center-align sparklines" values="{{$visitsArray}}"></div>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3 center">
                    <h6>Referral Candidature</h6>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <canvas class="doughnut-chart-sample"></canvas>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row ">
                <div class="col s12 m6 l3 center">
                    <h6>Sorgenti di traffico<br>@if($dal && $al)
                           {{$totalPageView}} visite dal {{$dal}} al {{$al}})
                        @else
                        {{$totalPageView}} visite
                        @endif </h6>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <canvas data="{{json_encode($tortaReferralPageView)}}" class="pageView-Referral"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col s12 m6 l3 hide">
                    <div class="card">
                        <div class="card-content pink lighten-1 white-text">
                            <p class="card-stats-title"><i class="mdi-editor-insert-chart "></i>Totale Candidature</p>
                            <h4 class="card-stats-number">{{$countTotalApplications}}</h4>

                        </div>
                        <div class="card-action  pink darken-2 white-text text-center center">

                            @if(isset($applicationsTotal[0]))
                                <?php
                                ?>
                                Dal {{$dal}} al {{$al}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3 center">
                    <h6>Referral Candidature Like ({{$totalLiked}})</h6>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <canvas data="{{json_encode($arrayReferralsStarred)}}" class="torta"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3 center">
                    <h6>Referral Candidature Dislike ({{$totalDisliked}})</h6>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <canvas data="{{json_encode($arrayReferralsRejected)}}" class="torta"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($vacancies as $vacancy)
                <div class="row z-depth-1" style="margin-top: 20px">
                    <div class="col m12 s12 l12"><h6><strong>{{$vacancy['vacancy']['name']}}</strong></h6></div>
                    <div class="col s12 m6 l3  text-center center">
                        <p>Sorgenti di traffico<br>

                            (dal {{$dal}} al {{$al}} {{$vacancy['sorgenti']['total']}} visite)

                        </p>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <canvas data="{{json_encode($vacancy['sorgenti']['arrayReferrals'])}}"
                                        class="pageView-Referral"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col s12 m6 l3  text-center center">
                        <p>Referral Candidature Like ({{$vacancy['statisticheStarred']['total']}})</p>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <canvas data="{{json_encode($vacancy['statisticheStarred']['arrayReferrals'])}}"
                                        class="torta"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3  text-center center">
                        <p>Referral Candidature Dislike ({{$vacancy['statisticheRejected']['total']}})</p>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <canvas data="{{json_encode($vacancy['statisticheRejected']['arrayReferrals'])}}"
                                        class="torta"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6 l3">
                        <div class="card">
                            <div class="card-content pink lighten-1 white-text">
                                <p class="card-stats-title"><i class="mdi-editor-insert-chart "></i>Candidature<br> dal {{$dal}} al {{$al}}
                                </p>
                                <h4 class="card-stats-number">{{$vacancy['applicationsTotalVacancy']['total']}}</h4>

                            </div>
                            <div class="card-action  pink darken-2 white-text text-center center">

                            </div>
                        </div>
                    </div>


                </div>
            @endforeach
        </div>
        <!--card stats end-->

        <!--end container-->
    </div>
</section>
