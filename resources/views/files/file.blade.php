@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ҮНДСЭН', 'ФАЙЛ']"></breadcrumb>
 <file-comp csrf="{{ csrf_token() }}"></file-comp>
@endsection