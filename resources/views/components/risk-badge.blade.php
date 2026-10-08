@props(['level', 'urgent' => false, 'size' => 'xs'])

@php
    $sizeClass = $size === 'sm' ? 'px-3 py-1 text-sm' : 'px-2 py-1 text-xs';
@endphp

@if ($urgent)
    <span class="{{ $sizeClass }} rounded-full bg-red-600 text-white font-semibold">URGENT</span>
@endif

@if ($level === 'medium_high')
    <span class="{{ $sizeClass }} rounded-full bg-orange-100 text-orange-800 border border-orange-300">
        {{ $size === 'sm' ? 'Medium to High Risk' : 'Medium to High' }}
    </span>
@else
    <span class="{{ $sizeClass }} rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
        {{ $size === 'sm' ? 'Low Risk' : 'Low' }}
    </span>
@endif