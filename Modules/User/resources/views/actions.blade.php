
    <div class="d-flex justify-content-center gap-2">
      {{-- @endcan --}}
        {{-- @can('client-edit') --}}
            <div class="edit">
                <a href="{{ route('user.edit', $object->uuid)}}" title="Edit"><span class="badge  badge-primary"><i class="las la-edit text-white"></i></span></a>
                </a>
            </div>
        {{-- @endcan --}}
        {{-- @can('client-delete') --}}
            <div class="remove">
                <a href="#" class="remove-item-btn" data-bs-toggle="modal"
                data-id="{{ $object->uuid }}" data-route-name="{{ route('user.destroy', 'delete') }}">
              <span class="badge  badge-danger"><i class="las la-trash text-white"></i></span></a>
            </div>
        {{-- @endcan --}}
    </div>

