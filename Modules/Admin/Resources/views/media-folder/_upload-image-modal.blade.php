<div id="upload-image-modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="upload-images-form" class="form-inline" action="{{ route('admin.media-folder.image.store') }}"
                      enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="media_folder_id" value="{{ $rootFolder->id }}">
                        <input type="file" name="images[]" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button form="upload-images-form" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>
