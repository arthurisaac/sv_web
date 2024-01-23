@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Discussion') }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <h6>Messages</h6>
                </div>
                <div class="card-body p-3">
                    @foreach($messages as $message)
                        <div style="padding: 10px;width: 100%" class="border-bottom d-flex">
                            <div>
                                <img
                                    src="https://ui-avatars.com/api/?name={{ $message->alerteUser->nom ?? "" }}+{{ $message->alerteUser->prenom ?? "I"}}"
                                    alt="">
                            </div>
                            <div style="margin-left: 20px">
                                {{ $message->message }} <br>
                                <small>Par <a href=""
                                              class="btn-link">{{ $message->alerteUser->nom }}{{ $message->alerteUser->prenom }}
                                </small>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <form action="{{ route('messaging.respond') }}" method="post">
                @csrf

                <input type="text" class="form-control" name="message" placeholder="message" value="hello">
                <input type="hidden" value="{{ $user }}" name="user">
                <input type="hidden" value="1" name="message_type">
                <input type="hidden" value="" name="attachment">
                <button class="btn btn-sm btn-primary" type="submit">
                    Envoyer
                </button>
            </form>

        </div>
    </div>
@endsection
