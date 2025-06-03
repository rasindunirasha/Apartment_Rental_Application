@extends('oxygen::layouts.master-dashboard')

@section('breadcrumbs')
    {{ lotus()->breadcrumbs([
        ['Dashboard', route('dashboard')],
        // ['Change The Resource Name', route('<change here>')],
        [$pageTitle, null, true]
    ]) }}
@stop

@section('pageMainActions')
    @include('oxygen::dashboard.partials.searchField')

    @if ($canCreateEntities ?? false)
        <a href="{{ entity_resource_path() . '/create' }}" class="btn btn-success">
            <em class="fas fa-plus-circle"></em> Add New
        </a>
    @endif
@stop

<!-- DELETE THIS IF NOT USED
@section('pageSummary')
    <div>Content to be inserted at the bottom of the page</div>
@stop -->

@section('content')
    @include('oxygen::dashboard.partials.table-allItems', [
        'tableHeader' => [
            'ID', 'Code', 'Name', 'Created', 'Actions|text-end'
        ]
    ])

    @foreach ($allItems as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <a href="{{ entity_resource_path() . '/' . $item->id }}"
                   id="btn_code_{{ $item->id }}">{{ $item->code }}</a>
            </td>
            <td>
                <a href="{{ entity_resource_path() . '/' . $item->id }}"
                   id="btn_view_{{ $item->id }}">{{ $item->name }}</a>
            </td>
            <td>
                @if ($item->created_at)
                    {{ standard_datetime($item->created_at) }}
                @endif
            </td>
            <td class="text-end">
                <div class="btn-spaced">
                    @if ($canEditEntities ?? false)
                        <a href="{{ entity_resource_path() . '/' . $item->id . '/edit' }}"
                           id="btn_edit_{{ $item->id }}"
                           class="btn btn-warning js-tooltip"
                           title="Edit"><em class="fa fa-edit"></em> Edit</a>
                    @endif

                    @if (isset($isDestroyingEntityAllowed) && $isDestroyingEntityAllowed === true)
                        <form action="{{ entity_resource_path() . '/' . $item->id }}"
                              method="POST" class="form form-inline js-confirm-delete">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger js-tooltip"
                                    id="btn_delete_{{ $item->id }}"
                                    title="Delete"><em class="fa fa-times"></em> Delete</button>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@stop

