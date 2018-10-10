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
@section('scripts')
    <script type="module" defer>
        import QrScanner from "/vendor/qr-scanner-master/src/qr-scanner.js";
        const video = document.getElementById('qr-video');
        const debugCheckbox = document.getElementById('debug-checkbox');
        const debugCanvas = document.getElementById('debug-canvas');
        const debugCanvasContext = debugCanvas.getContext('2d');
        const camQrResult = document.getElementById('cam-qr-result');
        const fileQrResult = document.getElementById('file-qr-result');
        console.log (video);

        function setResult(label, result) {
            label.textContent = result;
            label.style.color = 'teal';
            clearTimeout(label.highlightTimeout);
            label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
        }
        // ####### Web Cam Scanning #######
        const scanner = new QrScanner(video, result => setResult(camQrResult, result));
        scanner.start();

        // ####### debug mode related code #######
        debugCheckbox.addEventListener('change', () => setDebugMode(debugCheckbox.checked));
        function setDebugMode(isDebug) {
            const worker = scanner._qrWorker;
            worker.postMessage({
                type: 'setDebug',
                data: isDebug
            });
            if (isDebug) {
                debugCanvas.style.display = 'block';
                worker.addEventListener('message', handleDebugImage);
            } else {
                debugCanvas.style.display = 'none';
                worker.removeEventListener('message', handleDebugImage);
            }
        }
        function handleDebugImage(event) {
            const type = event.data.type;
            if (type === 'debugImage') {
                const imageData = event.data.data;
                if (debugCanvas.width !== imageData.width || debugCanvas.height !== imageData.height) {
                    debugCanvas.width = imageData.width;
                    debugCanvas.height = imageData.height;
                }
                debugCanvasContext.putImageData(imageData, 0, 0);
            }
        }
    </script>
@endsection
