@extends('oxygen::layouts.master-dashboard')

@section('content')
    {{ lotus()->pageHeadline('Dashboard') }}

    {{-- Example Breadcrumb. Remove this... --}}
{{--    {{ lotus()->breadcrumbs([--}}
{{--        ['Dashboard', route('dashboard')],--}}
{{--        ['Google', 'http://www.google.com'],--}}
{{--        ['Microsoft', 'http://www.microsoft.com'],--}}
{{--        ['Tesla', null, true]--}}
{{--    ]) }}--}}

    {{ lotus()->emptyStatePanel('Welcome to ' . config('app.name'), 'Today is ' . standard_date(now())) }}

    @if ($metrics->count())
        <div class="row mt-4">
            @foreach ($metrics as $metric)
                <div class="col">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title">{{ $metric['title'] }}</h5>
                            <h3>{{ number_format($metric['count']) }}</h3>
                            <p class="card-text">{{ $metric['description'] }}</p>
                            @if (!empty($metric['route']))
                                <a href="{{ route($metric['route']) }}" class="btn btn-primary">View Details</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@stop
