<div class="card-title">
    <!--begin::Search-->

    <div class="d-flex align-items-center position-relative my-1">
        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                class="path2"></span></i> <input type="text" data-kt-filter="search"
            class="form-control form-control-solid w-250px ps-13" placeholder="Search user">
    </div>
    <!--end::Search-->
    <!--begin::Export buttons-->
    <div id="kt_datatable_example_1_export" class="d-none"></div>
    <!--end::Export buttons-->
</div>
<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
    <!--begin::Export dropdown-->
    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
        <i class="ki-duotone ki-exit-up fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>Export</button>
    <button type="button" class="btn btn-info " data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
        Filter
    </button>
    <!--begin::Menu-->
    <div id="kt_datatable_example_export_menu"
        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
        data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="copy">
                Copy to clipboard
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="excel">
                Export as Excel
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="csv">
                Export as CSV
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="pdf">
                Export as PDF
            </a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->
    <!--end::Export dropdown-->
    <!--begin::Hide default export buttons-->
    <div id="kt_datatable_example_buttons" class="d-none"></div>
</div>
