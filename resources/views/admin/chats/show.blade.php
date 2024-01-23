@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="card">
                    <div class="card-header">{{ __('Discussion') }}</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <br/>
                    @endif

                    <div class="container mt-5">
                        <ul class="list-group list-group-flush" id="messages-list"></ul>
                    </div>
                    <br>
                    <div class="container mb-2 mt-2">
                        <form action="{{ route('discussions.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="hidden" id="message-input" name="discussion" value="{{ $id }}"
                                       class="form-control">

                                <label for="message-input"></label>
                                <input type="text" id="message-input" name="message" placeholder="Votre message"
                                       class="form-control" required>
                                <input type="hidden" name="message_type" value="1" class="form-control" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .left {

        }

        .right {
            text-align: right;
        }

        .img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
    <script src="{{ asset("/js/jquery-3.7.0.min.js") }}"></script>
    <script>
        $(document).ready(function () {

            getMessages();
            setInterval(getMessages, 10000);

        });

        function getMessages() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/messages/" + {{ $id }},
                method: 'POST',
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response.messages);
                    const messages = response.messages;

                    const dom_messages = $("#messages-list");
                    dom_messages.html("")
                    for (let i = 0; i < messages.length; i++) {
                        const position = messages[i].user === {{ \Illuminate\Support\Facades\Auth::user()->id }} ? 'right' : 'list-group-item-dark left';
                        if (messages[i].message_type === 1) {
                            dom_messages.append(`<li class="list-group-item ${position}">${messages[i].message}</li>`);
                        } else {
                            dom_messages.append(`<li class="list-group-item ${position}"><img src="/storage/${messages[i].attachment}" class="img" alt="" /> </li>`);
                        }
                    }

                    const $target = $('html,body');
                    $target.animate({scrollTop: $target.height()}, 1000);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    </script>
@endsection
