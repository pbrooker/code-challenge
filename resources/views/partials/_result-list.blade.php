<legend>{{ $type }}</legend>
<table class="table table-striped">
    @forelse ($items as $item)
    <tr>
        <td>
            <a href="{{ route('detail.show', ['type' => \strtolower($type), 'id' => $item['id'], 'name' => $item['name']]) }}"><img alt="{{ $item['name'] }}" style="float: left;margin-right: 10px;max-height: 60px;max-width: 60px;" src="{{ $item['imageUrl'] }}"></a>
        </td>
        <td>
            <a href="{{ route('detail.show', ['type' => \strtolower($type), 'id' => $item['id'], 'name' => $item['name']]) }}">{{ $item['name'] }}</a>
        </td>
    </tr>
    @empty
    <tr><td>No {{ $type }} results found</td></tr>
    @endforelse
</table>
