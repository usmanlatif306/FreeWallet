@php $action = new $action($dataType, $data); @endphp

@if ($action->shouldActionDisplayOnDataType())
    @can($action->getPolicy(), $data)
        @if ($action->getTitle() === 'Edit')
        <a href="{{ route('wallet.transaction.edit',$data->id) }}" title="{{ $action->getTitle() }}" {!! $action->convertAttributesToHtml() !!}>
            <i class="{{ $action->getIcon() }}"></i> <span class="hidden-xs hidden-sm">{{ $action->getTitle() }}</span>
        </a>
        @elseif ($action->getTitle() === 'Delete')
        <a href="{{ $action->getRoute($dataType->name) }}" title="{{ $action->getTitle() }}" {!! $action->convertAttributesToHtml() !!}>
            <i class="{{ $action->getIcon() }}"></i> <span class="hidden-xs hidden-sm">{{ $action->getTitle() }}</span>
        </a>   
        @else 
        {{-- for show --}}
        <a href="{{ route('wallet.transaction.show',$data->id) }}" title="{{ $action->getTitle() }}" {!! $action->convertAttributesToHtml() !!}>
            <i class="{{ $action->getIcon() }}"></i> <span class="hidden-xs hidden-sm">{{ $action->getTitle() }}</span>
        </a> 
        @endif
        {{-- route('wallet.transaction.delete',$data->id) --}}
    @endcan
@endif