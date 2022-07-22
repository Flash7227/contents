@extends('layouts.app')
@section('content')
<upload-comp csrf="{{ csrf_token() }}" states="{{$emails}}" user="{{Auth()->user()}}"></upload-comp>
@endsection