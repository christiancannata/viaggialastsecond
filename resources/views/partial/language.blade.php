<li class="collection-item avatar">
    <a data-href="/elimina/language-user/{{$language['id']}}"
       data-method="GET" href="#"
       class="action-button btn-floating waves-effect waves-light close-small-button"><i
                class="mdi-content-clear"></i></a>
    <i class="mdi-action-language circle"></i>
                            <span class="title" style="width:100%">
                                @if(isset($language['system_language']['italian_name']) && App::getLocale()=="it")
                                    {{$language['system_language']['italian_name']}}
                                @else
                                    {{$language['system_language']['name']}}
                                @endif
                            </span>
    <p>
    <div class="language-detail">
        <span class="ultra-small">{{ trans('profile.lettura') }}<br></span><br>
        {{--*/ $stelleCount=5 /*--}}
        @for($i=1;$i<=$language['grade_read'];$i++)
            <i class="fa fa-star"></i>
            {{--*/ $stelleCount-=1 /*--}}
        @endfor
        @for($i=1;$i<=$stelleCount;$i++)
            <i class="fa fa-star-o"></i>
        @endfor
    </div>
    <div class="language-detail">
        <span class="ultra-small">{{ trans('profile.scrittura') }}<br></span><br>
        {{--*/ $stelleCount=5 /*--}}
        @for($i=1;$i<=$language['grade_write'];$i++)
            <i class="fa fa-star"></i>
            {{--*/ $stelleCount-=1 /*--}}
        @endfor
        @for($i=1;$i<=$stelleCount;$i++)
            <i class="fa fa-star-o"></i>
        @endfor
    </div>
    <div class="language-detail">
        <span class="ultra-small">{{ trans('profile.dialogo') }}<br></span><br>
        {{--*/ $stelleCount=5 /*--}}
        @for($i=1;$i<=$language['grade_speak'];$i++)
            <i class="fa fa-star"></i>
            {{--*/ $stelleCount-=1 /*--}}
        @endfor
        @for($i=1;$i<=$stelleCount;$i++)
            <i class="fa fa-star-o"></i>
        @endfor
    </div>
    </p>
</li>