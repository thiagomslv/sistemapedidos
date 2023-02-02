@extends('layouts.main')

@section('title', 'Fechar pedidos')

@section('content')

<div class="container_maps">

    <div class="back" style="height: 40px"><ion-icon name="chevron-back-outline"></ion-icon> <a href="/">voltar</a></div>
    <form action="/pedidos/mapa" method="POST" x-data>
        @csrf
        <div class="form-group"> 
            <label for="inicio">De</label>
            <input type="text" name="inicio" class="form-control" placeholder="Data de início" x-mask="99/99/9999">
        </div>

        <div class="form-group">
            <label for="fim">Até</label>
            <input type="text" name="fim" class="form-control" placeholder="Data de fim" x-mask="99/99/9999">
        </div>

        <div class="form-check mt-4">
            <input class="form-check-input" type="radio" name="type_map" value="calor">
            <label class="form-check-label" for="type_map">
                Mapa de calor
            </label>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Buscar</button>
    </form>

</div>

@if($msg_e)
    <div class="alert alert-danger text-center mt-2" role="alert">
    {{$msg_e}}
    </div>
@endif

<div id="map"></div>

<script>

let map, markers = [];

let orders = {!! json_encode($orders) !!};
let type = {!! json_encode($type_map) !!};

function initMap() {

    map = L.map('map', {
        center: {
            lat: -7.1193416,
            lng: -34.824759,
        },
        zoom: 10
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
}

initMap();

function generateMarker(data, index) {

    return L.marker(data.position, {
            draggable: data.draggable
        })
}

if(!(JSON.stringify(orders) === '{}')){
    
    const points = [];

    orders.forEach(order => {

        fetch('https://nominatim.openstreetmap.org/search?' + new URLSearchParams({
        street: order['numero'] + " " + order['rua'],
        city: 'joão pessoa',
        state: 'paraíba',
        format: 'geojson'
        })).then(res => res.json()).then(res => {

            if(res.features[0] != undefined){
                const coordenadas = res.features[0].geometry.coordinates;
                
                const data = {
                    position: { lat: coordenadas[1], lng: coordenadas[0] },
                    draggable: false
                }

                if(type === 'calor'){
                    
                    points.push([coordenadas[1], coordenadas[0]])

                }else{

                    const marker = generateMarker(data, markers.length - 1);
                    marker.addTo(map).bindPopup(`<b>Cliente: ${order['nome']} ${order['sobrenome']}</b><br>
                                                <b>Telefone: ${order['telefone']}</b>`);
                    markers.push(marker);
                }
            }
        })
    })

    if(type === 'calor'){

        L.heatLayer(points, {
                        radius: 25,
                        minOpacity: 0.4,
                        gradient: {0.4: 'blue', 0.5: 'lime', 0.6: 'red'}
                    }).addTo(map);
    }
    
                    
}

</script>
@endsection