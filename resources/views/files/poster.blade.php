@extends('layouts.app')
@section('content')
 <poster-comp csrf="{{ csrf_token() }}"></poster-comp>
@endsection