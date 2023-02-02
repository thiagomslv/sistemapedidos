@extends('layouts.main')

@section('title', 'Sistema de Gerencialmento de Pedidos')

@section('content')

    <main class="selecionar">

        <div class="servico">
            <div class="servico-info">
                <ion-icon name="add-outline"></ion-icon>
                <a href="pedidos/cadastrar">Cadastrar Pedidos</a>
            </div>
        </div>

        <div class="servico">
            <div class="servico-info">
                <ion-icon name="bag-check-outline"></ion-icon>
                <a href="pedidos/fechar">Fechar Pedidos</a>
            </div>
        </div>

        <div class="servico">
            <div class="servico-info">
                <ion-icon name="clipboard-outline"></ion-icon>
                <a href="pedidos">Listar Pedidos</a>
            </div>
        </div>

        <div class="servico">
            <div class="servico-info">
                <ion-icon name="earth-outline"></ion-icon>
                <a href="pedidos/mapa">Mapa de Pedidos</a>
            </div>
        </div>
    </main> 

@endsection