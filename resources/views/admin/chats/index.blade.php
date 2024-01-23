@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('Discussions') }}</div>
                    <div class="mt-5">
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Utilisateur</td>
                                <td>Sujet</td>
                                <td>Date</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discussions as $discussion)
                                <tr>
                                    <td>{{ $discussion->id }}</td>
                                    <td>{{ $discussion->AlerteUserRegular->nom ?? "Utilisateur inexistant ou introuvable" }} {{ $discussion->AlerteUserRegular->prenom ?? "" }}</td>
                                    <td>{{ $discussion->subject }}</td>
                                    <td>{{ $discussion->created_at }}</td>
                                    <td>
                                        <a href="{{ route('discussions.show',$discussion->id)}}"
                                           class="btn btn-primary"></a>
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
