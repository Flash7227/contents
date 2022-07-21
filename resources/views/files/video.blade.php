@extends('layouts.app')
@section('content')
 <video-comp csrf="{{ csrf_token() }}"></video-comp>
@endsection