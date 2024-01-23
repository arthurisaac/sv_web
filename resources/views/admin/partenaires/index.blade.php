@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="card">
                    <div class="card-header">{{ __('Partenaires') }}</div>


                    <div class="container mt-5">
                        <a href="{{ route("partenaires.create") }}" class="btn btn-primary">Ajouter +</a>
                        <table class="table table-responsive table-bordered">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Balance</td>
                                <td>Date</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partenaires as $partenaire)
                                <tr>
                                    <td>{{ $loop->index+1  }}</td>
                                    <td>{{ $partenaire->nom }}</td>
                                    <td>{{ $partenaire->prenom }}</td>
                                    <td>{{ $partenaire->balance }}</td>
                                    <td>{{ $partenaire->created_at }}</td>
                                    <td>
                                        <form action="{{ route('partenaires.destroy', $partenaire->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
