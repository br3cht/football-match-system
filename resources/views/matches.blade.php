@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Header e Filtro -->
        <div class="flex justify-between items-center mb-4 bg-white p-4 rounded-lg shadow-md">
            <h1 class="text-xl font-bold">Jogos</h1>
        </div>

        <!-- Componente Livewire -->
        @livewire('matches')
    </div>
@endsection

