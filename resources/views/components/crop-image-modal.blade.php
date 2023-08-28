@php
    $modalId = $modalId ?? 'crop-image-modal';

    $pictureId = isset($pictureId) ? '#' . $pictureId : '#picture';
    $x1Id = $x1Id ?? 'x1';
    $y1Id = $y1Id ?? 'y1';
    $widthId = $widthId ?? 'width';
    $heightId = $heightId ?? 'height';
    $ratioWidth = $ratioWidth ?? '16';
    $ratioHeight = $ratioHeight ?? '9';
    $title = $title ?? 'Cut Image';
    $appName = \App\Actions\GenerateRandomOnlyCharString::execute(16);
    $uploadFieldName = \App\Actions\GenerateRandomOnlyCharString::execute(16);
@endphp
<div id="{{ $modalId }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>

                <button id="js_closePhoto" type="button" class="close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="margin: 0 auto;">
                <div class="img-container">
                    <img style="max-width: 100%;z-index:1000"
                         src="" alt="" id="{{$uploadFieldName}}" name="photo" multiple accept="image/*,image/jpeg">
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="/plugins/croppie/css/croppie.css">
@endpush

@push('scripts')
    <script src="/plugins/croppie/js/croppie.min.js"></script>
    <script>
        let {{$appName}} = {
            fileId: '{{ $pictureId }}',
            modalId: '#{{ $modalId }}',

            init: function () {
                this.listenForInputChange();
                this.listenForModalShow();
            },

            listenForModalShow: function () {
                $(this.modalId).on('shown.bs.modal', function (event) {
                    {{$appName}}.initCroppie()
                })
            },

            listenForInputChange: function () {
                $(this.fileId).change(function (e) {
                    var files = e.target.files || e.dataTransfer.files;
                    var file = files[0];
                    {{$appName}}.readImage(file);

                    $({{$appName}}.modalId).modal();
                });
            },

            readImage: function (file) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    $({{$appName}}.modalId + ' img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            },

            initCroppie: function () {
                var cropBoxData;
                var canvasData;
                var cropper;
                var image = document.getElementById('{{$uploadFieldName}}');

                image.addEventListener('crop', (event) => {
                    let detail = event.detail;
                    document.getElementById('{{ $x1Id }}').value = parseInt(detail.x);
                    document.getElementById('{{ $y1Id }}').value = parseInt(detail.y);
                    document.getElementById('{{ $widthId }}').value = parseInt(detail.width);
                    document.getElementById('{{ $heightId }}').value = parseInt(detail.height);

                });
                cropper = new Cropper(image, {
                    aspectRatio: {{$ratioWidth}} / {{$ratioHeight}},
                    autoCropArea: 0.5,
                    viewMode: 1,
                    ready: function () {
                        cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    },
                });
            }
        }

        {{$appName}}.init();
    </script>
@endpush
