<script src="{{ Module::asset('admin:plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ Module::asset('admin:js/adminlte.min.js') }}"></script>
<script>
    $(document).ready(function () {
        //option A
        $("button[data-ask=1]").click(function (e, params) {
            let localParams = params || {};
            if (!localParams.send) {
                e.preventDefault();
            }
            let button = this;

            Swal.fire({
                title: $(button).data('title'),
                text: $(button).data('message'),
                icon: $(this).data('type') ? $(this).data('type') : 'warning',
                input: $(this).data('input') ? $(this).data('input') : false,
                showCancelButton: true,
                confirmButtonColor: $(this).data('confirm-button-color') ? $(this).data('confirm-button-color') : "#1e88e5",
                confirmButtonText: $(this).data('confirm-button-text') ? $(this).data('confirm-button-text') : 'Confirm',
                cancelButtonColor: $(this).data('cancel-button-color') ? $(this).data('cancel-button-color') : "grey",
                cancelButtonText: $(this).data('cancel-button-text') ? $(this).data('cancel-button-text') : 'Cancel',
                // closeOnConfirm: false,
                // closeOnCancel: false,
                showLoaderOnConfirm: true,
                preConfirm: function (amount) {
                    if (amount && $(this).data('form-id')) {

                        let formId = $(this).data('form-id');
                        let inputName = $(this).data('input-name');
                        $('#' + formId + ' input[name = ' + inputName + ']').val(amount);
                    }
                    $(this).trigger('click', {send: true});
                },
                // allowOutsideClick: () => !swal.isLoading()
            }).then((results) => {
                if (results.isConfirmed) {
                    $(`#${$(button).data('form-id')}`).submit()
                }
            });
        });
    });

    function initTinymce(selector, height, toolbar, plugins, uploadFilesConfig = {}) {
        let config = {
            // extended_valid_elements: "+@[data-options]",
            setup: function (editor) {
                editor.on('init', function (args) {
                    editor_id = args.target.id;
                });
                editor.addButton('glossary', {
                    text: 'Add glossary',
                    icon: false,
                    onclick: function () {
                        // Open window
                        editor.windowManager.open({
                            title: 'Example plugin',
                            body: [
                                {type: 'textbox', name: 'title', label: 'Title'},
                                {type: 'textbox', name: 'content', label: 'Content'}
                            ],
                            onsubmit: function (e) {
                                // Insert content when the window form is submitted
                                // editor.insertContent('Title: ' + e.data.title);
                                editor.insertContent('<span class="glossary" data-content="' + e.data.content + '">' + e.data.title + '</span>');
                            }
                        });
                    }
                });
            },
            selector: selector,
            theme: "modern",
            height: height,
            style_formats: [
                {
                    title: 'Headers',
                    items: [
                        {title: 'Header 1', format: 'h1'},
                        {title: 'Header 2', format: 'h2'},
                        {title: 'Header 3', format: 'h3'},
                        {title: 'Header 4', format: 'h4'},
                        {title: 'Header 5', format: 'h5'},
                        {title: 'Header 6', format: 'h6'}
                    ]
                },
                {title: 'Highlight', inline: 'span', classes: 'highlight'},
            ],
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            plugins: plugins,
            images_upload_url: '{{route('admin.media-folder.image.store-from-tinymce')}}',
            images_upload_base_path: '{{config('images.media.url')}}',
            images_upload_credentials: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            toolbar: toolbar,
        }
        if (uploadFilesConfig.sourceId) {
            config.images_upload_handler = function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{route('admin.media-folder.image.store-from-tinymce')}}');

                xhr.onload = function () {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    var json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob());
                formData.append('source_id', uploadFilesConfig.sourceId);
                formData.append('folder_id', uploadFilesConfig.folderId);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                xhr.send(formData);
            };
        }
        tinymce.init(config);

        tinymce.PluginManager.add('charactercount', function (editor) {
            var _self = this;

            function update() {
                editor.theme.panel.find('#charactercount').text(['{0} Characters', _self.getCount()]);
            }

            editor.on('init', function () {
                var statusbar = editor.theme.panel && editor.theme.panel.find('#statusbar')[0];

                if (statusbar) {
                    window.setTimeout(function () {
                        statusbar.insert({
                            type: 'label',
                            name: 'charactercount',
                            text: ['{0} CHARACTERS', _self.getCount()],
                            classes: 'charactercount',
                            disabled: editor.settings.readonly
                        }, 0);

                        editor.on('setcontent beforeaddundo keyup', update);
                    }, 0);
                }
            });

            _self.getCount = function () {
                // var tx = editor.getContent({ format: 'raw' });
                // var decoded = decodeHtml(tx);
                // var decodedStripped = decoded.replace(/(<([^>]+)>)/ig, '');
                //
                // var tc = decodedStripped.length;
                // return tc;
                var tx = editor.getContent({format: 'raw'});
                var decodedStripped = tx.replace(/(<([^>]+)>)/ig, '');
                var decoded = decodeHtml(decodedStripped);

                var tc = decoded.length;
                return tc;
            };

            function decodeHtml(html) {
                var txt = document.createElement('textarea');
                txt.innerHTML = html;
                return txt.value;
            }
        });

        tinyMCE.PluginManager.add('stylebuttons', function (editor, url) {
            let name = 'h1';

            editor.addButton('style-' + name, {
                tooltip: 'Header ' + name,
                text: name.toUpperCase(),
                onClick: function () {
                    editor.execCommand('mceToggleFormat', false, name);
                },
                onPostRender: function () {
                    var self = this, setup = function () {
                        editor.formatter.formatChanged(name, function (state) {
                            self.active(state);
                        });
                    };
                    editor.formatter ? setup() : editor.on('init', setup);
                }
            })
        });

    }
</script>
@stack('scripts')
