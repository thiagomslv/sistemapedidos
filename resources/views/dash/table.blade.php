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
        <th scope="col">Status</th>
        <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>

        @foreach($orders as $order)
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
                @if($order->status == 1) <td>Aberto</td> @else <td>Fechado</td> @endif
                <td>{{$order->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>