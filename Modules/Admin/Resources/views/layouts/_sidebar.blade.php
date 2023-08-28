@php
    $referralRequestsCount = \Modules\Admin\Models\ReferralRequest::getPendingCount();
    $insuranceRequestsCount = \Modules\Admin\Models\InsuranceRequest::getPendingCount();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ Module::asset('admin:img/logo.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Insurance Admin</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.referral-request.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-certificate"></i>
                        <p>
                            Referral Requests
                            @if($referralRequestsCount > 0)
                                <span class="badge badge-info right">{{ $referralRequestsCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.insurance-request.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Insurance Requests
                            @if($insuranceRequestsCount > 0)
                                <span class="badge badge-info right">{{ $insuranceRequestsCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.insurance-option.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>
                            Insurance Options
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.insurance-pack.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Insurance Packs
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.insurance-subscription-option.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-subscript"></i>
                        <p>
                            Insurance Subscription Options
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.media-folder.index') }}" class="nav-link ">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            Images
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.post.all') }}" class="nav-link">
                        <i class="fas fa-newspaper nav-icon"></i>
                        <p>Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.post-category.index') }}" class="nav-link">
                        <i class="fas fa-project-diagram nav-icon"></i>
                        <p>Post Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.post-tag.index') }}" class="nav-link">
                        <i class="fas fa-tag nav-icon"></i>
                        <p>Post Tags</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
