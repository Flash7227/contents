@extends('layouts.app')
@section('content')
 <div class="container">
    <h5 class="text-center" style="font-weight: bold; font-size: 45px; padding-top: 80px">{{$blog->name}}</h5>
    <div class="text-center">
        <a class="breadcrumb-item" href="/home">Нүүр</a>
        <a disable > > </a>
        <a class="breadcrumb-item" href="/home/blog">Блог</a>
    </div>
    <p class="text-center" style="color: #25d56f; font-size: 15px; padding-top: 10px; margin-bottom: 5rem">{{$blog->created_at}}</p>

    @if($blog->url =='noimage123.png')         
    
    @else
        <div >
         <img src="{{ asset('storage/uploads/'.$blog->url) }}" width="100%"  height="100%" alt="">
        </div>       
    @endif
     
    <div width="100%"  height="100%">
        {!!$blog->desc!!}
    </div>
</div>
@endsection