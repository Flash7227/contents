@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ФАЙЛ', 'ФАЙЛ ХУУЛАХ']"></breadcrumb>
<upload-comp csrf="{{ csrf_token() }}" states="{{$emails}}" tags="{{$tags}}" user="{{Auth()->user()}}"></upload-comp>
@endsection