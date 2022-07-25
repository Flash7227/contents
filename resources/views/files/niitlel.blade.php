@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['ҮНДСЭН', 'НИЙТЛЭЛ']"></breadcrumb>
 <niitlel-comp csrf="{{ csrf_token() }}"></niitlel-comp>
@endsection