@extends('layouts.app')
@section('content')
 <breadcrumb :urls="['ҮНДСЭН', 'БИЧЛЭГ']"></breadcrumb>
 <video-comp csrf="{{ csrf_token() }}"></video-comp>
@endsection