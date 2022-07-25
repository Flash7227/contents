@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['ҮНДСЭН', 'ПОСТЕР']"></breadcrumb>
 <poster-comp csrf="{{ csrf_token() }}"></poster-comp>
@endsection