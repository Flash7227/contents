@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БЛОГ']"></breadcrumb>
 <blog-comp csrf="{{ csrf_token() }}"></blog-comp>
@endsection