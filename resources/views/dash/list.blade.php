@extends('layouts.main')

@section('title', 'Fechar pedidos')

@section('content')

<div class="back"><ion-icon name="chevron-back-outline"></ion-icon> <a href="/">voltar</a></div>
@if($msg_e)
    <div class="alert alert-danger text-center mt-2" role="alert">
        {{$msg_e}}
    </div>
@endif

<div class="container_filtro">

    <div class="d-flex flex-column justify-content-center align-items-center" x-data>
        <h1>Selecione o filtro</h1>
        <form action="/pedidos" method="POST">
        @csrf

            <select name="adicional" class="form-select form-select-sm input-medium" aria-label=".form-select-sm example">
                <option selected value="-1">Outros tipos de filtros</option>

                    <option value="1">Filtrar todos os pedidos</option>
                    <option value="2">Filtrar apenas pedidos abertos</option>
                    <option value="3">Filtrar apenas pedidos fechados</option>
            </select>
            
            <div class="row">
                <div class="form-group col-md-6"> 
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" placeholder="Nome">
                </div>

                <div class="form-group col-md-6">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" class="form-control" placeholder="Nome">
                </div>
            </div>

            <div class="form-group">
                <label for="rua">Nome da rua</label>
                <input type="text" name="rua" class="form-control" placeholder="Nome da Rua">
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" class="form-control" placeholder="Bairro">
                </div>

                <div class="form-group col-md-6">
                <label for="numero">Número</label>
                <input type="text" name="numero" class="form-control" placeholder="Número">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control" x-mask="(99) 99999-9999" placeholder="Número do telefone">
                </div>

                <div class="form-group col-md-6">
                <label for="valor">Valor do pedido</label>
                <input type="text" name="valor" class="form-control" x-mask:dynamic="$money($input,  '.')" placeholder="R$">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6"> 
                    <label for="inicio">De</label>
                    <input type="text" name="inicio" class="form-control" placeholder="Data de início" x-mask="99/99/9999">
                </div>

                <div class="form-group col-md-6">
                    <label for="fim">Até</label>
                    <input type="text" name="fim" class="form-control" placeholder="Data de fim" x-mask="99/99/9999">
                </div>
            </div>

            <div class="d-flex justify-content-between">

            <button type="submit" class="btn btn-primary mt-2">Buscar</button>
            <button name="exportar" type="submit" class="btn btn-success mt-2" value="exportar">Exportar para o excel</button>
            </div>
                
        </form>
    </div>

    @include('dash.table')
    
</div>

@endsection