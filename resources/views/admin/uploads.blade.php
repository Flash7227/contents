
@extends('layouts.app')
@section('content')
<admin-uploads-comp csrf="{{ csrf_token() }}"></admin-uploads-comp>
@endsection