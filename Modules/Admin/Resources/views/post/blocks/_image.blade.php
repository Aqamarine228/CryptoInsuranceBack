@push('styles')
    <link rel="stylesheet" href="{{Module::asset('admin:plugins/croppie/css/croppie.css')}}">
@endpush


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Image</h3>
    </div>
    <div class="card-body">
        <form id="post-update-image" action="{{ route('admin.post.update.image', $post->id) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <input id="x1" type="hidden" name="x1">
            <input id="y1" type="hidden" name="y1">
            <input id="width" type="hidden" name="width">
            <input id="height" type="hidden" name="height">
            <div class="form-group">
                <label for="exampleInputFile">Picture</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="picture" name="picture">
                        <label class="custom-file-label" for="picture">Choose file</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button form="post-update-image" class="btn btn-primary">Upload</button>
    </div>
    @if ($post->picture)
        <div class="card-body">
            <img class="img-fluid" src="{{ $post->originalImage() }}" alt="picture">
        </div>
    @endif
</div>

@push('scripts')
    <script src="{{ Module::asset('admin:plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script src="{{ Module::asset('admin:plugins/croppie/js/croppie.min.js')}}"></script>
    <script>
        let App = {
            fileId: '#picture',
            modalId: '#post-crop-image-modal',

            init: function () {
                this.listenForInputChange();
                this.listenForModalShow();
            },

            listenForModalShow: function () {
                $(this.modalId).on('shown.bs.modal', function (event) {
                    App.initCroppie()
                })
            },

            listenForInputChange: function () {
                $(this.fileId).change(function (e) {
                    var files = e.target.files || e.dataTransfer.files;
                    var file = files[0];
                    App.readImage(file);

                    $(App.modalId).modal();
                });
            },

            readImage: function (file) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    $(App.modalId + ' img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            },

            initCroppie: function () {
                var cropBoxData;
                var canvasData;
                var cropper;
                var image = document.getElementById('photo_upload');

                image.addEventListener('crop', (event) => {
                    let detail = event.detail;
                    document.getElementById('x1').value = parseInt(detail.x);
                    document.getElementById('y1').value = parseInt(detail.y);
                    document.getElementById('width').value = parseInt(detail.width);
                    document.getElementById('height').value = parseInt(detail.height);

                });
                cropper = new Cropper(image, {
                    aspectRatio: 16 / 9,
                    autoCropArea: 0.5,
                    viewMode: 1,
                    ready: function () {
                        cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    },
                });
            }
        }

        App.init();
    </script>
@endpush
