@extends('layouts.main_layout')

@section('content')

<div class="container text-center py-5">
	<img src="{{ asset('images/error.png') }}" alt="Erro" class="my-1" width="400vw">

    <h1 class="display-1">{{ $errorCode }}</h1>
    <p class="lead">{{ $errorMessage }}</p>

    <div class="mt-4">
        <a href="{{ $previousUrl }}" class="btn btn-primary">
            <i class="fas fa-arrow-left mr-2"></i> Voltar à página anterior
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary ml-2">
            <i class="fas fa-home mr-2"></i> Ir para a página inicial
        </a>
    </div>
</div>

@endsection
