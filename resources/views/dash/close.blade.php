@extends('layouts.main')

@section('title', 'Fechar pedidos')

@section('content')

<div class="back"><ion-icon name="chevron-back-outline"></ion-icon> <a href="/">voltar</a></div>

<div id="table_cont">
    @if($msg_e)
      <div class="alert alert-danger text-center" role="alert">
        {{$msg_e}}
      </div>
    @endif
  <table class="table table-sm">
    <thead class="table-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Sobrenome</th>
        <th scope="col">Rua</th>
        <th scope="col">Bairro</th>
        <th scope="col">Número</th>
        <th scope="col">Telefone</th>
        <th scope="col">Valor</th>
        <th scope="col">Observações</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($orders as $order)
        @if($order->status == true)
          <tr>
            <th scope="row">{{$order->id}}</th>
            <td>{{$order->nome}}</td>
            <td>{{$order->sobrenome}}</td>
            <td>{{$order->rua}}</td>
            <td>{{$order->bairro}}</td>
            <td>{{$order->numero}}</td>
            <td>{{$order->telefone}}</td>
            <td>{{$order->valor}}</td>
            <td>{{$order->observacoes}}</td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>

  <form action="/fechar" method="POST">
  @csrf
      <select name="pedido" class="w-25 form-select form-select-sm input-medium" aria-label=".form-select-sm example">
          <option selected value="-1">Selecione um pedido para fechar</option>

          @foreach($orders as $order)
            @if($order->status == true)
              <option value="{{ $order->id }}">{{$order->id }}</option>
            @endif
          @endforeach
      </select>
      <button type="submit" class="btn btn-primary mt-2">Fechar pedido</button>
  </form>
</div>

@endsection