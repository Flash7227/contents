@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БЛОГ']"></breadcrumb>
 <detailblog-comp csrf="{{ csrf_token() }}"></detailblog-comp>
@endsection