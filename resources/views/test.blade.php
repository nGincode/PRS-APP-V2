@extends('layout')

@section('isi')
    <div id="app">
        <section class="content">
            <div class="container-fluid">

                <olahan></olahan>

            </div>
        </section>
    </div>

    {{-- Vue Js Broo --}}
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
