@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="card">
                    <div class="card-header">{{ __('Ambulances') }}</div>


                    <div class="container mt-5">
                        <a href="{{ route("ambulances.create") }}" class="btn btn-primary">Ajouter +</a>
                        <table class="table table-responsive table-bordered">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Intitule</td>
                                <td>Nom</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ambulances as $ambulance)
                                <tr>
                                    <td>{{ $loop->index+1  }}</td>
                                    <td>{{ $ambulance->intitule }}</td>
                                    <td>{{ $ambulance->attribute }}</td>
                                    <td>
                                        <form action="{{ route('ambulances.destroy', $ambulance->id)}}" method="post">
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
@endsection
