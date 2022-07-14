@extends('layouts.app')
@section('content')
<upload-comp csrf="{{ csrf_token() }}"></upload-comp>
@endsection