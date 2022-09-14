@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'НИЙТЛЭЛ']"></breadcrumb>
 <blog-comp csrf="{{ csrf_token() }}"></blog-comp>
@endsection