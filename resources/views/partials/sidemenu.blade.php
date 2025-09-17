




<nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header" style="display:flex; justify-content:center;">
          <a href="{{ route('home') }}" class="b-brand text-primary">            
            <img src="{{asset('assets/images/logo-black.png')}}" class="img-fluid logo-lg" alt="logo" style="height:66px !important;">
          </a>      
      </div>
      <div class="navbar-content">
        <div class="simplebar-wrapper" style="margin: -10px 0px;">
          <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
          </div>
          <div class="simplebar-mask">
            <div class="simplebar-offset pc-trigger" style="right: 0px; bottom: 0px;">
              <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll; display: block;">
                <div class="simplebar-content pc-trigger active" style="padding: 10px 0px;">
                    <div style="display:flex; justify-content:center;">
                          <!--<h5>Academia Saber</h5>-->
                        <!--<a href="{{ route('home') }}">
                          <img src="" title="Logo Academia Saber" class="img-thumbnail" style="max-height:100px;margin:10px;">
                        </a>-->
                    </div>
                    <ul class="pc-navbar" style="display: block;">                  
                    @foreach ($menuitems as $key => $item)
                        @if (!empty($item['submenu']))
                            <li class="pc-item pc-hasmenu {{ $key }} @if ($key == $imenu1)  active pc-trigger @endif">
                                <a class="pc-link" href="#!">
                                    <span class="pc-micon"><i class="{{ $item['icon'] }}"></i></span>
                                    <span class="pc-mtext">{{ $item['label'] }}</span>
                                </a>
                                <ul class="pc-submenu">
                                    @foreach ($item['submenu'] as $keysub => $itemsub)
                                        <li class="pc-item {{ $keysub }} @if ($key == $imenu1 && $keysub == $imenu2) active @endif" data-submenu="{{ $keysub }}">
                                            <a class="pc-link" href="{{ url($itemsub['url']) }}">
                                                <i class="{{ $itemsub['icon'] }}"></i>&nbsp;<span>{{ $itemsub['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="pc-item {{ $key }} @if ($key == $imenu1) active @endif" data-submenu="sin-submenu">
                                <a class="pc-link" href="{{ url($item['url']) }}">
                                    <span class="pc-micon"><i class="{{ $item['icon'] }}"></i></span>
                                    <span class="pc-mtext">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                                      
  
  
  
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
  
      </div>
    </div>
  </nav>