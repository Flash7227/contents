
@extends('layouts.app')
@section('content')
<breadcrumb :urls="['ADMIN', 'ХЭРЭГЛЭГЧДИЙН ХУУЛСАН ФАЙЛ']"></breadcrumb>
<admin-uploads-comp csrf="{{ csrf_token() }}"></admin-uploads-comp>
@endsection