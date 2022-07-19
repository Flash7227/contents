@extends('layouts.app')
@section('content')
<shared-comp csrf="{{ csrf_token() }}"></shared-comp>
@endsection