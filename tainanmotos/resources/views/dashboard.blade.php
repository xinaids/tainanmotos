@extends('layouts.app')

@section('content')
@include('partials.header')

<div class="dashboard-container">
    <h2>Seja bem vindo ao sistema.</h2>
    <p>Selecione uma opção no menu acima para continuar.</p>
</div>

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@endsection

<style>
/* Fundo da página */
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

/* Container principal do dashboard */
.dashboard-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 100px);
    color: #333;
    padding: 20px;
    flex-direction: column;
    text-align: center;
}

h2 {
    margin-bottom: 10px;
    font-size: 26px;
}

p {
    font-size: 16px;
    color: #555;
}
</style>

