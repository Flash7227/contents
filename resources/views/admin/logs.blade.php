
@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ADMIN', 'LOGS']"></breadcrumb>
<admin-logs-comp csrf="{{ csrf_token() }}"></admin-logs-comp>
@endsection