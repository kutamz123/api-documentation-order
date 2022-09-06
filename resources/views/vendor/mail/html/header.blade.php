<tr>
<td class="header">
{{-- <a href="{{ $url }}" style="display: inline-block;"> --}}
@if (trim($slot) === 'Laravel')
<a href="https://ibb.co/YfnV0B0"><img src="https://i.ibb.co/YfnV0B0/radiologist.png" alt="radiologist" border="0"></a>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
