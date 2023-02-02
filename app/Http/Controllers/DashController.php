<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\Order;
use Carbon\Carbon;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class DashController extends Controller
{
    public function index(){

        return view('welcome');
    }

    public function create(){
        
        return view('dash.create');
    }

    public function show(){

        try{

            $msg_e = "";
            $orders = Order::all();
            return view('dash.close', compact('orders', 'msg_e'));
        }catch(\Illuminate\Database\QueryException $e){

            $orders = (object)[];
            $msg_e = 'Ocorreu uma falha ao conectar-se com o banco de dados!';
            return view('dash.close', compact('orders', 'msg_e'));
        }
    }

    public function close(Request $request){
        
        $msg_e = "";

        if($request->pedido == -1){

            try{
                
                $msg_e = "Selecione um pedido!";
                $orders = Order::all();

                return view('dash.close', ['orders' => $orders, 'msg_e' => $msg_e]);

            }catch(\Illuminate\Database\QueryException $e){

                $orders = (object)[];
                $msg_e = "Selecione um pedido!\nErro ao tentar carregar os pedidos!";
                return view('dash.close', ['orders' => $orders, 'msg_e' => $msg_e]);
            }
        }

        try{

            $order = Order::findOrFail($request->pedido);
            $order->status = false;
            $order->save();

            $orders = Order::all();

            return view('dash.close', ['orders' => $orders, 'msg_e' => $msg_e]);

        }catch(\Illuminate\Database\QueryException $e){

            $msg_e = "Ocorreu uma falha ao tentar fechar o pedido!";
            $orders = (object)[];

            return view('dash.close', ['orders' => $orders, 'msg_e' => $msg_e]);
        }
    }

    public function store(Request $request){

        $order = new Order;

        $order->nome = $request->nome;
        $order->sobrenome = $request->sobrenome;
        $order->rua = $request->rua;
        $order->bairro = $request->bairro;
        $order->numero = $request->numero;
        $order->telefone = $request->telefone;
        $order->valor = $request->valor;
        $order->observacoes = $request->observacoes;

        $order->status = true;
        
        //Validações
        if($request->nome && $request->sobrenome && $request->rua && $request->bairro
        && ($request->numero != "") && $request->telefone && $request->valor){

            try{

                $order->save();
                return redirect('/pedidos/cadastrar')->with('msg', 'Pedido cadastrado com sucesso!');
            }catch(\Illuminate\Database\QueryException $e){
                
                return redirect('/pedidos/cadastrar')->with('msg_e', 'Ocorreu algum erro ao registrar o pedido!');
            }
        }else{

            return redirect('/pedidos/cadastrar')->with('msg_e', 'Preencha todos os campos!');
        }
    }

    public function list(){

        $orders = (object)[];
        $msg_e = "";

        return view('dash.list', ['orders' => $orders, 'msg_e' => $msg_e]);
    }

    public function search(Request $request){

        $msg_e = "";
        $orders = (object)[];
        $attribs = [];

        if($request->nome) $attribs['nome'] = $request->nome;
        if($request->sobrenome) $attribs['sobrenome'] = $request->sobrenome;
        if($request->rua) $attribs['rua'] = $request->rua;
        if($request->bairro) $attribs['bairro'] = $request->bairro;
        if($request->numero) $attribs['numero'] = $request->numero;
        if($request->telefone) $attribs['telefone'] = $request->telefone;
        if($request->valor) $attribs['valor'] = $request->valor;

        if(count($attribs) == 0 && $request->adicional == -1){

            $msg_e = "Escolha um filtro!";
            return view('dash.list', ['orders' => $orders, 'msg_e' => $msg_e]);
        } 

        try{

            if($request->adicional == 2){

                $attribs['status'] = true;
            }else if($request->adicional == 3){

                $attribs['status'] = false;
            }

            //Verifica se há datas para filtrar.
            if($request->inicio || $request->fim){

                if(!($request->inicio && $request->fim)){

                    $msg_e = "É necessário ter as duas datas!";
                    return view('dash.list', ['orders' => $orders, 'msg_e' => $msg_e]);
                }else{

                    $inicio = $request->inicio;
                    $fim = $request->fim;

                    $inicio = explode('/', $request->inicio);
                    $fim = explode('/', $request->fim);

                    //Validações.
                    if(count($inicio) < 3 || count($fim) < 3){

                        $msg_e = "Data inválida!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }

                    if($inicio[2] == "" || $fim[2] == ""){

                        $msg_e = "Data inválida!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }

                    if($inicio[0] < 1 || $inicio[0] > 31 || $fim[0] < 1 || $fim[0] > 31){

                        $msg_e = "Data inválida!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }

                    if($inicio[1] < 1 || $inicio[1] > 12 || $fim[1] < 1 || $fim[1] > 12){

                        $msg_e = "Data inválida!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }

                    //Validações de range.
                    if($fim[2] < $inicio[2]){

                        $msg_e = "Intervalo inválido!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }else if($fim[1] < $inicio[1]){

                        $msg_e = "Intervalo inválido!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }else if($fim[1] == $inicio[1] && $fim[0] < $inicio[0]){

                        $msg_e = "Intervalo inválido!";

                        return view('dash.list', compact('orders', 'msg_e'));
                    }

                    $de = Carbon::createFromFormat('Y-m-d', $inicio[2].'-'.$inicio[1].'-'.$inicio[0]);
                    $ate = Carbon::createFromFormat('Y-m-d', $fim[2].'-'.$fim[1].'-'.$fim[0]);

                    if($request->adicional == 1){   
                    
                        $orders = Order::whereDate('created_at', '>=', $de)->whereDate('created_at','<=', $ate)->get();
                        
                    }else{
        
                        $orders = Order::where($attribs)->whereDate('created_at', '>=', $de)->whereDate('created_at','<=', $ate)->get();
                    }
                }                
            }else{

                if($request->adicional == 1){   
                    
                    $orders = Order::all();
                    
                }else{
    
                    $orders = Order::where($attribs)->get();
                }
            }
            
            if($request->exportar){

                return Excel::download(
                    new OrdersExport($orders),
                    'pedidos.xlsx'
                );
            }
            
            if($orders->isEmpty()) $msg_e = "Pedido não encontrado!";
            return view('dash.list', ['orders' => $orders, 'msg_e' => $msg_e]);

        }catch(\Illuminate\Database\QueryException $e){

            $orders = (object)[];
            $msg_e = "Ocorreu um erro ao tentar filtrar os dados!";
            return view('dash.list', ['orders' => $orders, 'msg_e' => $msg_e]);
        }
    }

    public function map(){

        $msg_e = "";
        $orders = (object)[];
        $type_map = "";

        return view('dash.map', compact('orders', 'msg_e', 'type_map'));
    }

    public function mapfilter(Request $request){

        $orders = (object)[];
        $msg_e = "";
        $type_map = $request->type_map;

        if(!$request->inicio || !$request->fim){
                        
            $msg_e = "Escolha um intervalo!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        $inicio = explode('/', $request->inicio);
        $fim = explode('/', $request->fim);

        //Validações.
        if(count($inicio) < 3 || count($fim) < 3){

            $msg_e = "Data inválida!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        if($inicio[2] == "" || $fim[2] == ""){

            $msg_e = "Data inválida!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        if($inicio[0] < 1 || $inicio[0] > 31 || $fim[0] < 1 || $fim[0] > 31){

            $msg_e = "Data inválida!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        if($inicio[1] < 1 || $inicio[1] > 12 || $fim[1] < 1 || $fim[1] > 12){

            $msg_e = "Data inválida!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        //Validações de range.
        if($fim[2] < $inicio[2]){

            $msg_e = "Intervalo inválido!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }else if($fim[1] < $inicio[1]){

            $msg_e = "Intervalo inválido!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }else if($fim[1] == $inicio[1] && $fim[0] < $inicio[0]){

            $msg_e = "Intervalo inválido!";

            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }

        $de = Carbon::createFromFormat('Y-m-d', $inicio[2].'-'.$inicio[1].'-'.$inicio[0]);
        $ate = Carbon::createFromFormat('Y-m-d', $fim[2].'-'.$fim[1].'-'.$fim[0]);

        try{
            
            $orders = Order::whereDate('created_at', '>=', $de)->whereDate('created_at','<=', $ate)->get();
            
        }catch(\Illuminate\Database\QueryException $e){

            $msg_e = "Ocorreu um erro ao buscar os usuários no banco de dados!";
            return view('dash.map', compact('orders', 'msg_e', 'type_map'));
        }
        
        return view('dash.map', compact('orders', 'msg_e', 'type_map'));
    }   
}
