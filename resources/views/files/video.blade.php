@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'БИЧЛЭГ']"></breadcrumb>
 <video-comp csrf="{{ csrf_token() }}"></video-comp>
@endsection