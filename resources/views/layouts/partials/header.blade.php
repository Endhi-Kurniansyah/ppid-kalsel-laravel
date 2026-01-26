{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        {{-- LOGO --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ isset($globalSettings['site_logo']) ? asset('storage/' . $globalSettings['site_logo']) : asset('assets/static/images/logo/favicon.svg') }}"
                 alt="Logo Nav" style="height: 50px;">
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @if(isset($navbarMenus))
                    @foreach($navbarMenus as $menu)
                        <li class="nav-item {{ $menu->children->count() > 0 ? 'dropdown' : '' }}">
                            <a class="nav-link {{ $menu->children->count() > 0 ? 'dropdown-toggle' : '' }}"
                               href="{{ $menu->children->count() > 0 ? '#' : url($menu->url) }}"
                               @if($menu->children->count() > 0)
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false"
                               @endif>
                                {{ $menu->name }}
                            </a>

                            @if($menu->children->count() > 0)
                                {{-- DROPDOWN MENU (Rounded & Shadow) --}}
                                <ul class="dropdown-menu animate slideIn">
                                    @foreach($menu->children as $child)
                                        <li>
                                            <a class="dropdown-item" href="{{ url($child->url) }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</nav>
