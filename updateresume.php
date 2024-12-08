<?php
    $title = "Update resume | resume builder";
    require './assets/includes/header.php';
    require './assets/includes/navbar.php';
    $fn->authPage();
    $slug=$_GET['resume']??'';
   $resumes=$database->query("SELECT * FROM resumes WHERE (slug='$slug' AND user_id =".$fn->auth()['id'].")" );
   $resumes = $resumes->fetch_assoc();
    
    
     if(!$resumes){
        $fn->redirect('myresumes.php');
    }

    $exps= $database->query("SELECT * FROM experience WHERE (resume_id = ". $resumes['id'] . " )"  );
    $exps= $exps->fetch_all(1);

    $edus= $database->query("SELECT * FROM educations WHERE (resume_id = ". $resumes['id'] . " )"  );
    $eduss= $edus->fetch_all(1);

    $skills= $database->query("SELECT * FROM skills WHERE (resume_id = ". $resumes['id'] . " )"  );
    $skills= $skills->fetch_all(1);
?>


    <div class="container">

        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Create Resume</h5>
                <div>
                    <a href="./myresumes.php" class="text-decoration-none"><i cl  ass="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>

            <div>

                <form method="post" action="actions/updateresume.action.php" class="row g-3 p-3">
                   <!-- Hidden Input Field -->
          <input type="hidden" name="id" value="<?=$resumes['id']?>" />
          <input type="hidden" name="slug" value="<?=$resumes['slug']?>" />

                <div class="col-md-6">
                        <label class="form-label">Resume Title</label>
                        
                        <input type="text" name="resume_title"  value="<?=@$resumes['resume_title']?>" class="form-control">
                    </div>    
                
                <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Dev Ninja" value="<?=@$resumes['full_name']?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="dev@abc.com" value="<?=@$resumes['email']?>" class="form-control">
                    </div>
                    
                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> objective</label>
                        <textarea class="form-control"  name="objective" ><?=@$resumes['objective']?></textarea>    
                    </div>
                    

                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="number" min="1111111111" name="mobile_no" value="<?=@$resumes['mobile_no']?>" placeholder="9569569569" max="9999999999"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" name="dob" value="<?=@$resumes['dob']?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" value="" class="form-select">
                            <option <?($resumes['gender']=='Male')?'selected':''?>>Male</option>
                            <option <?($resumes['gender']=='Female')?'selected':''?>>Female</option>
                            <option <?($resumes['gender']=='other')?'selected':''?>>other</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select name="religion" class="form-select" value="<?=@$resumes['religion']?>">
                            <option <? ($resumes['religion']=='Hindu')?'selected':''?> >Hindu</option>
                            <option <? ($resumes['religion']=='Muslim')?'selected':''?> >Muslim</option>
                            <option <? ($resumes['religion']=='Sikh')?'selected':''?> >Sikh</option>
                            <option <? ($resumes['religion']=='Christian')?'selected':''?> >Christian</option>



                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <select name="nationality" class="form-select" value="<?=@$resumes['nationality']?>">
                            <option <?($resumes['nationality']=='Indian')?'selected':''?> >Indian</option>
                            <option <?($resumes['nationality']=='Non Indian')?'selected':''?> >Non Indian</option>


                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" value="<?=@$resumes['marital_status']?>" class="form-select">
                            <option <?($resumes['marital_status']=='Married')?'selected':''?> >Married</option>
                            <option <?($resumes['marital_status']=='Single')?'selected':''?> >Single</option>
                            <option <?($resumes['marital_status']=='Divorced')?'selected':''?> >Divorced</option>
                        
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" value="<?=@$resumes['hobbies']?>" placeholder="Reading Books, Watching Movies" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Languages Known</label>
                        <input type="text" name="languages" value="<?=@$resumes['languages']?>" placeholder="Hindi,English" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> Address</label>
                        <input type="text" name="address" class="form-control" value="<?=@$resumes['address']?>" id="inputAddress" placeholder="1234 Main St">
                    </div>

                    <hr>
                    
                    
                    <div class="d-flex justify-content-between">
     
       
                    <h5 class=" text-secondary"><i class="bi bi-briefcase"></i> Experience</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addexp"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>

                    <?php
if ($exps) {
    foreach ($exps as $exp) {
        ?>
        <div class="col-12 col-md-6 p-2">
            <div class="p-2 border rounded">
                <div class="d-flex justify-content-between">
                    <h6><?= htmlspecialchars($exp['position']) ?></h6>
                    
    
</a>

                </div>
                <p class="small text-secondary m-0">
                    <i class="bi bi-buildings"></i> <?= htmlspecialchars($exp['company']) ?>
                    (<?= htmlspecialchars($exp['started'] . ' - ' . $exp['ended']) ?>)
                </p>
                <p class="small text-secondary m-0">
                    <?= htmlspecialchars($exp['job_desc']) ?>
                </p>
            </div>
        </div>
        <?php
    }
} else {
    // Display the "Add Experience" message
    ?>
    <div class="col-12 col-md-6 p-2">
        <div class="p-2 border rounded">
            <div class="d-flex justify-content-between">
                <h6>Add experience</h6>
            </div>
            <p class="small text-secondary m-0">
                <i class="bi bi-buildings"></i> Data Developer()
            </p>
            <p class="small text-secondary m-0">
                Handling customers and fulfilling their needs
            </p>
        </div>
    </div>
    <?php
}
?>
     
                       
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class=" text-secondary"><i class="bi bi-journal-bookmark"></i> Education</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addedu"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">
                    <?php
        
                    if ($edus) {
                        foreach ($edus as $exp) {
                    ?>
                            <div class="col-12 col-md-6 p-2">
                                <div class="p-2 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <h6><?=$exp['course'] ?></h6>
                                    </div>
                    
                                    <p class="small text-secondary m-0">
                                        <i class="bi bi-book"></i> <?=$exp['institute']?>
                                    </p>
                                    <p class="small text-secondary m-0">
                                        <?=$exp['started']?> - <?=$exp['ended']?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                    ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6>Add education</h6>
                                </div>
                                <p class="small text-secondary m-0">
                                    <i class="bi bi-book"></i> Put education here
                                </p>
                                <p class="small text-secondary m-0">
                                    2017
                                </p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                      
 </div>
                    <hr>

                    <div class="d-flex justify-content-between">
                        <h5 class=" text-secondary"><i class="bi bi-boxes"></i> Skills</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addskill"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">
<?php
    if($skills){
        foreach($skills as $skill){
            ?>
            <div class="col-12 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i> <?= $skill['skill']?></h6>
                                    
                                </div>
                            </div>
                        </div>
                        
      <?php      
        }
    }else{
?>
    
    <div class="col-12 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i>Enter Skills</h6>
                                    <a href=""><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                        </div>

<?php
    }
    ?>

       </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Update
                            Resume</button>
                    </div>
                </form>
            </div>





        </div>
<!-- //modal exp -->
<div class="modal fade" id="addexp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Enter Experience</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="actions/addexp.action.php" class="row g-3">
          <!-- Hidden Input Field -->
          <input type="hidden" name="resume_id" value="<?=$resumes['id']?>" />
          <input type="hidden" name="slug" value="<?=$resumes['slug']?>" />

          <!-- Position/Job Role -->
          <div class="col-12">
            <label for="position" class="form-label">Position/Job Role</label>
            <input type="text" name="position" placeholder="Web Developer Consultant (2+ Years)" class="form-control" id="position" required>
          </div>

          <!-- Organisation -->
          <div class="col-12">
            <label for="company" class="form-label">Organisation</label>
            <input type="text" name="company" placeholder="Dominos, New Delhi" class="form-control" id="company" required>
          </div>

          <!-- Joined -->
          <div class="col-md-6">
            <label for="started" class="form-label">Joined</label>
            <input type="text" name="started" placeholder="October 2020" class="form-control" id="started" required>
          </div>

          <!-- To -->
          <div class="col-md-6">
            <label for="ended" class="form-label">To</label>
            <input type="text" name="ended" placeholder="October 2024" class="form-control" id="ended" required>
          </div>

          <!-- Job Description -->
          <div class="col-12">
            <label for="job_desc" class="form-label">Job Description</label>
            <textarea name="job_desc" placeholder="Handling customers and fulfilling their needs" class="form-control" id="job_desc" required></textarea>
          </div>

          <!-- Submit Button -->
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Add Experience</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal exp -->

<!-- //modal edu -->

<div class="modal fade" id="addedu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Enter Education</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="post" action="actions/addedu.action.php" class="row g-3">
          <!-- Hidden Input Fields -->
          <input type="hidden" name="resume_id" value="<?= $resumes['id'] ?>" />
          <input type="hidden" name="slug" value="<?= $resumes['slug'] ?>" />

          <div class="col-12">
            <label for="course" class="form-label">Course/Degree</label>
            <input type="text" name="course" placeholder="e.g., Bachelor of Science" class="form-control" id="course" required>
          </div>
          <div class="col-12">
            <label for="institute" class="form-label">Institute/Board</label>
            <input type="text" name="institute" placeholder="e.g., University of XYZ" class="form-control" id="institute" required>
          </div>
          <div class="col-md-6">
            <label for="started" class="form-label">Joined</label>
            <input type="text" name="started" placeholder="e.g., October-2020" class="form-control" id="started" required>
          </div>
          <div class="col-md-6">
            <label for="ended" class="form-label">To</label>
            <input type="text" name="ended" placeholder="e.g., October-2024" class="form-control" id="ended" required>
          </div>

          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Add Education</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal edu -->


<!-- //modal skill -->

<div class="modal fade" id="addskill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Enter Skills </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
 
      <div class="modal-body">
      
      <form method="post" action="actions/addskill.action.php" class="row g-3">
      <input type="hidden" name="resume_id" value="<?=$resumes['id']?>" />
          <input type="hidden" name="slug" value="<?=$resumes['slug']?>" />

  <div class="col-12">
    <label for="inputEmail4" class="form-label">skill</label>
    <input type=text" name="skill" placeholder="java" class="form-control" id="inputEmail4" required>
  </div>    
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-primary">Add Skills</button>
  </div

</form>

      </div>
      </div>
    </div>
  </div>
</div>
<!-- modal skill -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<?php
    require './assets/includes/footer.php'
?>