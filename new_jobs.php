<?php
include('database/db_connection.php');
include('session.php');

$editData = null; // store job row if editing

// ✅ DELETE functionality
if (isset($_GET['id']) && $_GET['type'] == 'delete') {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM new_jobs WHERE id='$id'") or die("query Unsuccessful");
    header('location:new_jobs');
    exit;
}

// ✅ EDIT: load record for pre-fill
if (isset($_GET['id']) && $_GET['type'] == 'edit') {
    $id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM new_jobs WHERE id='$id'");
    $editData = mysqli_fetch_assoc($result);
}

// ✅ INSERT or UPDATE
if (isset($_POST['submit'])) {
    $job_description = mysqli_real_escape_string($con, $_POST['job_description']);
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $name = $_FILES['file']['name'];
    $target_dir = "../dhothar_international_recruitment/assets/images/NewJobs/";

    if (!empty($name)) {
        $target_file = $target_dir . basename($name);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $extensions_arr)) {
            move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
        }
        
        $name ="assets/images/NewJobs/".$name;
        
    } else {
        // keep old image if not uploading new one
        if ($id > 0 && isset($_POST['old_image'])) {
            $name = $_POST['old_image'];
        }
    }
    
    //temporary name
    // $final_name ="assets/images/NewJobs/".$name;
    

    if ($id > 0) {
        // ✅ UPDATE existing record
        $sql = "UPDATE new_jobs SET job_banner_image='$name', job_description='$job_description' WHERE id='$id'";
    } else {
        // ✅ INSERT new record
        $sql = "INSERT INTO new_jobs (job_banner_image, job_description) VALUES ('$name', '$job_description')";
    }

    $result = mysqli_query($con, $sql) or die("Something Went Wrong!");

    if ($result) {
        header('location:new_jobs');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dhothar International" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="assets/images/favicon.ico">

    <title>Dhothar International </title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
        id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"
        id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">

    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!--[if lt IE 9]><script src="https://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
</head>

<body class="page-body">
    <div class="page-container">
        <div class="sidebar-menu">
            <?php include('components/sidebar.php'); ?>
        </div>
        <div class="main-content">
            <?php include('components/header.php'); ?>
            <hr />
            <ol class="breadcrumb bc-3">
                <li> <a href="../../dashboard/main/index.html"><i class="fa-home"></i>Home</a> </li>
                <li> <a href="../main/index.html">Tables</a> </li>
                <li class="active"> <strong>Data Tables</strong> </li>
            </ol>

            <div class="row">
                <form action="" method="post" enctype="multipart/form-data" onsubmit="getEditorData()">

                    <?php if ($editData): ?>
                    <!-- Hidden ID for editing -->
                    <input type="hidden" name="id" value="<?=$editData['id'];?>">
                    <input type="hidden" name="old_image" value="<?=$editData['job_banner_image'];?>">
                    <?php endif; ?>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="job_description">Job Banner Image</label>
                            <input type="file" name="file" id="image" accept="image/*" class="form-control"
                                <?= $editData ? '' : 'required'; ?>>

                            <?php if ($editData): ?>
                            <br>
                            <img src="https://dhotharinternational.com/dhothar_international_recruitment/<?=$editData['job_banner_image'];?>" width="200">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="job_description">Job Description</label>
                            <div id="editor">
                                <?=$editData ? $editData['job_description'] : '';?>
                            </div>
                            <textarea name="job_description" id="editorInput" hidden></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" name="submit" value="Submit" class="btn btn-primary">
                                <?=$editData ? 'Update' : 'Submit';?>
                            </button>
                        </div>
                    </div>
                </form>


            </div>



            <h3>Exporting Table Data</h3>
            <br />
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                var $table4 = jQuery("#table-4");
                $table4.DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                });




            });
            </script>
            <table class="table table-bordered datatable table-3" id="table-4">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Job Banner Image</th>
                        <th>Job Description</th>
                        
                        <?php
                            if($can_update == 'on' || $can_delete == 'on') {
                        ?>
                            <th>Action</th>
                        <?php
                            }
                        ?>

                    </tr>
                </thead>
                <tbody>
                    <?php
                     $i=0;
                     $data=mysqli_query($con,"select * from new_jobs order by id desc");
                     while($row=mysqli_fetch_assoc($data)){
                        $i++;
                  ?>
                    <tr>
                        <td><?=$i;?></td>
                        <td>
                            <img src="https://dhotharinternational.com/dhothar_international_recruitment/<?=$row['job_banner_image'];?>" width="340" height="340"
                                alt="">
                        </td>
                        <td><?=$row['job_description'];?></td>
                        
                        <?php if ($can_update === 'on' || $can_delete === 'on'): ?>
                        <td>
                            <?php if ($can_update === 'on'): ?>
                                <a href="new_jobs?id=<?= $row['id'] ?>&type=edit"
                                   class="btn btn-success btn-sm btn-icon icon-left">
                                    <i class="entypo-pencil"></i> Edit
                                </a>
                            <?php endif; ?>
                        
                            <?php if ($can_delete === 'on'): ?>
                                <a href="new_jobs?id=<?= $row['id'] ?>&type=delete"
                                   class="btn btn-danger btn-sm btn-icon icon-left"
                                   onclick="return confirm('Are you sure you want to delete this job?');">
                                    <i class="entypo-cancel"></i> Delete
                                </a>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>

                    </tr>
                    <?php
                     }
                  ?>
                </tbody>

            </table>
            <br />
            <?php
               include('components/footer.php');
            ?>
        </div>

    </div>
    <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/select2/select2.css" id="style-resource-3">
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
    <script src="assets/js/datatables/datatables.js" id="script-resource-8"></script>
    <script src="assets/js/select2/select2.min.js" id="script-resource-9"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-10"></script>
    <script src="assets/js/neon-custom.js" id="script-resource-11"></script>
    <script src="assets/js/neon-demo.js" id="script-resource-12"></script>
    <script src="assets/js/neon-skins.js" id="script-resource-13"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    // If PHP pre-filled editor with raw HTML, load it into Quill
    <?php if ($editData): ?>
    quill.root.innerHTML = `<?= addslashes($editData['job_description']); ?>`;
    <?php endif; ?>

    function getEditorData() {
        document.getElementById('editorInput').value = quill.root.innerHTML;
    }
    </script>

</body>

</html>