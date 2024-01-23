@extends('layouts.app')

@section('content')

     <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Vérification KYC</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Document recto</td>
                                <td>Document verso</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->nom }}</td>
                                    <td>{{ $user->prenom }}</td>
                                    <td><img src="/storage/{{ $user->verification_doc_recto }}" alt="" /></td>
                                    <td><img src="/storage/{{ $user->verification_doc_verso }}" alt="" /></td>
                                    <td>
                                        <button onclick="event.preventDefault();
                                        if (confirm('Confirmer la validation ?')) document.getElementById('user-accept-{{ $user->id }}').submit();" class="btn btn-primary">Accepter</button>
                                        <form id="user-accept-{{ $user->id }}" action="{{ route('kyc-verification-accept', [ 'id' => $user->id]) }}" method="POST">@csrf</form>
                                    </td>
                                    <td>
                                        <button onclick="event.preventDefault();
                                        if (confirm('Confirmer le rejet ?')) document.getElementById('user-refuse-{{ $user->id }}').submit();" class="btn btn-danger">Refuser</button>
                                        <form id="user-refuse-{{ $user->id }}" action="{{ route('kyc-verification-refuse', [ 'id' => $user->id]) }}" method="POST">@csrf</form>
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
