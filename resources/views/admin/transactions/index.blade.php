@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Transactions enrolés') }}</div>
            
            
            <div class="p-2">
                <a href="{{ route('transaction.create') }}" class="btn btn-primary mb-2">Ajouter +</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Envoyeur</td>
                            <td>Receveur</td>
                            <td>Montant</td>
                            <td>Type</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionsEnroles as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->Sender->nom ?? "Admin" }} {{ $transaction->Sender->prenom ?? "" }}</td>
                            <td>{{ $transaction->Receiver->nom ?? "--" }} {{ $transaction->Receiver->prenom ?? "" }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="card mt-6">
            <div class="card-header">{{ __('Transactions partenaires') }}</div>
            
            
            <div class="container mt-5">
                {{-- <a href="{{ route('transaction.create') }}" class="btn btn-primary mb-2">Transférer d'un compte vers une partenaire</a> --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Envoyeur</td>
                            <td>Receveur</td>
                            <td>Montant</td>
                            <td>Type</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionsPartenaires as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->senderr->nom ?? "--" }} {{ $transaction->Receiver->prenom ?? "" }}</td>
                            <td>{{ $transaction->Receiver }} </td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
