
@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ADMIN', 'ХЭРЭГЛЭГЧДИЙН ХУУЛСАН ФАЙЛ']"></breadcrumb>
<admin-uploads-comp csrf="{{ csrf_token() }}" states="{{$emails}}" tags="{{$tags}}"></admin-uploads-comp>
@endsection