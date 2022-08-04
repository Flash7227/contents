@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ФАЙЛ', 'ХУВААЛЦСАН ФАЙЛ']"></breadcrumb>
<shared-comp csrf="{{ csrf_token() }}" tags="{{$tags}}"></shared-comp>
@endsection