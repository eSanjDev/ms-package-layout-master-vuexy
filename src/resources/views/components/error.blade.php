@props(['field'])

<div>
    @error($field)
    <div {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
        {{ $message }}
    </div>
    @enderror

    @error($field.".*")
    <div {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
        {{ $message }}
    </div>
    @enderror
</div>
