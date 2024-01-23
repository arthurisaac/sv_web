@extends('layouts.pompier')

@section('content')
    <style>
        img.green {
            filter: hue-rotate(258deg);
        }

        img.red {
            filter: hue-rotate(152deg);
        }

    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

    <div class="p-5">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">{{__("Alertes")}}</p>
                            <h4 class="mb-0">{{ count($alertes) }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">{{__("Total traité")}}</p>
                            <h4 class="mb-0">{{ count($alertes->where("traite", "2"))  }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">{{__("Total en cours")}}</p>
                            <h4 class="mb-0">{{ count($alertes->where("traite", "1"))  }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">{{__("Total non traité")}}</p>
                            <h4 class="mb-0">{{ count($alertes->where("traite", "0"))  }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-7">
                                <h6>Alertes</h6>
                                <p class="text-sm mb-0">
                                    <span class="font-weight-bold ms-1">{{ count($alertes) }} </span> alerte(s)
                                </p>
                            </div>
                            <div class="row">
                                <form action="" method="get">
                                    @csrf
                                    <label for="date"></label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="date" class="form-control" id="date" name="date" value="{{ $date }}">
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-sm btn-primary">Valider</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        #
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Alerte
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Traitement
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Utilisateur
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Coordonnées
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alertes as $alerte)
                                    @php
                                        //$created = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $alerte->created_at);
                                    @endphp
                                    <tr @if ($alerte->vue == 1 ) class="bg-gradient-light" @endif>
                                        <td class="text-center">{{ $loop->index }}</td>
                                        <td class="text-center">
                                            @if ( Carbon\Carbon::parse($alerte->created_at)->gt(Carbon\Carbon::yesterday()) )
                                                {{  Carbon\Carbon::parse($alerte->created_at)->locale('fr_FR')->diffForHumans($now) }}
                                            @else
                                                {{ Carbon\Carbon::parse($alerte->created_at)->locale('fr_FR')->format('d M Y') }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($alerte->traite == 0) <span class="badge badge-danger">non traité</span>
                                            @elseif ($alerte->traite == 1) <span class="badge badge-warning">En cours</span>
                                            @elseif ($alerte->traite == 2) <span class="badge badge-success">Traité</span>
                                            @else<small>Ignoré</small>@endif</td>
                                        <td class="text-center">{{ $alerte->alerte }}</td>
                                        <td class="text-center">{{ $alerte->alerteUser->nom ?? "" }} {{ $alerte->alerteUser->prenom ?? ""}}</td>
                                        <td class="text-center"><a target="_blank"
                                                                   href="http://maps.google.com/maps?z=12&t=m&q={{ $alerte->latitude }},{{ $alerte->longitude }}">{{ number_format($alerte->latitude,2) }}
                                                , {{ number_format($alerte->longitude,2) }}</a></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary" href="/admin/alertes/{{ $alerte->id }}"
                                               target="_blank" data-toggle-tooltip="tooltip" data-placement="top"
                                               title=""
                                               data-original-title="Afficher">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $alertes->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card h-100">
                    <div id="map" style="width:100%; height:90vh"></div>
                </div>
            </div>
            {{--<div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Messages</h6>
                        <p class="text-sm">
                            Derniers messages
                        </p>
                    </div>
                    <div class="card-body p-3">
                        @foreach($messages as $message)
                            <a href="{{ route("discussions.show", $message->discussion) }}" target="_blank">
                                <div style="padding: 10px;width: 100%" class="border-bottom d-flex">
                                    <div>
                                        <img src="https://ui-avatars.com/api/?name={{ $message->alerteUser->nom ?? "" }}+{{ $message->alerteUser->prenom ?? "I"}}" alt="">
                                    </div>
                                    <div style="margin-left: 20px">
                                        {{ $message->message }} <br>
                                        <small>{{ $message->alerteUser->nom }}{{ $message->alerteUser->prenom }}</small>
                                    </div>

                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("/js/jquery-3.7.0.min.js") }}"></script>
    <script>
        const locations = [];
        const alertes = @json($alertes);
        alertes.forEach((alerte) => {
            locations.push([alerte.created_at, alerte.latitude, alerte.longitude, alerte.traite, alerte.id])
        })

        const map = L.map('map',  {
            fullscreenControl: true,
            // OR
            fullscreenControl: {
                pseudoFullscreen: false // if true, fullscreen to page width and height
            }
        }).setView([12.3869197, -1.4812245], 12);
        mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
        /*L.tileLayer(
            'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; ' + mapLink + ' Contributors',
                maxZoom: 18,
            }).addTo(map);*/

        /*L.tileLayer('https://{s}.tile.jawg.io/jawg-dark/{z}/{x}/{y}{r}.png?access-token={accessToken}', {
            attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank">&copy; <b>Jawg</b>Maps</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            minZoom: 0,
            maxZoom: 22,
            subdomains: 'abcd',
            accessToken: '<your accessToken>'
        }).addTo(map);*/

        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const LeafIcon = L.Icon.extend({
            options: {
                iconSize: [25, 30],
                shadowSize: [50, 64],
                iconAnchor: [22, 94],
                shadowAnchor: [4, 62],
                popupAnchor: [-3, -76]
            }
        });

        /*const greenIcon = new LeafIcon({
            iconUrl: '{{ asset("assets/img/icons/pin_green.png") }}',
            //shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
        });
        const redIcon = new LeafIcon({
            iconUrl: '{{ asset("assets/img/icons/pin_red.png") }}',
            //shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
        });
        const orangeIcon = new LeafIcon({
            iconUrl: '{{ asset("assets/img/icons/pin_orange.png") }}',
            //shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
        });*/

        for (let i = 0; i < locations.length; i++) {
            const date = new Date(locations[i][0]).toLocaleDateString("fr-FR", {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            });
            if (locations[i][3] === 1) {
                marker = new L.marker([locations[i][1], locations[i][2]])
                    .bindPopup(date)
                    .addTo(map);


            } else if (locations[i][3] === 2) {
                marker = new L.marker([locations[i][1], locations[i][2]])
                    .bindPopup(date)
                    .addTo(map);
                marker._icon.classList.add("green");

            } else {
                marker = new L.marker([locations[i][1], locations[i][2]])
                    .bindPopup(date + `<br/><a target="_blank" href='admin/alertes/${locations[i][4]}'>Ouvrir</a>`)
                    .addTo(map);
                marker._icon.classList.add("red");

            }
        }

        function getAlertes() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/alertes-custom",
                method: 'POST',
                //dataType: 'JSON',
                data: {
                    date: "{{ $date }}"
                },
                //contentType: false,
                //cache: false,
                //processData: false,
                success: function (response) {
                    if (response.total !== alertes.length) {
                        window.location.reload();
                    }

                },
                error: function (response) {
                    console.log(response);
                }
            });
        }

        $(document).ready(function () {
            setInterval(getAlertes, 5000);
        });
    </script>
@endsection
