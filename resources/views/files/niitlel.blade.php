@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['ҮНДСЭН', 'БЛОГ']"></breadcrumb>
 <niitlel-comp csrf="{{ csrf_token() }}"></niitlel-comp>
@endsection