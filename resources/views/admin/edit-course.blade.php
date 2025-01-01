@extends('layouts.app')

@section('content')
    @livewire('edit-course',['id' => $course])
@endsection
