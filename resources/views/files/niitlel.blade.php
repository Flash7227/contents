@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БЛОГ']"></breadcrumb>
 <niitlel-comp csrf="{{ csrf_token() }}"></niitlel-comp>
@endsection