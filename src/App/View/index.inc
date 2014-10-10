<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Test task</title>
  </head>
  <body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
	var View = function  () {
		var form = $("<p>").append(
			$("<input>", {type: "text"})
		).append(
			$("<button>", {type: "submit"}).text("submit")
		);
		
		var result = $("<p>").append(
			$("<span>")
		);

		var setResult = function (url) {
			result.find("span").text(url);
		}

		var sendRequest = function () {
			var url = form.find("input").val().trim();

			$.ajax({
				type: "POST",
				data : {url: url},
			    dataType : "text",
			    async : false,
			    success: function (alias) { 
			    	setResult(alias);
			    }
			});
		}

		return {
			set : function(element) {
				$(element).append(form).append(result);

				form.find("button").on("click", sendRequest);
			}
		};
	}
	</script>
	
	<script>
	$(document).ready(function(){
		new View().set("body");
	});
	</script>
  </body>
</html>