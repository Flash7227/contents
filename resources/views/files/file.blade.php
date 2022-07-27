@extends('layouts.app')
@section('content')
<breadcrumb :urls="['НЭЭЛТТЭЙ КОНТЕНТ', 'ФАЙЛ']"></breadcrumb>
 <file-comp csrf="{{ csrf_token() }}"></file-comp>
@endsection