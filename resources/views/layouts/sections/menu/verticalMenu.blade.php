<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo me-1">
        @include('_partials.macros',["height"=>20])
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)

    {{-- adding active and open class if child is active --}}

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header fw-medium mt-4">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>

    @else

    {{-- active menu method --}}
    @php
      $activeClass = null;
      $currentRouteName =  Route::currentRouteName();

      if ($currentRouteName === $menu->slug) {
          $activeClass = 'active';
      }
      elseif (isset($menu->submenu)) {
        if (gettype($menu->slug) === 'array') {
          foreach($menu->slug as $slug){
            if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
              $activeClass = 'active open';
            }
          }
        }
        else{
          if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
            $activeClass = 'active open';
          }
        }

      }
    @endphp

    @php
    $user = \App\Models\User::with('role')->find(Illuminate\Support\Facades\Auth::id());
    $role = $user->role ? $user->role->role_id : null;
    @endphp
    @if($role == 1)
    {{-- main menu --}}
    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
          @if($menu->slug == 'ordering')
              @php
                $orderingCount = \App\Models\Order::where('order_status', 'P')->count();
              @endphp
              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{$orderingCount}}</div>
          @else
              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{$menu->badge[1]}}</div>
          @endif
        @endisset
      </a>

      {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
    </li>
    @else
    @if($menu->slug == 'ordering')
    <li class="menu-item {{$activeClass}}">

      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
          @if($menu->slug == 'ordering')
              @php
                $orderingCount = \App\Models\Order::where('order_status', 'P')->count();
              @endphp
              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{$orderingCount}}</div>
          @else
              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{$menu->badge[1]}}</div>
          @endif
        @endisset
      </a>
    </li>
    @endif
    @endif



    @endif
    @endforeach
  </ul>

</aside>
