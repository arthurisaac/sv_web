@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br/>
        @endif
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            <br>
        @endif


        <h2 class="text-center">{{ $alerte->alerte }}</h2>
        <br>
        <div id="map" style="width:100%; height:60vh"></div>
        <br>
        @if ($alerte->attribue_a)
            <p>Status actuelle : ({{ $alerte->traite }})
                @if ($alerte->traite == 0) <span>non traité</span>
                @elseif ($alerte->traite == 1) <span>En cours</span>
                @elseif ($alerte->traite == 2) <span class="label label-success">Traité</span>
                @else <small>Ignoré</small>@endif
            </p>
            @if ($alerte->traite < 2)
                <form action="{{ route("alertes.traiter") }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $alerte->id }}" name="alerte">
                    <label for="traite">Modifier le status</label>
                    <select name="traite" id="traite" class="form-control">
                        {{--<option value="1">En cours</option>--}}
                        <option value="2">Traité</option>
                        <option value="3">Ignoré</option>
                    </select>
                    <br>
                    <div class="form-group">
                        <button class="btn btn-primary">Valider</button>
                    </div>
                </form>
            @endif
        @else
            <form action="{{ route("ambulance.affecter") }}" method="post">
                @csrf
                <label for="ambulance">Selectionnez l'ambulance</label>
                <select name="ambulance" id="ambulance" class="form-control">
                    @foreach($ambulances as $ambulance)
                        <option value="{{ $ambulance->id }}">{{ $ambulance->intitule }}</option>
                    @endforeach
                </select>
                <input type="hidden" value="{{ $alerte->id }}" name="alerte">

                <br>
                <div class="form-group">
                    <button class="btn btn-primary">Affecter l'ambulance</button>
                </div>
            </form>
        @endif
    </div>
    <script type="text/javascript">
        const lat = {{ $alerte->latitude }};
        const long = {{ $alerte->longitude }};
        const map = L.map('map').setView([lat, long], 13); // LIGNE 18

        const osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 20
            attribution: '© OpenStreetMap contributors',
            maxZoom: 17
        });

        L.marker([lat, long]).addTo(map)
            .bindPopup('{{ $alerte->alerte }} <br/> {{ $alerte->created_at }}');

        map.addLayer(osmLayer);
    </script>
@endsection
