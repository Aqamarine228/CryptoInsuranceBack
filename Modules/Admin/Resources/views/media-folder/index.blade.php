@extends('admin::layouts.master')

@push('styles')
    <style>
        td {
            vertical-align: middle !important;
        }

        .image-url {
            display: none;
        }

        .file-manager .image-preview {
            height: 50px;
            width: 50px;
        }

        .full-height {
            height: calc(100% - 15px);
        }

        .file-manager .dropdown {
            position: absolute;
            top: 0;
            right: 0;
        }
    </style>
@endpush

@section('title')
    Media
    <a data-toggle="modal" data-target="#create-folder-modal" class="btn btn-sm btn-primary">Create Folder</a>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item active">Media</li>
@stop

@section('content')

    @if ($rootFolder !== null)
        <div class="row mb-2">
            <div class="col-md-12">
                <button data-toggle="modal" data-target="#upload-image-modal" class="btn btn-primary btn-sm"><i
                        class="fa fa-upload"></i> Upload Image
                </button>
            </div>
        </div>
        @include('admin::media-folder._upload-image-modal')

    @endif
    <div class="row file-manager">
        @if ($rootFolder !== null)
            @component('admin::media-folder._preview', [
                'title' => 'Back',
                'link' => route('admin.media-folder.index', ['id' => $rootFolder->media_folder_id]),
            ])
                <i class="fa fa-level-up-alt fa-3x"></i>
            @endcomponent
        @endif
        @foreach($subFolders as $folderItem)
            @component('admin::media-folder._preview', [
               'title' => $folderItem->name,
               'link' => route('admin.media-folder.index', $folderItem->id),
            ])
                <i class="fa fa-folder fa-3x"></i>
            @endcomponent
        @endforeach
        @foreach($images as $image)
            @component('admin::media-folder._preview', [
              'title' => $image->name,
              'link' => '#',
            ])
                @slot('adds')
                    <div class="dropdown">
                        <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-expanded="false">
                            ...
                        </button>
                        <p class="image-url" id="p{{ $image->id }}">{{ $image->getFullUrl() }}</p>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a onclick="copyToClipboard(this, '#p{{ $image->id }}')" class="dropdown-item">Copy Url</a>
                        </div>
                    </div>
                @endslot
                <img class="image-preview" src="{{ $image->getFullUrl() }}">
            @endcomponent
        @endforeach
    </div>
    @include('admin::media-folder._create-folder-modal')
@stop
