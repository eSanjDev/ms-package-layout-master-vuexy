@props(['type' => 'info', 'content' => '', 'dismissible' => true, 'additionalClass' => ''])

@php
    $colorClasses = [
        'success' => 'alert-success',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        'primary' => 'alert-primary',
        'secondary' => 'alert-secondary',
        'dark' => 'alert-dark',
    ];
    $colorClass = $colorClasses[$type] ?? 'alert-info';
@endphp

@if (!empty($content))
    <div class="alert {{ $colorClass }} @if($dismissible) alert-dismissible @endif {{ $additionalClass }}" role="alert">
        {{ $content }}

        @if($dismissible)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="show = false"></button>
        @endif
    </div>
@endif
