<header class="fixed left-0 right-0 top-0 z-30 flex h-20 w-full items-center bg-primary-100 md:hidden">
  @livewire('AuthModal')
  <ul class="mx-2 mt-4 flex w-full items-center space-x-2">
    <li class="w-1/3">
      <a href="{{ route('home') }}" @class([
          'flex items-center rounded  px-2 py-1',
          'bg-primary-600 text-white' => $this->page === 'Home',
          'border-primary-600 text-primary-600' =>
              $this->page === 'Pins' || $this->page === 'Rails',
      ])>
        <i class="fas fa-home mr-2"></i> Home
      </a>
    </li>
    <li class="w-1/3">
      <a href="{{ route('pins') }}" @class([
          'flex items-center rounded  px-2 py-1',
          'bg-primary-600 text-white' => $this->page === 'Pins',
          'border-primary-600 text-primary-600' =>
              $this->page === 'Home' || $this->page === 'Rails',
      ])>
        <i class="fas fa-thumbtack mr-2"></i> Pins
      </a>
    </li>
    <li class="w-1/3">
      <a href="{{ route('rails') }}" @class([
          'flex items-center rounded  px-2 py-1',
          'bg-primary-600 text-white' => $this->page === 'Rails',
          'border-primary-600 text-primary-600' =>
              $this->page === 'Home' || $this->page === 'Pins',
      ])>
        <i class="fa-solid fa-train mr-2"></i> Rails
      </a>
    </li>
  </ul>
</header>

<nav class="hidden h-80 w-40 rounded bg-white p-4 shadow-sm md:block">
  @livewire('AuthModal')
  <ul class="space-y-2">
    <li>
      <a class="bg-primary-600 text-white" href="#">
        <a href="{{ route('home') }}" @class([
            'flex items-center rounded p-2',
            'bg-primary-600 text-white' => $this->page === 'Home',
            'bg-white  text-primary-600 hover:bg-primary-100' =>
                $this->page === 'Pins' || $this->page === 'Rails',
        ])>
          <i class="fas fa-home mr-2"></i> Home
        </a>
    </li>
    <li>
      <a href="{{ route('pins') }}" @class([
          'flex items-center rounded p-2',
          'bg-primary-600 text-white' => $this->page === 'Pins',
          'bg-white  text-primary-600 hover:bg-primary-100' =>
              $this->page === 'Home' || $this->page === 'Rails',
      ])>
        <i class="fas fa-thumbtack ml-1 mr-3"></i> Pins
      </a>
    </li>
    <li>
      <a href="{{ route('rails') }}" @class([
          'flex items-center rounded p-2',
          'bg-primary-600 text-white' => $this->page === 'Rails',
          'bg-white  text-primary-600 hover:bg-primary-100' =>
              $this->page === 'Home' || $this->page === 'Pins',
      ])>
        <i class="fa-solid fa-train ml-1 mr-3"></i> Rails
      </a>
    </li>
    @auth
      <li>
        <a href="{{ route('setting') }}" @class([
            'flex items-center rounded p-2',
            'bg-primary-600 text-white' => $this->page === 'Setting',
            'bg-white  text-primary-600 hover:bg-primary-100' =>
                $this->page === 'Home' ||
                $this->page === 'Pins' ||
                $this->page === 'Rails',
        ])>
          <i class="fa-solid fa-gear ml-1 mr-3"></i> Setting
        </a>
      </li>
    @endauth
  </ul>
</nav>
