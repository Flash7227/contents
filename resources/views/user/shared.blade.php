@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ФАЙЛ', 'ХУВААЛЦСАН ФАЙЛ']"></breadcrumb>
@if(Auth()->user()->email_verified_at)
<shared-comp csrf="{{ csrf_token() }}" tags="{{$tags}}"></shared-comp>
@else
<div class="alert alert-warning" role="alert">
    Та имайл хаягаа баталгаажуулна уу!
  </div>
@endif

@endsection