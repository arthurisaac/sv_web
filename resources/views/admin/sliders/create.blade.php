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
                    <div class="card-header">{{ __('Slider') }}</div>


                    <div class="container mt-5">
                        <form action="{{ route("sliders.store") }}" method="post"  enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="titre" placeholder="Titre" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>File</label>
                                <input type="file" name="file" placeholder="Fichier" class="form-control" />
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
@endsection
