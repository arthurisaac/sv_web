@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Sliders') }}</div>
            
            
            <div class="container mt-5">
                <a href="{{ route("sliders.create") }}" class="btn btn-primary">Ajouter +</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Titre</td>
                            <td>Image</td>
                            <td>Date</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                        <tr>
                            <td>{{ $loop->index+1  }}</td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->file }}</td>
                            <td>{{ $slider->created_at }}</td>
                            <td>
                                <form action="{{ route('sliders.destroy', $slider->id)}}" method="post">
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
@endsection
