@extends('layouts.main')

@section('title', 'Cadastar Produtos')

@section('content')
<div class="back"><ion-icon name="chevron-back-outline"></ion-icon> <a href="/">voltar</a></div>
<div id="container" x-data>
    @if(session('msg_e'))
    <div class="alert alert-danger" role="alert">
      {{session('msg_e')}}
    </div>
    @endif

    @if(session('msg'))
    <div class="alert alert-success" role="alert">
      {{session('msg')}}
    </div>
    @endif

    <h1>Cadastre o pedido</h1>

    <form class="cadastropedido" action="/cadastrar" method="POST">
      @csrf
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

      <div class="form-group">
        <label for="observacoes">Observações</label>
        <textarea name="observacoes" class="form-control" id="observacoes" rows="3"></textarea>
      </div>
      
      <button type="submit" class="btn btn-primary mt-2">Cadastrar pedido</button>
    </form>
</div>

@endsection