@extends('layouts.profile')

@section('title','My Orders')

@section('profile-content')
{{ auth()->user()->name}}

@endsection