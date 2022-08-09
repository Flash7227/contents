@extends('layouts.app')
@section('content')
 {{-- <home-comp csrf="{{ csrf_token() }}"></home-comp> --}}
 <home2-comp csrf="{{ csrf_token() }}" tags="{{$tags}}"></home2-comp>
@endsection