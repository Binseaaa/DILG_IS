@extends('Admin_View.layouts.app')

@section('content')
    @if ($message = Session::get('message'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" style="color:black;">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif


    <div class="search" style="position:relative; top: 5px;">
        <div class="mx-auto" style="width:300px;">
            <form action="{{ url('admin/organization') }}" method="GET" role="search">

                <div class="input-group">
                    <span class="input-group-btn mr-1 mt-0">
                        <button class="btn btn-secondary text-light" type="submit" title="Search Name">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control mr-1" name="orgs" placeholder="Search..." id="orgs">
                    <a href="{{ url('admin/organization') }}" class=" mt-0">
                        <span class="input-group-btn">
                            <button class="btn btn-danger text-light" type="button" title="Refresh page">
                                <span class="fas fa-sync-alt"></span>
                            </button>
                        </span>
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-5 mb-2">
            <div style="display: flex; justify-content:space-between; align-items:center;">
                <div>
                    <a href="{{ route('admin/pdmu') }}" style="text-decoration:none; font-size: 16px;" class="text-dark"><span
                        class="text-danger fas fa-arrow-right" style="font-size: 15px;"></span> Go to PDMU Profile</a>
                </div>
                <div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn" style="background-color: #343a40; color:white;" data-toggle="modal"
                    data-target="#exampleModal">
                    <span class="fas fa-plus-circle"></span> Add
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #234495; color:white;">
                                    <h5 class="modal-title" id="exampleModalLabel">Adding Organizational Structure</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
    
                                    <form action="{{ url('/add-org') }}" method="POST" enctype="multipart/form-data"
                                        id="add-form">
                                        @csrf
    
                                        <div class="container mx-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" style="color:dimgray">First Name:</label>
                                                        <input type="text" class="form-control" name="fname" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" style="color:dimgray">Middle Initial:</label>
                                                        <input type="text" class="form-control text-center" style="width: 50px;"
                                                            name="mid_initial">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" style="color:dimgray">Last Name:</label>
                                                        <input type="text" class="form-control" name="lname" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="" style="color:dimgray">Profile Image:</label>
                                                        <input type="file" class="form-control" name="profile_img">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <div class="form-group">
                                                        <label for="" style="color:dimgray">Position:</label>
                                                        <input type="text" class="form-control" name="position" required>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
    
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success"><span class="fas fa-save"></span>
                                        Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card rounded">
            <div class="card-header p-2 d-flex justify-content-between">
                <img src="/img/dilg-main.png" style="height: 40px; width: 40px;" alt="">
                <h1 class="" style="font-size: 18px; font-weight: 450;">
                    <a style="text-decoration: none; color:black;" href="{{ url('/organization') }}"><span class="fas fa-users" style="color:#234495;"></span>
                        ORGANIZATIONAL STRUCTURE</a></h1>
            </div>


            <table class="table text-center table-bordered">
                <thead class="text-center" style="background-color:#343a40; color:white;">
                    <tr>
                        <th>Profile Image</th>
                        <th scope="col" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell"
                            style="text-align: center">First Name</th>
                        <th scope="col" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell"
                            style="text-align: center">Middle Initial</th>
                        <th>Last Name</th>
                        <th>Position</th>
                        <th>Edit</th>
                        <th scope="col" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell"
                            style="text-align: center">Delete</th>
                    </tr>

                </thead>
                <tbody class=" text-dark">
                    @foreach ($orgs as $org_member)
                        <tr>
                            <td><img src="{{ asset('org_profile_images/' . $org_member->profile_img) }} " alt="Image"
                                    style="border-radius: 50%; height: 50px; width: 50px;"></td>
                            <td scope="col" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell"
                                style="text-align: center">{{ $org_member->fname }}</td>
                            <td scope="col" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell"
                                style="text-align: center">{{ $org_member->mid_initial }}</td>
                            <td>{{ $org_member->lname }}</td>
                            <td>{{ $org_member->position }}</td>
                            <td><a href="#" data-toggle="modal" id="org_edit_link" class="btn"
                                    data-target="#org_id{{ $org_member->id }}"><span
                                        class="text-warning fas fa-edit"></span></a></td>


                            <!-- Modal -->
                            <div class="modal fade" id="org_id{{ $org_member->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #234495; color:white;">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('update-org/' . $org_member->id) }}" method="POST"
                                                enctype="multipart/form-data" id="update-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="container mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" style="color:dimgray">First
                                                                    Name:</label>
                                                                <input type="text" class="form-control" name="fname"
                                                                    value="{{ $org_member->fname }}" required>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" style="color:dimgray">Middle
                                                                    Initial:</label>
                                                                <input type="text" class="form-control text-center"
                                                                    style="width: 50px;" name="mid_initial"
                                                                    value="{{ $org_member->mid_initial }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" style="color:dimgray">Last
                                                                    Name:</label>
                                                                <input type="text" class="form-control" name="lname"
                                                                    value="{{ $org_member->lname }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""
                                                                    style="color:dimgray">Position:</label>
                                                                <input type="text" class="form-control"
                                                                    name="position" value="{{ $org_member->position }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 mx-auto">
                                                            <img src="{{ asset('org_profile_images/' . $org_member->profile_img) }}"
                                                                class="ml-5"
                                                                style="border-radius: 50%; height: 200px; width: 200px;"
                                                                alt="">
                                                            <div class="form-group">
                                                                <label for="" style="color:dimgray">Profile
                                                                    Image:</label>
                                                                <input type="file" class="form-control"
                                                                    name="profile_img"
                                                                    value="{{ $org_member->profile_img }}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><span
                                                    class="fas fa-save"></span>
                                                Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <td class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell" style="text-align: center">
                                <a href="#" data-toggle="modal" id="org_delete_link" class="btn"
                                    data-target="#delete_org_id{{ $org_member->id }}"><span
                                        class="text-danger fas fa-trash-alt"></span></a>
                            </td>

                            <div class="modal fade" id="delete_org_id{{ $org_member->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><span
                                                    class="fas fa-exclamation-circle text-danger"
                                                    style="font-size: 30px;"></span> </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ url('delete_org/' . $org_member->id) }}" method="GET"
                                                enctype="multipart/form-data" id="delete-form">
                                                @csrf
                                                @method('GET')

                                                <div class="container mx-auto">
                                                    Are you sure you want to delete this permanently?
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Delete Permanently</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-start" style="color:rgb(83, 82, 82); margin-top: 10px;">
            Showing {{ $orgs->firstItem() }} to {{ $orgs->lastItem() }} of {{ $orgs->total() }} entries
        </div>

        <div class="d-flex justify-content-end mt-2">
            {{ $orgs->onEachSide(1)->links() }}
        </div>


        <!-- Loading GIF image -->
        <div id="loading"
            style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; display: none;">
            <img src="{{ asset('loading_img/load.gif') }}" style="height: 150px; width: 150px;" alt="Loading...">
        </div>


        <script>
            setTimeout(function() {
                $(' .alert-dismissible').fadeOut('slow');
            }, 1000);


            const addform = document.getElementById('add-form');
            const addloading = document.getElementById('loading');

            addform.addEventListener('submit', () => {
                addloading.style.display = 'block';
            });

            addform.addEventListener('load', () => {
                addloading.style.display = 'none';
            });

            addform.addEventListener('error', () => {
                addloading.style.display = 'none';
            });


            const updateform = document.getElementById('update-form');
            const updateloading = document.getElementById('loading');

            updateform.addEventListener('submit', () => {
                updateloading.style.display = 'block';
            });

            updateform.addEventListener('load', () => {
                updateloading.style.display = 'none';
            });

            updateform.addEventListener('error', () => {
                updateloading.style.display = 'none';
            });

            const deleteform = document.getElementById('delete-form');
            const deleteloading = document.getElementById('loading');

            deleteform.addEventListener('submit', () => {
                deleteloading.style.display = 'block';
            });

            deleteform.addEventListener('load', () => {
                deleteloading.style.display = 'none';
            });

            deleteform.addEventListener('error', () => {
                deleteloading.style.display = 'none';
            });
        </script>
    @endsection
