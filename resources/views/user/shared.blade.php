@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ҮНДСЭН', 'ХУВААЛЦСАН ФАЙЛ']"></breadcrumb>
<shared-comp csrf="{{ csrf_token() }}"></shared-comp>
@endsection