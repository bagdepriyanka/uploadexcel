<!doctype html>
<html>

<head>
    <title>axios - file upload example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap 5 files -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="./js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/axios.min.js"></script>
</head>

<body class="container">
    <h1>file upload</h1>

    <form role="form" class="form" onsubmit="return false;">
        <div class="form-group">
            <input id="file" type="file" class="form-control" />
        </div>
        <button id="upload" type="button" class="btn btn-primary">Upload</button>
    </form>

    <div id="output" class="container"></div>
    <div id="result"></div>
    <script>
        var source = new EventSource("post_axios.php");
        source.onmessage = function(event) {
            document.getElementById("result").innerHTML += event.data + "<br>";
        };
        
        (function() {
            var output = document.getElementById('output');
            document.getElementById('upload').onclick = function() {
                var data = new FormData();
                //data.append('foo', 'bar');
                data.append('filename', document.getElementById('file').files[0]);

                var config = {
                    onUploadProgress: function(progressEvent) {
                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        console.log(percentCompleted);
                    }
                };

                axios.post('upload_action.php', data, config)
                    .then(function(res) {
                        output.className = 'container';
                        output.innerHTML = res.data;
                    })
                    .catch(function(err) {
                        output.className = 'container text-danger';
                        output.innerHTML = err.message;
                    });
            };
        })();
    </script>
</body>

</html>