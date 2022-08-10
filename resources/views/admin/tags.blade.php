
@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ADMIN', '#TAG']"></breadcrumb>
<admin-tags-comp csrf="{{ csrf_token() }}"></admin-tags-comp>
@endsection