
@extends('layouts.app')
@section('content')
<profile-comp csrf="{{ csrf_token() }}"></profile-comp>
@endsection