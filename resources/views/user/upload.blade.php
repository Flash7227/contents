@extends('layouts.app')
@section('content')
hi
<upload-comp csrf="{{ csrf_token() }}"></upload-comp>
@endsection