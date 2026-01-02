 <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('dashboard')}}"><i class="fa fa-home"></i> <span class="toggle-none">Dashboard</span></a>
 </li>
 <li class="nav-item {{ request()->is('spin*') ? 'active' : '' }}" aria-expanded="false">
    <a class="nav-link" href="javascript: void(0);" aria-expanded="true"><i class="fa fa-spinner"></i> 
    <span class="toggle-none">Spinning <span class="fa arrow"></span></span></a>
    <ul class="nav-second-level nav flex-column " aria-expanded="true">
       <li class="nav-item" ><a class="nav-link" href="{{route('spin/motor-prize')}}"><i class="fa fa-trophy" style="padding-right: 9px;"></i>Motorbike</a></li>
       <li class="nav-item"><a class="nav-link" href="{{route('spin/cash-prize')}}"><i class="fa fa-trophy" style="padding-right: 9px;"></i>Cash Prize</a></li>
       <li class="nav-item" ><a class="nav-link" href="{{route('spin/parasol-prize')}}"><i class="fa fa-trophy" style="padding-right: 9px;"></i>Parasol</a></li>
       <li class="nav-item" ><a class="nav-link" href="{{route('spin/water-bottle-prize')}}"><i class="fa fa-trophy" style="padding-right: 9px;"></i>Water Bottle</a></li>
    </ul>
 </li>
 <li class="nav-item {{ request()->is('reports/winner/*') ? 'active' : '' }}">
    <a class="nav-link" href="javascript: void(0);" aria-expanded="false"><i class="fa fa-area-chart"></i> <span class="toggle-none">Reports <span class="fa arrow"></span></span></a>
    <ul class="nav-second-level nav flex-column {{ request()->is('reports/winner/*') ? 'show' : '' }}" aria-expanded="false">
       <li class="nav-item"><a class="nav-link {{ request()->is('reports/winner/motor-prize') ? 'active' : '' }}" href="{{route('reports/winner/motor-prize')}}"><i class="fa fa-line-chart" style="padding-right: 9px;"></i>Winner Motorbike</a></li>
       <li class="nav-item"><a class="nav-link {{ request()->is('reports/winner/cash-prize') ? 'active' : '' }}" href="{{route('reports/winner/cash-prize')}}"><i class="fa fa-line-chart" style="padding-right: 9px;"></i>Winner Cash</a></li>
       <li class="nav-item"><a class="nav-link {{ request()->is('reports/winner/parasol-prize') ? 'active' : '' }}" href="{{route('reports/winner/parasol-prize')}}"><i class="fa fa-line-chart" style="padding-right: 9px;"></i>Winner Parasol</a></li>
       <li class="nav-item"><a class="nav-link {{ request()->is('reports/winner/water-bottle-prize') ? 'active' : '' }}" href="{{route('reports/winner/water-bottle-prize')}}"><i class="fa fa-line-chart" style="padding-right: 9px;"></i>Winner Water Bottle</a></li>
    </ul>
 </li>
 <li class="nav-item {{ request()->is('customer*') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('customer/index')}}"><i class="fa fa-upload" aria-hidden="true"></i> <span class="toggle-none">Upload Customer</span></a>
 </li>
 <li class="nav-item {{ request()->is('history*') ? 'active' : '' }}">
   <a class="nav-link" href="{{route('history')}}"><i class="fa fa-history" aria-hidden="true"></i><span class="toggle-none">History</span></a>
</li>
 