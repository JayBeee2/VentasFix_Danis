@if($errors->has('general'))
    <div class="alert alert-danger mb-4">
        {{ $errors->first('general') }}
    </div>
@endif 