<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <title>Mako ImageMagick</title>
        <!-- Font Awesome -->
        <link
        href="/assets/css/font-awesome.css"
        rel="stylesheet"
        />
        <!-- Google Fonts -->
        <link
        href="/assets/css/google-fonts.css"
        rel="stylesheet"
        />
        <!-- MDB -->
        <link
        href="/assets/css/mdb.css"
        rel="stylesheet"
        />
    </head>
    <body>
        <div class="main">
            <br>
            <div class="upload" style="width:40%;margin:0 auto"">
				<form action="/index.php/upload" method="post" enctype="multipart/form-data">
					<input class="form-control form-control-lg" id="image" name="image" type="file" />
					<br>
					<button type="submit" class="btn btn-danger btn-lg">添加照片</button>
				</form>
            </div>
            <br><br>
            <div class="images" style="width:40%;text-align:center;margin:0 auto">
                {% foreach($images as $fileName => $data) %}
                <div class="card">
                    <img src="{{$data}}" class="card-img-top" alt="Loading..."/>
                    <div class="card-body">
                        <h5 class="card-title">{{$fileName}}</h5>
                        <a onclick="edit(this)" class="btn btn-primary">编辑</a>
                    </div>
                </div><br>
                {% endforeach %}
            </div>
        </div>


        <script
        type="text/javascript"
        src="/assets/js/mdb.js"
        ></script>
        <script>
			function edit(button){
				const filename=button.parentNode.getElementsByTagName('h5')[0].innerText
				window.location='/index.php/edit?filename='+filename
			}
        </script>
    </body>
</html>
