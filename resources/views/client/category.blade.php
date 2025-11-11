@extends('client.layout.app')

@section('title', 'Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Category #{{ $id }}</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <p class="text-gray-600 mb-4">This is the detailed page for category #{{ $id }}.</p>
        <p class="text-gray-600">In a real application, this page would show services and vendors specific to this category.</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-4">Services in this category</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @for ($i = 1; $i <= 6; $i++)
            <div class="border rounded-lg p-4">
                <h3 class="font-semibold mb-2">Service {{ $i }}</h3>
                <p class="text-gray-600 text-sm">Description of service {{ $i }} in category {{ $id }}.</p>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
