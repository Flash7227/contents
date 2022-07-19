@extends('layouts.app')
@section('content')
 <home-comp csrf="{{ csrf_token() }}"></home-comp>
@endsection