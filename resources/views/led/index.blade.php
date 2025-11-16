@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">LED Control</h1>

        @livewire('led-control')
    </div>
</div>
@endsection
