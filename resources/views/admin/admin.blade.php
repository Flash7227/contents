
@extends('layouts.app')
@section('content')
<admin-comp csrf="{{ csrf_token() }}"></admin-comp>
@endsection