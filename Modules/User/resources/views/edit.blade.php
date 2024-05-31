<x-default-layout>

    @section('title')
        Create new User
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user.create') }}
    @endsection
    <form action="{{route('user.update',$object->uuid)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-bordered">
                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id=""
                                    aria-describedby="helpId"
                                    placeholder="Enter the name"
                                    value="{{$object->name}}"
                                />
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="name@example.com"
                                value="{{$object->email}}"
                                autocomplete="email">
                            </div>
                        </div>

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
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(/assets/media/svg/avatars/blank.svg)">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(/assets/media/avatars/300-1.jpg)"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Change avatar">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                            <!--begin::Inputs-->
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->

                        <!--begin::Cancel button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Cancel avatar">
                            <i class="ki-outline ki-cross fs-3"></i>
                        </span>
                        <!--end::Cancel button-->

                        <!--begin::Remove button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Remove avatar">
                            <i class="ki-outline ki-cross fs-3"></i>
                        </span>
                        <!--end::Remove button-->
                    </div>
                    {{-- <input type="file" name="avatar" id=""> --}}
                    <!--end::Image input-->
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

