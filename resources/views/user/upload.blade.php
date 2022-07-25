@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ҮНДСЭН', 'ФАЙЛ ХУУЛАХ']"></breadcrumb>
<upload-comp csrf="{{ csrf_token() }}" states="{{$emails}}" user="{{Auth()->user()}}"></upload-comp>
@endsection