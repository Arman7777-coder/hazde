@extends('layouts.client')

@section('title', 'Client Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Client Dashboard</h1>
                <p class="mb-4">Բարի գալուստ հաճախորդի վահանակ:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold mb-2">Իմ պրոֆիլը</h2>
                        <p class="mb-4">Դիտել և խմբագրել ձեր պրոֆիլի տվյալները:</p>
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Դիտել պրոֆիլը</a>
                    </div>
                    
                    <div class="bg-green-50 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold mb-2">Իմ ծառայությունները</h2>
                        <p class="mb-4">Դիտել ձեր ծառայությունների պատմությունը:</p>
                        <a href="#" class="text-green-600 hover:underline">Դիտել ծառայությունները</a>
                    </div>
                    
                    <div class="bg-yellow-50 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold mb-2">Աջակցություն</h2>
                        <p class="mb-4">Կապվեք մեր աջակցության թիմի հետ:</p>
                        <a href="#" class="text-yellow-600 hover:underline">Կապ հաստատել</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection