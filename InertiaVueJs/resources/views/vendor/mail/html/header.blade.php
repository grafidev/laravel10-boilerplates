@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === config('app.name'))
<div style="display: flex;flex-direction:column;align-items:center;">
    <img src="{{ url('images/card-oil.png') }}" class="logo" alt="Card Oil logo" style="object-fit: contain; margin-bottom: 15px;">
    <span>{{ config('app.name') }}</span>
</div>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
