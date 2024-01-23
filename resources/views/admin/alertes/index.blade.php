@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Alerts') }}</div>
                </div>
            </div>

            <div class="container mt-5">
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Alerte</td>
                            <td>Par</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alertes as $alerte)
                            <tr>
                                <td>{{ $loop->index+1  }}</td>
                                <td>{{ $alerte->alerte }}</td>
                                <td><a href="{{ route('alerte-users.show', $alerte->alerte_user) }}">{{ $alerte->alerteUser->nom ?? "" }} {{ $alerte->alerteUser->prenom ?? "" }}</a></td>
                                <td>{{ $alerte->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
