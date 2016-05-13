@foreach($benefits as $benefit)
<div id="benefit-{{$benefit["id"]}}" class="col m3 l3 s3 ">
    <div class="profile card">
        <div class="card-content">
            <div class="card-description">
                <img style="max-width: 50px; max-height: 30px; float:left; margin-right: 10px;"
                     src="/img/{{$benefit["icon"]}}" class="responsive-img">
                <span class="truncate" style="font-size: 14px;">{{$benefit["name"]}}</span>
            </div>

        </div>
        <div style="padding: 0 0 10px 20px;" class="card-action">
            <a data-type="benefit" data-remove="benefit-{{$benefit["id"]}}" style="position: relative;margin-top:20px"
               data-href="/hr/benefits/remove/{{$benefit['id']}}/{{$company["id"]}}"
               data-method="GET" href="#"
               class="action-button btn red waves-effect waves-light "><i
                        class="mdi-content-clear"></i></a>

        </div>


    </div>
</div>
@endforeach
