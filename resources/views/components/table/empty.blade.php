@props(['colspan' => 6, 'message' => 'No records found.'])

<tr class="table-empty">
    <td colspan="{{ $colspan }}">{{ $message }}</td>
</tr>
