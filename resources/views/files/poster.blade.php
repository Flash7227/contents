@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'ПОСТЕР']"></breadcrumb>
 <poster-comp csrf="{{ csrf_token() }}"></poster-comp>
@endsection