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
<div id="main" style="width:50%;margin:0 auto;text-align:center">
	<br>
	<h4>文件名: {{$fileName}}</h4>
	<br><br>
	<h5>
	宽度：{{$dimensions['width']}}
	</h5>
	<br>
	<h5>
	高度：{{$dimensions['height']}}
	</h5>
	<br>
	<form action="/index.php/edit" method="post" enctype="multipart/form-data">
		<div class="form-outline">
				<input type="text" id="rotate" name="degrees" class="form-control" />
				<input hidden="true" name="filename" value="{{$fileName}}"/>
				<label class="form-label" for="rotate">旋转度数</label>
		</div>
		<br>
		(其他功能正在开发中)
		<br>
		<br>
		<button type="submit" class="btn btn-primary">提交</button>
	</form>

</div>


<script
        type="text/javascript"
        src="/assets/js/mdb.js"
        ></script>
</body>
</html>
