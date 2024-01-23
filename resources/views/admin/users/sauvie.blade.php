@extends('layouts.app')

@section('content')

     <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Utilisateurs connecté à sauvie</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Téléphone</td>
                                <td>No Unique</td>
                                <td>Modifier</td>
                                <td>Supprimer</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->nom }}</td>
                                    <td>{{ $user->prenom }}</td>
                                    <td>{{ $user->telephone }}</td>
                                    <td>{{ $user->uniq }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary">Modifier</a>
                                    </td>
                                    <td>
                                        <button onclick="event.preventDefault();
                                        if (confirm('Confirmer la suppression ?')) document.getElementById('user-delete-{{ $user->id }}').submit();" class="btn btn-danger">Supprimer</button>
                                        <form id="user-delete-{{ $user->id }}" action="{{ route('users-delete', [ 'id' => $user->id]) }}" method="POST">@csrf @method('DELETE')</form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
