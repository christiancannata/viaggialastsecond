<div class="col m3 sortable ">
    <a style="position: relative;margin-top:20px" data-href="/elimina/slider/{{$slide['id']}}"
       data-method="GET" href="#"
       class="action-button btn-floating waves-effect waves-light close-small-button"><i
                class="mdi-content-clear"></i></a>
    <input type="hidden" name="id[]" value="{{$slide['id']}}">
    <input class="order" type="hidden" name="order[]" value="{{$slide['ordering']}}">
    <img src="{{$slide['link']}}" width="100%">
</div>