<?php

@include 'inc/config.php';

session_start();


$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
    header('location:loginpage.php');
    exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
        $user_type = $row['user_type'];
        $user_type1 = $row['user_type1'];
        $work_location = $row['work_location'];

        if ($user_type1 !== 'admin' && $user_type !== 'user') {
            header('location:loginpage.php');
            exit();
        }
    } else {
        die("Error: Unable to fetch user details.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aKonnect</title>
    <script src="https://kit.fontawesome.com/26eea4c998.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .accordion {
            display: none;
            margin-top: 10px;
        }

        .comment-input {
            width: calc(100% - 60px);
            padding: 10px;
        }

        .imageThumb {
            max-height: 250px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: white;
            color: black;
        }

        .blue-color {
            background-color: white !important;
            color: blue;
        }
    </style>
</head>

<body>
    <?php
    $sql = "SELECT e.empname, e.pic
    FROM emp e
    JOIN user_form uf ON e.empemail = uf.email
    WHERE uf.email = '$user_name' ";

    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $empname = $row['empname'];
    $pic = $row['pic'];
    ?>
    <div class="head-top">
        <div class="heading">
            <h3>aKonnect</h3>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <img src="public/logo-1@2x.png" class="anika-logo">
            <div class="logo">Anika <span>HRM</span></div>
            <ul class="nav">
                <li><img class="material-symbols-lightdashboa-icon" loading="lazy" alt="" src="./public/materialsymbolslightdashboardoutline.svg" /><a href="#">Dashboard</a></li>
                <li><img class="employee-icon" loading="lazy" alt="" src="./public/vector-1.svg" /> <a href="#">Employee List</a></li>
                <li> <img class="leave-icon" loading="lazy" alt="" src="./public/vector-2.svg" /> <a href="#">Leaves</a></li>
                <li><img class="onboarding-icon" loading="lazy" alt="" src="./public/vector-3.svg" /><a href="#">Onboarding</a></li>
                <li><img class="attendance-icon" loading="lazy" alt="" src="./public/vector-4.svg" /> <a href="#">Attendance</a></li>
                <li><img class="arcticonsgoogle-pay" loading="lazy" alt="" src="./public/arcticonsgooglepay.svg" /><a href="#"> Payroll</a></li>
                <li><img class="streamlineinterface-content-c-icon" loading="lazy" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" /> <a href="#">Reports</a></li>
                <li class="active"></i><a href="#"><i class="fa-regular fa-square-check icon"></i> aKonnect</a></li>
            </ul>
            <button class="logout">

                <i class="fa-solid fa-right-from-bracket"></i>Logout</button>
        </div>


        <div class="container">
            <div class="content" id="container">
                <form id="insertForm">
                    <div class="content-1">
                        <div class="inside">
                            <img style="height:50px;" src="../pics/<?php echo $pic; ?>" alt="Profile Picture">
                            <input type="text" name="mssg1" placeholder="What's on your mind">
                            <input type="hidden" name="empname" value="<?php echo $empname ?>">
                            <input type="hidden" name="pic" value="<?php echo $pic ?>">
                            <button id="btn">Post</button>
                        </div>
                        <hr>
                        <div class="button-1">
                            <button type="button" class="btn-1" id="photo"><i class="fa-solid fa-photo-film"> </i>Share Photo</button>
                            <button type="button" class="btn-2" id="video"><i class="fa-solid fa-video"></i>Share Videos</button>
                        </div>
                    </div>

                    <div id="modal" class="modal">
                        <div class="modal-content modal-1">
                            <span class="close">&times;</span>
                            <h3>Share Photo</h3>
                            <hr>
                            <div class="modal-div">
                                <img style="height:50px;" src="../pics/<?php echo $pic; ?>" alt="Profile Picture">
                                <input type="text" name="mssg2" placeholder="What's on your mind?">
                            </div>
                            <div class="file-input-container" style="position: relative;">
                                <label for="file" class="add-photo-label">
                                    <div class="add-photo">
                                        <i class="fas fa-images"></i>
                                        <span>Add Photos</span>
                                    </div>
                                </label>
                                <input type="file" id="files" name="photo" />
                                <!-- <input type="file" name="photo" id="file" class="file-input" accept="image/*" /> -->
                            </div>
                            <button type="submit" class="share-btn">Share</button>
                        </div>
                    </div>

                    <div id="modal-2" class="modal">
                        <div class="modal-content modal-1">
                            <span class="close-1">&times;</span>
                            <h3>Share Video</h3>
                            <hr>
                            <div class="modal-div">
                                <img style="height:50px;" src="../pics/<?php echo $pic; ?>" alt="Profile Picture">
                                <input type="text" name="mssg3" placeholder="What's on your mind?">
                            </div>
                            <div class="file-input-container">
                                <label for="file" class="add-photo-label">
                                    <div class="add-photo">
                                        <i class="fas fa-images"></i>
                                        <span>Add Video</span>
                                    </div>
                                </label>
                                <input type="file" name="video" id="file" class="file-input" accept="video/*" />
                            </div>
                            <button type="submit" class="share-btn">Share</button>
                        </div>
                    </div>
                </form>


                <div class="content-2">
                    <button><i class="fa-regular fa-clock"></i>Most Recent Posts</button>
                    <button><i class="fa-regular fa-heart"></i>Most Liked Posts</button>
                    <button><i class="fa-regular fa-comment-dots"></i>Most Commented Posts</button>
                </div>

                <?php
                $liked_posts = array();
                $sql_likes = "SELECT post_id FROM aKonnect_likes WHERE empname = '$empname' AND status = 1 ";
                $result_likes = $con->query($sql_likes);
                if ($result_likes->num_rows > 0) {
                    while ($row_likes = $result_likes->fetch_assoc()) {
                        $liked_posts[] = $row_likes['post_id'];
                    }
                }

       
                $sql_posts = "SELECT * FROM aKonnect ORDER BY posted DESC";
                $result_posts = $con->query($sql_posts);
                if ($result_posts->num_rows > 0) {
                    while ($row = $result_posts->fetch_assoc()) {
                        $empname = $row['empname'];
                        $pic = $row['pic'];
                        $posted = $row['posted'];
                        $mssg = $row['mssg'];
                        $post_content = $row['post_content'];
                        $post_id = $row['post_id'];

                        $is_liked = in_array($post_id, $liked_posts);
                        
                        $sql_likes1 = "SELECT COUNT(*) AS like_count FROM aKonnect_likes WHERE post_id = '$post_id' AND status = 1";
                        $result_likes1 = $con->query($sql_likes1);
                        $like_count = 0;
                        if ($result_likes1->num_rows > 0) {
                            $like_data = $result_likes1->fetch_assoc();
                            $like_count = $like_data['like_count'];
                        }
        

                ?>
                        <div class="content-3">
                            <div class="inside">
                                <div class="ins">
                                    <img src="../pics/<?php echo $pic; ?>" alt="Profile Picture">
                                    <div class="inside-in">
                                        <h4><?php echo $empname ?></h4>
                                        <p><?php echo $posted ?></p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-ellipsis"></i>
                                    <div class="dropdown">
                                        <a href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mssg">
                                <p><?php echo $mssg ?></p>
                            </div>
                            <div class="photo">
                                <img class="posted-img" src="Photos/<?php echo $post_content; ?>" alt="Posted Photo">
                            </div>
                            <hr>
                            <div class="con-icons">
                                <div class="icons">

                                    <div class="icons-1 thumbs-up-icon <?php echo $is_liked ? 'blue-color' : ''; ?>" data-post-id="<?php echo $post_id; ?>">
                                        <i class="fa-regular fa-thumbs-up "></i>
                                    </div>

                                    <div class="icons-1"><i class="fa-regular fa-comment-dots"></i></div>
                                </div>
                                <div class="likes">
                                    <div class="like">
                                        <p><?php echo $like_count ?> Likes</p>
                                    </div>
                                    <p class="comments-count">0 comments</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <input class="comment-input" type="text" placeholder="Add a comment...">
                                <button class="post-button">Post</button>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No posts found.";
                }
                ?>


            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $(".thumbs-up-icon").click(function() {
                var post_id = $(this).data("post-id");
                var icon = $(this).find("i");

                icon.toggleClass("blue-color");

                var action = icon.hasClass("blue-color") ? "like" : "unlike";

                if (action === 'unlike') {
                    $.ajax({
                        type: "POST",
                        url: "update_ak_likes.php",
                        data: {
                            empname: '<?php echo $empname; ?>',
                            post_id: post_id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Like removed!',
                                text: 'Your like has been successfully removed.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to remove like. Please try again later.',
                                confirmButtonText: 'OK'
                            });

                            console.error("Error removing like: " + error);
                            console.log("Status:", status);
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "insert_ak_likes.php",
                        data: {
                            empname: '<?php echo $empname; ?>',
                            post_id: post_id,
                            action: action
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Like added!',
                                text: 'Your have liked this post !',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to add like. Please try again later.',
                                confirmButtonText: 'OK'
                            });

                            console.error("Error adding like: " + error);
                            console.log("Status:", status);
                        }
                    });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".thumbs-up-icon").click(function() {
                $(this).toggleClass("blue-color");
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove image</span>" +
                                "</span>").insertAfter("#files");
                            $(".remove").click(function() {
                                $(this).parent(".pip").remove();
                            });


                        });
                        fileReader.readAsDataURL(f);
                    }
                    console.log(files);
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#insertForm").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "insert_ak_post.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: response,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to insert data. Please try again later.'
                        });
                    }
                });
            });
        });
    </script>


    <script>
        var icon = document.querySelector('.fa-regular.fa-comment-dots');
        var accordion = document.querySelector('.accordion');

        icon.addEventListener('click', function(event) {
            event.stopPropagation();
            accordion.style.display = accordion.style.display === 'none' || accordion.style.display === '' ? 'block' : 'none';
        });

        document.addEventListener('click', function() {
            accordion.style.display = 'none';
        });

        accordion.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
    <script>
        var modal = document.getElementById("modal");
        var btn = document.getElementById("photo");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        var modal2 = document.getElementById("modal-2");
        var btn2 = document.getElementById("video");
        var span2 = document.getElementsByClassName("close-1")[0];
        btn2.onclick = function() {
            modal2.style.display = "block";
        }

        span2.onclick = function() {
            modal2.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal2) {
                modal2.style.display = "none";
            }
        }

        var icon = document.querySelector('.fa-solid.fa-ellipsis');
        var dropdown = document.querySelector('.dropdown');

        icon.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        });

        document.addEventListener('click', function() {
            dropdown.style.display = 'none';
        });

        dropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>

</body>

</html>