<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

if($_SESSION["role"] != "Staff") {
  header("Location: login.php");
  exit;
}

$dbconn = mysqli_connect("localhost", "root", "", "krunkerideadb");
//determine current page
$page = isset($_GET['page'])?$_GET['page']:1;
//determine the number of data per page
$rows_per_page = 5;

// Determine the starting row number for the current page
$start= ($page-1)*$rows_per_page;

$sql = "SELECT idea_tbl.IdeaId, idea_tbl.IdeaTitle, category_tbl.CategoryTitle, user_tbl.Username, idea_tbl.DatePost, idea_tbl.IdeaDescription, idea_tbl.IdeaAnonymous from idea_tbl 
INNER JOIN user_tbl ON idea_tbl.UserId =user_tbl.UserId 
INNER JOIN category_tbl ON idea_tbl.CategoryId= category_tbl.CategoryId 
WHERE is_hidden=0 ORDER BY idea_tbl.IdeaId DESC LIMIT $start,$rows_per_page";

$result= mysqli_query($dbconn, $sql);

// Insert new commant into database
if(isset($_POST["submit_comment_post"])){
  $user_id = $_SESSION["userid"];
	$comment = mysqli_real_escape_string($dbconn, $_POST["comment"]);
  $anonymous = isset($_POST["anonymous"]);
	mysqli_query($dbconn, "INSERT INTO comment_tbl (UserId, CommentDetails, CommentAnonymous) 
							VALUES ('$user_id','$comment','$anonymous')");
  header("Location: index.php");
	exit();
}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Krunker Idea Portal 2023</title>
  <meta content="" name="description">
  <meta content="" name="keywords"> 

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/fe459689b4.js"></script>

  <style>
    .pagination{
        text-align:center;
        display: inline;
        letter-spacing:10px;
    }
</style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Krunker Idea Portal</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION["username"];?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION["username"];?></h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="staff_profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#idea-nav" data-bs-toggle="collapse" href="index.html">
          <i class="bi bi-grid"></i><span>Idea</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="idea-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="list_of_category.html">
              <i class="bi bi-list-nested" style="font-size:18px"></i><span>List of Category</span>
            </a>
          </li>
        </ul>
      </li><!-- End Idea Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#statistics-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Statistics</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="statistics-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Charts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Statistics Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff_profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->
      
      
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Idea</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Idea</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
          <div class="row">
            <div class="card-body">

            <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <a href="#" class="btn btn-primary"><i class="bi bi-star"></i> Most Popular</a>
                    <a href="#" class="btn btn-primary"><i class="bi bi-eye"></i> Most Viewed</a>
                    <a href="#" class="btn btn-primary"><i class="bi bi-lightbulb"></i> Latest Ideas</a>
                    <a href="#" class="btn btn-primary"><i class="bi bi-chat-text"></i> Latest Comments</a>
                    <a href="submit_idea.php" class="btn btn-primary" style="background-color:#4CAF50; border-color:#4CAF50; float: right;"><i class="bi bi-file-earmark-text"></i> Submit Idea</a>
                  </div>
                </div>
              </div>

              <?php
            //displaying every ideas from database
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="card">';
              echo '<div class="card-body">';
              echo '<h1 class="card-title">' . $row['IdeaTitle'] . '</h1>';
              if ($row['IdeaAnonymous'] == 0) {
                echo '<h5 class="card-author">' . $row['Username'] . '</h5>';
              } else if ($row['IdeaAnonymous'] == 1) {
                echo '<h5 class="card-author">Anonymous</h5>';
              }

              echo '<h5 class="card-category">' . $row['CategoryTitle'] . '</h5>';
              echo '<p class="card-text">' . $row['IdeaDescription'] . '</p>';



              $ideaid = $row['IdeaId'];
              $imageidea_query = "SELECT IdeaImage FROM ideamedia_tbl WHERE IdeaId=$ideaid";
              $imageidea_result = mysqli_query($dbconn, $imageidea_query);
              $imageidea_count = mysqli_num_rows($imageidea_result);
              if ($imageidea_count > 0) {
                echo '<section class="pb-4">';
                echo '    <div class="bg-white border rounded-5">';
                echo '        <section class="p-4 d-flex w-100">';
                echo '            <div class="lightbox" data-mdb-zoom-level="0.25" data-id="lightbox-8e0in48hs">';
                echo '                <div class="row">';
                while ($imageidea_row = mysqli_fetch_assoc($imageidea_result)) {
                  $imageidea_path = '' . $imageidea_row['IdeaImage'];
                  if (file_exists($imageidea_path)) {
                    echo '   <div class="col-lg-4 mb-4">';
                    echo '         <img src="' . $imageidea_path . '"  alt="idea image" class="w-100 shadow-1-strong rounded mb-4" style="width: 150px; height: 150px; object-fit: contain;">';
                    echo '   </div>';
                  }
                }
                echo '</div>';
                echo '            </div>';
                echo '        </section>';
                echo '    </div>';
                echo '</section>';
              }



              echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewUserIdea">See more</button>';
              echo '<a href="#" class="btn btn-primary" style="background-color: darkcyan;"><i class="bi bi-hand-thumbs-up"></i></a>';
              echo '<a href="#" class="btn btn-primary" style="background-color: darkcyan;"><i class="bi bi-hand-thumbs-down"></i></a>';
              echo '</div>';
              echo '</div>';
            }
            ?>                   
                <!--
                  <form method="POST">
						        <input type="submit" class="like_btn" name="like_btn" value="Like" />
						        <input type="hidden" name="counter" value="<?php echo $_SESSION['counter']; ?>" />
						        <br/><?php echo $_SESSION['counter']; ?>
                    <input type="submit" class="dislike_btn" name="dislike_btn" value="Dislike" />
						        <input type="hidden" name="counter" value="<?php echo $_SESSION['counter']; ?>" />
						        <br/><?php echo $_SESSION['counter']; ?>
				          </form>  
  -->
        <!-- End Left side columns -->
      </div>

      <div class="pagination">
      <?php
			$sql_page = "SELECT COUNT(*) AS count FROM idea_tbl";
			$page_count = mysqli_query($dbconn, $sql_page);
			$row_count = mysqli_fetch_assoc($page_count);
			$total_rows = $row_count['count'];
			$total_pages = ceil($total_rows / $rows_per_page);
			
			for ($i = 1; $i <= $total_pages; $i++){
				echo'<a href="?page='.$i.'">'.$i.'</a>';
			}
		?>
    </div>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Krunker Idea Portal 2023</span></strong>. All Rights Reserved
    </div>
  </footer>
  <!-- End Footer -->

  <!-- Start View Idea Modal -->
  <div class="modal fade" id="viewUserIdea" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Username/ Anonymously</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Nav Scroller -->
                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-left"></i>
                        </a>
                    </span>

                    <span class="hs-nav-scroller-arrow-next" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-right"></i>
                        </a>
                    </span>
                </div>
                <!-- End Nav Scroller -->

                <!-- Modal PopUp Content -->
                <div class="tab-content">
                  <form action="" method="post" enctype="multipart/form-data">
                      <div class="row">
                          <h4 class="modal-title text-cap">Idea Title</h4>
                          <div class="flex-grow-1">
                            Idea description
                        </div>
                        <div class="d-flex justify-content-start">
                          <button class="btn"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></button>
                          <button class="btn"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></button>
                        </div>
                      </div>
                      <br>
                      <div class="row mb-4">
                          <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Enter comment here..."></textarea>
                          <div class="mb-3 form-check">
                            <input type="checkbox" id="anonymous" name="anonymous" class="form-check-input" value= 1>
                            <label for="anonymous" class="form-check-label">Post anonymously</label>
                          </div>
                          <div class="d-flex justify-content-end">
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button type="submit" name="submit_comment_post" class="btn btn-primary" data-bs-toggle="modal">Submit</button>
                            </div>
                        </div>
                      </div>
                  </form>
                </div>
                <!-- End Modal PopUp Content -->
            </div>
            <!-- End Body -->
        </div>
    </div>
  </div>
  <!-- End View Idea Modal -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>