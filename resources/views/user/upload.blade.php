@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ФАЙЛ', 'ФАЙЛ ХУУЛАХ']"></breadcrumb>
@if(Auth()->user()->email_verified_at)
<upload-comp csrf="{{ csrf_token() }}" states="{{$emails}}" tags="{{$tags}}" user="{{Auth()->user()}}"></upload-comp>
@else
<div class="alert alert-warning" role="alert">
    Та имайл хаягаа баталгаажуулна уу!
  </div>
@endif

@endsection