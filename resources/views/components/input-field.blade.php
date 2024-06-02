<div class="{{$cols}} my-1 {{ $divID ?? '' }}">
        <label for={{ $column }} class="form-label">{{ trans('translation.'.$model.'_form_'.$column) }} &nbsp;<span class="{{ $optional }}">*</span></label>
        <input type="{{ $inputType }}" class="form-control {{ $className ?? '' }} @error($column) is-invalid @enderror" name="{{ $column }}"
            id="{{ $columnId ?? '' }}"
            aria-describedby="helpId"
            placeholder="{{ trans('translation.'.$model.'_form_'.$column.'_placeholder') }}"
            value="{{ $columnValue }}"
            {{ $attribute ?? '' }}
            {{$readonly ?? ''}}>
    @error($column)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <div>
        <span class="help-block error-help-block error"  id="error-{{ $column }}"></span>
    </div>
    </div>


