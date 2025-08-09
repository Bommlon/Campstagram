<!DOCTYPE html>
<html>

<head>
        <title>Campstagram</title>
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="checkCrappynes.js"></script>
</head>

<body>
        <div id="hider" style="display: none;"></div>
        <div id="upload-popup" style="display: none;">
                <form action="upload.php" method="post" enctype="multipart/form-data" id="upload-form">
                        <div id="form-title">
                                <h2>Upload your picture</h2>
                        </div>

                        <div id="form-input">
                                <input type="file" id="fileInput" name="image" accept="image/*" required>
                                <input type="text" name="description" maxlength="200" placeholder="describe your awesome picture"
                                required>
                        </div>

                        <div id="form-buttons">
                                <button type="button" class="no-button" onclick="closeUploadForm()">Cancel</button>
                                <button type="submit" class="yes-button">Upload</button>
                        </div>
                </form>
        </div>

        <div id=header>
                <h1>Campstagram</h1>
                <button id="add_picture" onclick="showUploadForm()">add your picture</button>
                <a id="about" href="about.html">about</a>
        </div>
        <div id="pic_list">
                <?php
                // initial loading of 20 images
                $folder = 'pictures';
                $images = glob($folder . '/*{jpg,jpeg,png,gif}', GLOB_BRACE);
                //shuffle($images);     // give them a good shake
                rsort($images); // show newest first

                $total = count($images);
                $perPage = 20;
                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

                $start = ($page - 1) * $perPage;
                $imagesToShow = array_slice($images, $start, $perPage);
                require_once 'checkCrappynes.php';

                foreach ($imagesToShow as $image) {
                        $isCrappy = jpegCommentContainsString($image);
                        $name = basename($image);
                        $text = substr($name, 10);      // cuts first 10 characters (timestamp)
                        //$text = preg_replace('/_[0-9]{10}(?=\.(jpg|jpeg|png|gif))/i', '', $name);  // remove timestamp (10 digit number just before file extension)
                        $text = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '', $text);    // remove file extension
                        $text = str_replace('_', ' ', $text);   // replace _ with space
                        echo "
                        <div class = 'post-container' vibe = $isCrappy>
                        <div class = 'post'>
                        <img src='img.php?name={$name}' loading='lazy' />
                        <div class = 'description'>$text</div>
                        </div>
                        </div>
                        ";
                }
                ?>
        </div>
        <input type="hidden" id="page" value="1">
</body>

<script>
        // show and hide upload-popup
        function showUploadForm() {
                window.scrollTo(top);
                document.getElementById("hider").style.display = "block";
                document.getElementById("upload-popup").style.display = "block";
                document.body.classList.add("popup-open");
        }
        function closeUploadForm() {
                document.getElementById("hider").style.display = "none";
                document.getElementById("upload-popup").style.display = "none";
                document.body.classList.remove("popup-open");
        }

        // restrict file size to 2MB
        document.getElementById("fileInput").addEventListener('change', () => {
                const fileInput = document.getElementById('fileInput');
                if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        const fileSizeInMB = file.size / 1024 / 1024;

                        if (fileSizeInMB > 8) {
                                alert('file too big (>8MB)');
                                fileInput.value = null;
                        }
                }
        });

        // automatically load more pictures
        let loading = false;

        function loadNextPage() {
                if (loading) return;
                loading = true;

                const pageInput = document.getElementById('page');
                let page = parseInt(pageInput.value, 10) + 1;

                console.log('requesting page:', page);

                fetch('load.php?page=' + page + '&_=' + new Date().getTime())   // we add time as a dummy parameter to fix issues with caching
                        .then(response => response.text())
                        .then(html => {
                                if (html.trim()) {
                                        const container = document.getElementById('pic_list');
                                        container.insertAdjacentHTML('beforeend', html);
                                        pageInput.value = page;
                                        loading = false;
                                } else {
                                        // no more images to load
                                        window.removeEventListener('scroll', handleScroll);
                                }
                        })
                        .catch(error => {
                                console.error('Error loading images:', error);
                                loading = false;
                        });
        }

        function handleScroll() {
                const scrollBottom = window.innerHeight + window.scrollY;
                const documentHeight = document.body.offsetHeight;

                if (scrollBottom >= documentHeight - 300) {
                        loadNextPage();
                }
        }

        window.addEventListener('scroll', handleScroll);
        window.addEventListener('load', () => {
                window.scrollTo(top);
                document.getElementById('page').value = 1;
        });
</script>

</html>
