@extends('layouts.app')
@section('content')
<breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БЛОГ']"></breadcrumb>
 <div class="container">
    <h5 class="text-center" style="font-weight: bold; font-size: 40px; padding-top: 40px">{{$blog->name}}</h5>
    {{-- <div class="text-center">
        <a class="breadcrumb-item" href="/home">Нүүр</a>
        <a disable > > </a>
        <a class="breadcrumb-item" href="/home/blog">Блог</a>
    </div> --}}
    <p class="text-center" style="color: #84A4C1; font-size: 15px; padding-top: 10px; margin-bottom: 3rem">{{$blog->created_at}}</p>

    @if($blog->url =='noimage123.png')         
    
    @else
        <div class="text-center">
         <img src="{{ asset('storage/uploads/'.$blog->url) }}" width="70%"  height="auto%" alt="">
        </div>       
    @endif
     
    <div width="100%"  height="100%">
        {!!$blog->desc!!}
    </div>
</div>
@endsection