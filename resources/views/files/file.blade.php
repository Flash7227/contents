@extends('layouts.app')
@section('content')
 <file-comp csrf="{{ csrf_token() }}"></file-comp>
@endsection