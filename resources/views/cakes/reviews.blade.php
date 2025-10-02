@extends('layouts.app')

@section('title', $cake->name . ' - Reviews - BlissCakes')

@section('content')
    @livewire('cake-reviews', ['cakeId' => $cake->id])
@endsection