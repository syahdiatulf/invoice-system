@extends('layouts.app')

@section('content')
    
    <div class="text-center mt-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
        <p class="mb-6">You are logged in, {{ auth()->user()->name }}.</p>
    </div>
    <div class="text-center mt-6">
        <a href="{{ route('invoices.create') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
       Create Invoice
    </a><br>
    <div class="text-center mt-6">
        <a href="{{ route('invoices.index') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
       View Invoice
    </a><br>
    </div>


@endsection
