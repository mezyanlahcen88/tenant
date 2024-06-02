<x-default-layout>
    @section('breadcrumb')
        @include('components.breadcrumb-list', [
            'title' => trans('translation.user_action_add'),
            'listPermission' => 'user-list',
            'listRoute' => route('user.index'),
            'listText' => trans('translation.user_form_users_list'),
        ])
    @endsection
    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h3 class="card-title">Title</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <x-input-field cols="col-md-6" divId="first_name" column="first_name" model="user"
                                optional="text-danger" inputType="text" className="" columnId="first_name"
                                columnValue="{{ old('first_name') }}" attribute="required" readonly="false" />
                            <x-input-field cols="col-md-6" divId="last_name" column="last_name" model="user"
                                optional="text-danger" inputType="text" className="" columnId="last_name"
                                columnValue="{{ old('last_name') }}" attribute="required" readonly="false" />
                            <x-input-field cols="col-md-6" divId="email" column="email" model="user"
                                optional="text-danger" inputType="text" className="" columnId="email"
                                columnValue="{{ old('email') }}" attribute="required" readonly="false" />
                            <x-input-field cols="col-md-6" divId="password" column="password" model="user"
                                optional="text-danger" inputType="text" className="" columnId="password"
                                columnValue="{{ old('password') }}" attribute="required" readonly="false" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">picture</h3>

                    </div>
                    <div class="card-body">
                        <x-image-field :background-url="url('/assets/media/svg/avatars/blank.svg')" :image-url="url('/assets/media/avatars/300-1.jpg')" avatar-name="picture" />

                    </div>

                </div>
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
        </div>

    </form>
    @push('scripts')
    @endpush
</x-default-layout>
