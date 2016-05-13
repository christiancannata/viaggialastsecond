@extends('template.empty')

@yield('header')


@section('page-css')
    <link rel="stylesheet" href="/css/meritocracy-box.css?ver=1">

@endsection
@section('content')




    <div class="container-fluid widget-padding">
        <div class="col-md-16">
            <div style="height: 10px;" class="clearfix"></div>
        <div class="widget-title caption">
            <a target="_blank" class="caption-subject uppercase widget-title-vacancies">Companies</a>
        </div>

        <div class="vacancies-box" id="vacancies-box">
            @foreach($companies as $company)
                <div class="row vacancy-row">
                    <div class="col-md-12">
                        <div class="vacancy-parent-title col-md-9 col-sm-9 col-xs-9">
                            <a  href="https://meritocracy.is/{{$company["permalink"]}}?referrer={{$campaign or "iFrame%20Placement%20Day%20Parma%2004/2016"}}&amp;utm_source={{$campaign or ("iFrame%20Placement%20Day%20Parma%2004/2016")}}"
                                target="_blank" class="vacancy-title bold">
                                {{$company["name"]}}
                            </a>
                            <span class="vacancy-location">/ {{$company["city_plain_text"]}}</span>
                            <div id="{{$company["id"]}}" class="collapse vacancy-description margin-top-10">
                                <?php echo strip_tags($company['story'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a style="" data-toggle="collapse" data-target="#{{$company["id"]}}"
                               class="btn dark btn-md uppercase btn-vacancy-description">More</a>
                            <a  href="https://meritocracy.is/{{$company["permalink"]}}?referrer={{$campaign or "iFrame%20Placement%20Day%20Parma%2004/2016"}}&amp;utm_source={{$campaign or ("iFrame%20Placement%20Day%20Parma%2004/2016")}}"
                               target="_blank" class="btn uppercase red btn-md btn-vacancy-apply">Apply
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>

    </div>
        </div>


    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/spin.min.js"></script>

@endsection
