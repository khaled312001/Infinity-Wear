@extends('layouts.app')

@section('title', 'Infinity Wear - مؤسسة اللباس اللامحدود')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
@include('partials.hero-styles')
@endsection

@section('content')
@include('partials.hero-slider')
@include('partials.dynamic-sections')
@endsection

@section('scripts')
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
@include('partials.hero-scripts')
@endsection