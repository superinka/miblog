@extends('layouts.default')
@section('title',$title)

@section('head-js')
    @include($js)
@endsection

@section('content')
    @include('components.post.list-post')
@endsection

