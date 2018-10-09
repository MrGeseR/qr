@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h1>Scan from WebCam:</h1>
                    <div>
                        <video muted autoplay playsinline id="qr-video"></video>
                        <canvas id="debug-canvas"></canvas>
                    </div>
                    <div>
                        <input type="checkbox" id="debug-checkbox">
                        <span>Show debug image</span>
                    </div>
                </div>
                <div class="card-footer">
                    <b>Detected QR code: </b>
                    <span id="cam-qr-result">None</span>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
