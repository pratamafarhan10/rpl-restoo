@extends('layouts.dapur.app', ['title' => 'List Makanan'])

@section('content')
<div class="container-md">
    <!-- Menu Editor -->
    <div class="row my-3">
        <h1 class="text-center title-fitur">List <strong>Makanan</strong></h1>
    </div>
    @asyncWidget('tim_dapur')
</div>


@endsection