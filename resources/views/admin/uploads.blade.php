
@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ADMIN', 'ХУУЛАГДСАН ФАЙЛУУД']"></breadcrumb>
<admin-uploads-comp csrf="{{ csrf_token() }}" states="{{$emails}}" tags="{{$tags}}"></admin-uploads-comp>
@endsection