<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
?>
<body>
    <h2>Search Personnel</h2>
    <input type="text" id="search-box" placeholder="Type a name..." />
    <div id="results"></div>

    <script>
        $(document).ready(function () {
            $("#search-box").on("input", function () {
                let query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "fetch_personnel.php",
                        method: "POST",
                        data: { query: query },
                        success: function (data) {
                            $("#results").html(data);
                        }
                    });
                } else {
                    $("#results").html(""); // Clear results when input is empty
                }
            });
        });
    </script>
</body>
</html>
