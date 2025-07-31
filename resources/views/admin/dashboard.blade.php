@extends('admin.layout.app')

@section('content')
 
    <div class="container-fluid pt-4 px-4">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-building fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('companies.index')}}">
                                <p class="text-dark mb-0">Companies</p>
                                <h2 class="text-dark mb-0">{{$datas['totalCompanies']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-address-card fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('contacts.index')}}">
                                <p class="text-dark mb-0">Contacts</p>
                                <h2 class="text-dark mb-0">{{$datas['totalContacts']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-earth fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-dark mb-0">Domains</p>
                            <h2 class="text-dark mb-0">{{$datas['totalDomains']}}</h2>                               
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-road-circle-exclamation fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('domains.index')}}">
                                <p class="text-dark mb-0">Private Domains</p>
                                <h2 class="text-dark mb-0">{{$datas['totlaPrivateDomain']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-road-circle-check fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('public_free_domain')}}">
                                <p class="text-dark mb-0">Public Domains</p>
                                <h2 class="text-dark mb-0">{{$datas['totlaPublicDomain']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-briefcase fa-2x"></i>
                        </div>
                        <div class="ms-3"> 
                            <a href="{{route('businesstypes.index')}}">
                                <p class="text-dark mb-0">Business Types</p>
                                <h2 class="text-dark mb-0">{{$datas['totalBusinessType']}}</h2>    
                            </a>                                  
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-flag fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('countries.index')}}">
                                <p class="text-dark mb-0">Countries</p>
                                <h2 class="text-dark mb-0">{{$datas['totalCountry']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-up-right-from-square fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('interconnections.index')}}">
                                <p class="text-dark mb-0">Inter Connections</p>
                                <h2 class="text-dark mb-0">{{$datas['totalInterconnectionType']}}</h2>                               
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-link fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-dark mb-0">Interconnected Companies</p>
                            <h2 class="text-dark mb-0">{{$datas['totalInterconnected']}}</h2>                               
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="card p-2 border-bottom rounded-5">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="fa-solid fa-server fa-2x"></i>
                        </div>
                        <div class="ms-3">                          
                            <p class="text-dark mb-0">DB Size</p>
                            <h2 class="text-dark mb-0">({{$datas['dbSize']}}MB)</h2>                                                         
                        </div>
                    </div>
                </div>
            </div>

 

            <div class="col-md-12">
                <div class="card p-3">
                    <h2 class="text-center text-info mt-2 mb-4"><i class="fa-solid fa-table me-2"></i>Table Sizes</h2>
                    <div class="row">
                        @foreach ($tableSizes as $index => $table)
                        <div class="col-md-4">
                            <p>{{ $index + 1 }}. {{ $table['name'] }} - {{ $table['size_in_mb'] }} MB</p>
                        </div>                           
                        @endforeach
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <!-- Recent Sales Start -->
    {{-- <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recent Salse</h6>
                <a href="">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">Date</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <!-- Recent Sales End -->


    <!-- Widgets Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="card h-100 rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0 text-dark">Calender</h6>
                    </div>
                    <div id="calender"></div>
                </div>
            </div>
            {{-- <div class="col-sm-12 col-md-6 col-xl-6">
                <div class="h-100 bg-secondary rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">To Do List</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="d-flex mb-2">
                        <input class="form-control bg-dark border-0" type="text" placeholder="Enter task">
                        <button type="button" class="btn btn-primary ms-2">Add</button>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-2">
                        <input class="form-check-input m-0" type="checkbox">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span>Short task goes here...</span>
                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-2">
                        <input class="form-check-input m-0" type="checkbox">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span>Short task goes here...</span>
                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-2">
                        <input class="form-check-input m-0" type="checkbox" checked>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span><del>Short task goes here...</del></span>
                                <button class="btn btn-sm text-primary"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-2">
                        <input class="form-check-input m-0" type="checkbox">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span>Short task goes here...</span>
                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center pt-2">
                        <input class="form-check-input m-0" type="checkbox">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span>Short task goes here...</span>
                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection    