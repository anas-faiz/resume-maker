<?php
    $title = "My Resumes | resume builder";
    require './assets/includes/header.php';
    require './assets/includes/navbar.php';
   $fn->authPage();
?>


    <div class="container">

        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Create Resume</h5>
                <div>
                    <a href="./myresumes.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>

            <div>

                <form method="post" action="actions/create-resume.action.php" class="row g-3 p-3">
                <div class="col-md-6">
                        <label class="form-label">Resume Title</label>
                        <input type="text" name="resume_title"  value="resume<?=time()?>" class="form-control">
                    </div>    
                <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Dev Ninja" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="dev@abc.com" class="form-control">
                    </div>
                    
                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> objective</label>
                        <textarea class="form-control" name="objective" ></textarea>    
                    </div>
                    

                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="number" min="1111111111" name="mobile_no" placeholder="9569569569" max="9999999999"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Transgender</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select name="religion" class="form-select">
                            <option>Hindu</option>
                            <option>Muslim</option>
                            <option>Sikh</option>
                            <option>Christian</option>



                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <select name="nationality" class="form-select">
                            <option>Indian</option>
                            <option>Non Indian</option>


                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">marital status</label>
                        <select name="marital_status" class="form-select">
                            <option>Married</option>
                            <option>Single</option>
                            <option>Divorced</option>
                        
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" placeholder="Reading Books, Watching Movies" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Languages Known</label>
                        <input type="text" name="languages" placeholder="Hindi,English" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> Address</label>
                        <textarea type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St"></textarea>
                    </div>

                    </div>



                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Add
                            Resume</button>
                    </div>
                </form>
            </div>





        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<?php
    require './assets/includes/footer.php'
?>