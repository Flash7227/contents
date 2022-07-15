@extends('layouts.app')
@section('content')
<upload-comp csrf="{{ csrf_token() }}" states="{{$emails}}"></upload-comp>
@endsection