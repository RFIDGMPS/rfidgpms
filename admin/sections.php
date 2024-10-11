<!DOCTYPE html>




<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Administrator</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicon -->
    <!--     <link href="img/favicon.ico" rel="icon"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.js" integrity="sha512-EjW7LChk2bIML+/kvj1NDrPSKHqfQ+zxJGBUKcopijd85cGwAX8ojz+781Rc0e7huwyI3j5Bn6rkctL3Gy61qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style type="text/css">
        @media (max-width: 576px) and (max-width: 768px) {
            #lnamez {
                margin-top: 30%;
                display: block;
                /* remove extra space below image */
            }
            #up_img {
                position: relative;
                margin-top: 4%;
                display: block;
                /* remove extra space below image */
            }
        }

        @media (max-width: 992px) and (max-width: 1200px) {
            #lnamez {
                margin-top: 30%;
                display: block;
                /* remove extra space below image */
            }
            #up_img {
                position: relative;
                margin-top: 4%;
                display: block;
                /* remove extra space below image */
            }
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#myDataTable").DataTable();
        });
    </script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3" style="background-color: #fcaf42">
            <nav class="navbar  navbar-light">
                <a href="dashboard" class="navbar-brand mx-4 mb-3">
                    <h3 class="text" style="color: #f0ddcc">RFID Attendance</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/2601828.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">admin@gmail.com</h6>
                        <span>Administrator</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

                   <a href="department.php" class="nav-item nav-link"><i class="fa fa-city me-2"></i>Department</a>
                   <a href="sections.php" class="nav-item nav-link active"><i class="fa fa-puzzle-piece me-2"></i>Sections</a>
                    <a href="users.php" class="nav-item nav-link"><i class="fa fa-users me-2"></i>Users</a>
                   
                    <a href="entrance.php" class="nav-item nav-link"><i class="fa fa-address-card me-2"></i>Entrance</a>
                    <a href="messages.php" class="nav-item nav-link"><i class="fa fa-envelope me-2"></i>Messages</a>
                    <a href="report.php" class="nav-item nav-link"><i class="fa fa-print me-2"></i>Report</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand  navbar-light sticky-top px-4 py-0" style="background-color: #fcaf42">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-warning mb-0"></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <!--      <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                       
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div> -->
                    <!--  <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                 
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div> -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/2601828.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">admin@gmail.com</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="logout" class="dropdown-item" style="border: 1px solid #b0a8a7"><i class="bi bi-arrow-right-circle"></i> Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">

                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="row">
                                <div class="col-9">
                                    <h6 class="mb-4">Manage Department</h6>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-outline-warning m-2" data-bs-toggle="modal" data-bs-target="#departmentModal">Add Department</button>
                                </div>
                            </div>
                            <hr></hr>
                            <div class="table-responsive">
                                <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Department Name</th>
                                            <th scope="col">Department Description</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>HUMSS AUSTEN</td>
                                            <td>ROOM</td>
                                            <td width="14%">
                                                <center><button class="btn btn-outline-primary btn-sm btn-edit" data-edit="15"><i class="bi bi-plus-edit"></i> Edit</button> <button class="btn btn-outline-danger btn-sm btn-del" data-del="15"><i class="bi bi-plus-trash"></i> Delete</button>                                                    </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Accounting Department</td>
                                            <td>Accounting Department</td>
                                            <td width="14%">
                                                <center><button class="btn btn-outline-primary btn-sm btn-edit" data-edit="2"><i class="bi bi-plus-edit"></i> Edit</button> <button class="btn btn-outline-danger btn-sm btn-del" data-del="2"><i class="bi bi-plus-trash"></i> Delete</button>                                                    </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>MIS depertment</td>
                                            <td>MIS depertment</td>
                                            <td width="14%">
                                                <center><button class="btn btn-outline-primary btn-sm btn-edit" data-edit="1"><i class="bi bi-plus-edit"></i> Edit</button> <button class="btn btn-outline-danger btn-sm btn-del" data-del="1"><i class="bi bi-plus-trash"></i> Delete</button>                                                    </center>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-circle"></i> New Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-dept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input type="text" id="department_name" class="form-control" autocomplete="off">
                                        <span class="deptname-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Description: </b></label>
                                        <textarea type="text" id="department_description" class="form-control" autocomplete="off"></textarea>
                                        <span class="deptdesc-error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-outline-warning" id="btn-department">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', () => {
                    let btn = document.querySelector('#btn-department');
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();


                        const department_name = document.querySelector('input[id=department_name]').value;
                        console.log(department_name);

                        const department_description = document.querySelector('textarea[id=department_description]').value;
                        console.log(department_description);

                        var data = new FormData(this.form);

                        data.append('department_name', department_name);
                        data.append('department_description', department_description);


                        function isValidDepartmentName() {
                            var pattern = /^[a-zA-Z \s]+$/;
                            var department_name = $("#department_name").val();
                            if (pattern.test(department_name) && department_name !== "") {
                                $("#department_name").removeClass("is-invalid").addClass("is-valid");
                                $(".deptname-error").css({
                                    "color": "green",
                                    "font-size": "14px",
                                    "display": "none"
                                });
                                return true;
                            } else if (department_name === "") {
                                $("#department_name").removeClass("is-valid").addClass("is-invalid");
                                $(".deptname-error").html('Required Department Name');
                                $(".deptname-error").css({
                                    "color": "red",
                                    "font-size": "14px"
                                });
                            } else {
                                $("#department_name").removeClass("is-valid").addClass("is-invalid");
                                $(".deptname-error").html('Please input Character only');
                                $(".deptname-error").css({
                                    "color": "red",
                                    "font-size": "14px",
                                    "display": "block"
                                });
                            }
                        };


                        function isValidDepartmentDecs() {
                            var pattern = /^[a-zA-Z \s]+$/;
                            var department_description = $("#department_description").val();
                            if (pattern.test(department_description) && department_description !== "") {
                                $("#department_description").removeClass("is-invalid").addClass("is-valid");
                                $(".deptdesc-error").css({
                                    "color": "green",
                                    "font-size": "14px",
                                    "display": "none"
                                });
                                return true;
                            } else if (department_description === "") {
                                $("#department_description").removeClass("is-valid").addClass("is-invalid");
                                $(".deptdesc-error").html('Required Department Description');
                                $(".deptdesc-error").css({
                                    "color": "red",
                                    "font-size": "14px"
                                });
                            } else {
                                $("#department_description").removeClass("is-valid").addClass("is-invalid");
                                $(".deptdesc-error").html('Please input Character only');
                                $(".deptdesc-error").css({
                                    "color": "red",
                                    "font-size": "14px",
                                    "display": "block"
                                });
                            }
                        };


                        isValidDepartmentName();
                        isValidDepartmentDecs();

                        if (isValidDepartmentName() === true && isValidDepartmentDecs() === true) {

                            $.ajax({
                                url: '../config/init/add_department.php',
                                type: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                async: false,
                                cache: false,
                                success: function(response) {
                                    $("#mgs-dept").html(response);
                                    $('#mgs-dept').animate({
                                        scrollTop: 0
                                    }, 'slow');
                                },
                                error: function(response) {
                                    console.log("Failed");
                                }
                            });
                        }

                    });
                });
            </script>
            <div class="modal fade" id="editdepartment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-editdept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input type="text" id="edit_departmentname" class="form-control" autocomplete="off">
                                        <span class="deptname-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Description: </b></label>
                                        <textarea type="text" id="edit_departmentdescription" class="form-control" autocomplete="off"></textarea>
                                        <span class="deptdesc-error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" id="edit_departmentid">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-outline-primary" id="btn-editdepartment">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', () => {
                    let btn = document.querySelector('#btn-editdepartment');
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();


                        const department_name = document.querySelector('input[id=edit_departmentname]').value;
                        console.log(department_name);

                        const department_description = document.querySelector('textarea[id=edit_departmentdescription]').value;
                        console.log(department_description);

                        const department_id = document.querySelector('input[id=edit_departmentid]').value;
                        console.log(department_id);

                        var data = new FormData(this.form);

                        data.append('department_name', department_name);
                        data.append('department_description', department_description);
                        data.append('department_id', department_id);


                        function isValidDepartmentName2() {
                            var pattern = /^[a-zA-Z \s]+$/;
                            var department_name = $("#edit_departmentname").val();
                            if (pattern.test(department_name) && department_name !== "") {
                                $("#edit_departmentname").removeClass("is-invalid").addClass("is-valid");
                                $(".deptname-error").html('Please input Character');
                                $(".deptname-error").css({
                                    "color": "green",
                                    "font-size": "14px",
                                    "display": "none"
                                });
                                return true;
                            } else if (department_name === "") {
                                $("#edit_departmentname").removeClass("is-valid").addClass("is-invalid");
                                $(".deptname-error").html('Required Department Name');
                                $(".deptname-error").css({
                                    "color": "red",
                                    "font-size": "14px"
                                });
                            } else {
                                $("#edit_departmentname").removeClass("is-valid").addClass("is-invalid");
                                $(".deptname-error").html('Please input Character only');
                                $(".deptname-error").css({
                                    "color": "red",
                                    "font-size": "14px",
                                    "display": "block"
                                });
                            }
                        };


                        function isValidDepartmentDecs2() {
                            var pattern = /^[a-zA-Z \s]+$/;
                            var department_description = $("#edit_departmentdescription").val();
                            if (pattern.test(department_description) && department_description !== "") {
                                $("#edit_departmentdescription").removeClass("is-invalid").addClass("is-valid");
                                $(".deptdesc-error").css({
                                    "color": "green",
                                    "font-size": "14px",
                                    "display": "none"
                                });
                                return true;
                            } else if (department_description === "") {
                                $("#edit_departmentdescription").removeClass("is-valid").addClass("is-invalid");
                                $(".deptdesc-error").html('Required Department Description');
                                $(".deptdesc-error").css({
                                    "color": "red",
                                    "font-size": "14px"
                                });
                            } else {
                                $("#edit_departmentdescription").removeClass("is-valid").addClass("is-invalid");
                                $(".deptdesc-error").html('Please input Character only');
                                $(".deptdesc-error").css({
                                    "color": "red",
                                    "font-size": "14px",
                                    "display": "block"
                                });
                            }
                        };


                        isValidDepartmentName2();
                        isValidDepartmentDecs2();

                        if (isValidDepartmentName2() === true && isValidDepartmentDecs2() === true) {

                            $.ajax({
                                url: '../config/init/edit_department.php',
                                type: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                async: false,
                                cache: false,
                                success: function(response) {
                                    $("#mgs-editdept").html(response);
                                    $('#mgs-editdept').animate({
                                        scrollTop: 0
                                    }, 'slow');
                                },
                                error: function(response) {
                                    console.log("Failed");
                                }
                            });
                        }

                    });
                });
            </script>
            <div class="modal fade" id="deldepartment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-trash"></i> Delete Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-deldept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input type="text" id="delete_departmentname" class="form-control" autocomplete="off" readonly="">
                                        <span class="deptname-error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" id="delete_departmentid">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
                                <button type="button" class="btn btn-outline-primary" id="btn-deldepartment">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', () => {
                    let btn = document.querySelector('#btn-deldepartment');
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();

                        const department_id = document.querySelector('input[id=delete_departmentid]').value;
                        console.log(department_id);

                        var data = new FormData(this.form);

                        data.append('department_id', department_id);



                        $.ajax({
                            url: '../config/init/delete_department.php',
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            async: false,
                            cache: false,
                            success: function(response) {
                                $("#mgs-deldept").html(response);
                                $('#mgs-deldept').animate({
                                    scrollTop: 0
                                }, 'slow');
                            },
                            error: function(response) {
                                console.log("Failed");
                            }
                        });
                        // }

                    });
                });
            </script>
            <div class="container-fluid pt-4 px-4" style="margin-top: 60%">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">2023</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Created By <a href="#">Junil Toledo</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    load_data();
                    var count = 1;

                    function load_data() {
                        $(document).on('click', '.btn-edit', function() {
                            $('#editdepartment-modal').modal('show');
                            var department_id = $(this).data("edit");
                            // console.log(department_id);
                            getID(department_id); //argument    

                        });
                    }

                    function getID(department_id) {
                        $.ajax({
                            type: 'POST',
                            url: '../config/init/row_depertment.php',
                            data: {
                                department_id: department_id
                            },
                            dataType: 'json',
                            success: function(response) {

                                $('#edit_departmentid').val(response.department_id);
                                $('#edit_departmentname').val(response.department_name);
                                $('#edit_departmentdescription').val(response.department_description);

                            }
                        });
                    }

                });
            </script>
            <script>
                $(document).ready(function() {
                    load_data();
                    var count = 1;

                    function load_data() {
                        $(document).on('click', '.btn-del', function() {
                            $('#deldepartment-modal').modal('show');
                            var department_id = $(this).data("del");
                            get_delId(department_id); //argument    

                        });
                    }

                    function get_delId(department_id) {
                        $.ajax({
                            type: 'POST',
                            url: '../config/init/row_depertment.php',
                            data: {
                                department_id: department_id
                            },
                            dataType: 'json',
                            success: function(response2) {
                                $('#delete_departmentid').val(response2.department_id);
                                $('#delete_departmentname').val(response2.department_name);

                            }
                        });
                    }

                });
            </script>

        </div>

        <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>