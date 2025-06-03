@php
    \Navigator::addItem([
        'text' => 'Countries',
        'icon_class' => 'fas fa-flag',
        'resource' => 'manage.countries.index'
    ]);

    \Navigator::addItem([
    'text' => 'Cities',
    'icon_class' => 'fas fa-city',
    'resource' => 'manage.cities.index'
    ], 'default');

    \Navigator::addItem([
        'text' => 'Apartments',
        'icon_class' => 'fas fa-building',
        'resource' => 'manage.apartment.index' 
    ],'default');

    \Navigator::addItem([
        'text' => 'Inquiries',
        'icon_class' => 'fas fa-envelope',
        'resource' => 'manage.inquiries.index'
    ], 'default');

    \Navigator::addItem([
        'text' => 'Files',
        'icon_class' => 'fas fa-file-upload',
        'resource' => 'manage.files.index'
    ], 'default');

    \Navigator::addItem([
        'text' => 'Users',
        'icon_class' => 'fas fa-users',
        'resource' => 'manage.users.index'
    ], 'sidebar.manage');

    \Navigator::addItem([
        'text' => 'API',
        'icon_class' => 'fas fa-plug',
        'resource' => 'manage.documentation.index'
    ], 'sidebar.manage');

    \Navigator::addItem([
        'text' => 'Permissions',
        'icon_class' => 'fas fa-user-shield',
        'resource' => 'manage.access.index'
    ], 'sidebar.manage');

    // Optional example:
    // \Navigator::addItem([
    //     'text' => 'API',
    //     'icon_class' => 'fas fa-plug',
    //     'url' => '/dashboard',
    //     'permission' => 'view-dashboard',
    //     'order' => 2,
    // ], 'sidebar.manage');
@endphp

<ul class="nav">
    <li class="nav-title">Navigation</li>
    <li>
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @include('oxygen::dashboard.partials.NavBar', ['navBar' => 'default'])

    <li class="nav-title">Admin</li>

    @include('oxygen::dashboard.partials.NavBar', ['navBar' => 'sidebar.manage'])

    <li>
        <a href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>
