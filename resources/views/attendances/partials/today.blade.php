@foreach ($shops as $shop)
    

<span class="mb-2 badge badge-{{$colord[$shop->id]}}">{{$shop->id}}-{{$names[$shop->id]}} - ({{$count_presenttoday[$shop->id]}}/{{$count_TT[$shop->id]}})
<i class="mdi mdi-{{$confirmedtoday[$shop->id]}} font-14"></i></span>
@endforeach