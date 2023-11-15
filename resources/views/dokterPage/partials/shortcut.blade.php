<nav class="shortcut-menu d-none d-sm-block">
    <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
    <label for="menu_open" class="menu-open-button ">
        <span class="app-shortcut-icon d-block"></span>
    </label>
    <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
        <i class="fal fa-arrow-up"></i>
    </a>
    <form action="/logout" method="post" class="menu-item btn" data-toggle="tooltip" data-placement="left"
        title="Logout">
        @csrf
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
        {{-- <button type="submit" class="menu-item btn">
            <i class="fal fa-sign-out"></i>
        </button> --}}
        <button type="submit" class="btn p-0 text-white">
            <i class="fal fa-sign-out"></i>
        </button>
    </form>
    <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left"
        title="Full Screen">
        <i class="fal fa-expand"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left"
        title="Print page">
        <i class="fal fa-print"></i>
    </a>
</nav>
