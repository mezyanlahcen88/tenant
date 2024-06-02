<x-default-layout>
    @section('breadcrumb')
        @include('components.breadcrumb', [
            'title' => trans('translation.user_form_manage_users'),
            'createPermission' => 'user-create',
            'createRoute' => route('user.create'),
            'createText' => trans('translation.user_action_add'),
            'deletedPermission' => 'user-trashed',
            'deletedRoute' => route('user.trashed'),
            'deletedText' => trans('translation.user_form_deleted_users_list'),
        ])
    @endsection
    <div class="card">
        <div class="card-header border-0">
            @include('components.datatable-header')
        </div>
        <div class="card-body mt-n5">
            @include('user::table', [
                'model' => 'user',
            ])
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('assets/custom_js/delete.js') }}"></script>
        <script src="{{ asset('assets/custom_js/datatable.js') }}"></script>
    @endpush
</x-default-layout>
