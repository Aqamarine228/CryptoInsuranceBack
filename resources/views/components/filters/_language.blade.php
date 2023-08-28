<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-filter"></i> Filters
    </button>
    <div class="dropdown-menu dropdown-menu-lg">
        <form id="filters-set" action="" method="get">
            <div class="card-body mt-3">
                @include('admin::components.input_group', [
                     'type' => 'select',
                     'name' => 'lang',
                     'required' => false,
                     'label' => 'By Language',
                     'items' => $languages->pluck('name', 'code'),
                     'defaultValue' => request()->get('lang'),
                     'defaultPlaceholderValue' => 'All'
                 ])
            </div>
            <div class="dropdown-divider"></div>
        </form>

        <div class="p-3">
            <div class="row">
                <div class="col-sm-6">
                    <button form="filters-set" class="btn btn-sm btn-primary">Apply Filters</button>
                </div>
                <div class="col-sm-6">
                    <form id="filters-reset"
                          action=""
                          method="get"
                    >
                    </form>
                    <button form="filters-reset" class="btn btn-sm btn-danger float-right">Reset Filters</button>
                </div>
            </div>
        </div>
    </div>
</div>
