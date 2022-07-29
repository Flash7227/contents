@extends('layouts.app')
@section('content')
<breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БЛОГ']"></breadcrumb>

<div class="container">
    <h5 class="text-center">{{$blog->name}}</h5>
    <div>
        {!!$blog->desc!!}
    </div>
</div>
@endsection