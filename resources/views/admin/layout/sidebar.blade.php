     <!-- Sidebar Start -->
     <div class="sidebar pe-4 pb-3">
        <nav class="navbar">
            {{-- <a href="index.html" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
            </a> --}}
            @auth
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="{{asset('admin/img/user2.png')}}" alt="" style="width: 40px; height: 40px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </div>
                <div class="ms-3">
                    <h6 class="mt-2 text-white">{{auth()->user()->name}}</h6>
                    <p class="mt-2">{{auth()->user()->role}}</span>
                </div>
            </div>


            <div class="navbar-nav w-100">
                <a href="{{route('dashboard')}}" class="nav-item nav-link {{Route::is('dashboard') ? 'active' : ''}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('contacttypes*') || Route::is('contacts*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-address-book me-2"></i>Contact</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('contacttypes*') || Route::is('contacts*')  ? 'show' : ''}}">
                        <a href="{{route('contacts.create')}}" class="dropdown-item {{Route::is('contacts.create') ? 'active' : ''}}">Add Contact</a>
                        <a href="{{route('contacts.index')}}" class="dropdown-item {{Route::is('contacts.index') ? 'active' : ''}}">Contacts</a>  
                        <a href="{{route('contacttypes.index')}}" class="dropdown-item {{Route::is('contacttypes.index') ? 'active' : ''}}">Contact Types</a>       
                    </div>
                </div> 
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('domains*') || Route::is('public_free_domain')  || Route::is('domain_types*') || Route::is('domain_statuses*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-link me-2"></i>Domain</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('domains*')  || Route::is('public_free_domain')  || Route::is('domain_types*') || Route::is('domain_statuses*') ? 'show' : ''}}">
                        <a href="{{route('domains.create')}}" class="dropdown-item {{Route::is('domains.create') ? 'active' : ''}}">Add Domain</a>  
                        <a href="{{route('domains.index')}}" class="dropdown-item {{Route::is('domains.index') ? 'active' : ''}}">Private Domains</a>   
                        <a href="{{route('public_free_domain')}}" class="dropdown-item {{Route::is('public_free_domain') ? 'active' : ''}}">Public-Free Emails</a> 
                        <a href="{{route('domain_types.index')}}" class="dropdown-item {{Route::is('domain_types.index') ? 'active' : ''}}">Domain Types</a>  
                        <a href="{{route('domain_statuses.index')}}" class="dropdown-item {{Route::is('domain_statuses.index') ? 'active' : ''}}">Domain Status</a>    
                    </div>
                </div> 

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('companies*') || Route::is('additional_companies*') || Route::is('company_chillds*') || Route::is('trade_references*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-building me-2"></i>Company</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('companies*') || Route::is('additional_companies*') || Route::is('company_chillds*') || Route::is('trade_references*') ? 'show' : ''}}">
                        <a href="{{route('companies.create')}}" class="dropdown-item {{Route::is('companies.create') ? 'active' : ''}}">Add Company</a>
                        <a href="{{route('companies.index')}}" class="dropdown-item {{Route::is('companies.index') || Route::is('companies.show') ? 'active' : ''}}">Companies</a>
                        <a href="{{route('additional_companies.index')}}" class="dropdown-item {{Route::is('additional_companies.index') ? 'active' : ''}}">Additional Names</a>
                        <a href="{{route('company_chillds.index')}}" class="dropdown-item {{Route::is('company_chillds.index') ? 'active' : ''}}">Sister Concerns</a>
                        <a href="{{route('trade_references.index')}}" class="dropdown-item {{Route::is('trade_references.index') ? 'active' : ''}}">Trade References</a>
                    </div>
                </div>  
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('countries*') || Route::is('area_infos*') || Route::is('area_billing_incriments*') || Route::is('regions*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-flag me-2"></i>Area</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('countries*') || Route::is('area_infos*') || Route::is('area_billing_incriments*') || Route::is('regions*') ? 'show' : ''}}">
                        {{-- <a href="{{route('countries.create')}}" class="dropdown-item {{Route::is('countries.create') ? 'active' : ''}}">Add Country</a> --}}
                        <a href="{{route('countries.index')}}" class="dropdown-item {{Route::is('countries*') ? 'active' : ''}}">Countries</a>
                        <a href="{{route('area_infos.create')}}" class="dropdown-item {{Route::is('area_infos.create') ? 'active' : ''}}">Add Area Information</a>
                        <a href="{{route('area_infos.index')}}" class="dropdown-item {{Route::is('area_infos.index') ? 'active' : ''}}">Area Informations</a>
                        <a href="{{route('area_billing_incriments.create')}}" class="dropdown-item {{Route::is('area_billing_incriments.create') ? 'active' : ''}}">Add Area Billing Increment</a>
                        <a href="{{route('area_billing_incriments.index')}}" class="dropdown-item {{Route::is('area_billing_incriments.index') ? 'active' : ''}}">Area Billing Increments</a>
                        <a href="{{route('regions.index')}}" class="dropdown-item {{Route::is('regions.index') ? 'active' : ''}}">World Regions</a>
                    </div>
                </div>  
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('interconnections*') || Route::is('businesstypes*') || Route::is('tags*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-circle-info me-2"></i>Others</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('interconnections*') || Route::is('businesstypes*') || Route::is('tags*') ? 'show' : ''}}">
                        <a href="{{route('tags.index')}}" class="dropdown-item {{Route::is('tags*') ? 'active' : ''}}">Tags</a>
                        <a href="{{route('interconnections.index')}}" class="dropdown-item {{Route::is('interconnections*') ? 'active' : ''}}">Inter Connection Type</a>
                        <a href="{{route('businesstypes.index')}}" class="dropdown-item {{Route::is('businesstypes*') ? 'active' : ''}}">Business Type</a>
                    </div>
                </div>  

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('logs*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-regular fa-rectangle-list me-2"></i>Log</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('logs*') ? 'show' : ''}}">
                        
                        <a href="{{route('logs.index')}}" class="dropdown-item {{Route::is('logs*') ? 'active' : ''}}">Logs</a>
                    </div>
                </div> 
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{Route::is('users*') ? 'show active' : ''}}" data-bs-toggle="dropdown"><i class="fa-solid fa-users me-2"></i>User</a>
                    <div class="dropdown-menu bg-transparent border-0 {{Route::is('users*') ? 'show' : ''}}">
                        
                        <a href="{{route('users.index')}}" class="dropdown-item {{Route::is('users*') ? 'active' : ''}}">Users</a>
                    </div>
                </div> 
            </div>

            @endauth

            @guest
            <a href="{{ route('login') }}" class="navbar-brand mx-4 mb-3 my-3">
                <p class="text-primary">Log In To Access</p>
            </a>
            <div class="navbar-nav w-100 mt-2">
                <a href="{{ route('login') }}" class="nav-item nav-link {{ Route::is('login') || Route::is('home') ? 'active' : '' }}"><i class="fa-solid fa-right-to-bracket me-2"></i>Sign In</a>     
                {{-- <a href="{{ route('register') }}" class="nav-item nav-link {{ Route::is('register') ? 'active' : '' }}"><i class="fa fa-edit me-2"></i>Sign Up</a> --}}           
            </div>
            @endguest          
        </nav>
    </div>
    <!-- Sidebar End -->