@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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

                <div class="card">
                    <div class="card-header">{{ __('Dépôt manuel vers un utilisateur') }}</div>

                    <div class="container mt-5">
                        <form action="{{ route("transaction.store") }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="receveur">Receveur</label>
                                <select id="receveur" name="receveur" class="form-control">
                                    <option></option>
                                    @foreach($enroles as $enrole)
                                        <option
                                            value="{{ $enrole->uniq }}">{{ $enrole->nom }} {{ $enrole->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="receiver">Receveur</label>
                                <input type="text" name="receiver" id="receiver" placeholder="Code Id de l'utilisateur"
                                       class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label for="amount">Montant à transférer</label>
                                <input type="number" name="amount" id="amount" min="1" placeholder="Montant"
                                       class="form-control"/>
                            </div>

                            <br>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('body-scripts')
        <script>
            $(document).ready(function () {
                $("#receveur").on("change", function () {
                    $("#receiver").val(this.value);
                })
            })
        </script>
    @endpush
@endsection
