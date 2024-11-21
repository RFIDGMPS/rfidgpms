<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Personnel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
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
