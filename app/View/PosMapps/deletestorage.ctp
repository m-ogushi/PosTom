<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Local Storage��S�č폜������</title>
</head>
<body>
	<script type="text/javascript">
		var r = confirm("Local Storage��S�č폜���܂����H");
		if (r === true) {
			localStorage.clear();
			document.write("Local Storage��S�č폜���܂����B");
		} else {
			document.write("�L�����Z�����܂����B");
		}
	</script>
</body>
</html>