var chartArray = [];

function reloadTable(answer) {
	var html = '<table class="table table-striped"><tr><th>日付</th><th>最高値</th><th>最低値</th><th>心拍数</th><th>コメント</th><th></th></tr>';
	chartArray[0] = ["日付","最高値","最低値","心拍数"];
	for (var i=0; i < answer.length; i++) {
		chartArray[i+1] = [String(answer[i].ymd),parseInt(answer[i].maxval),parseInt(answer[i].minval),parseInt(answer[i].rate)];

		html += '<tr><td>' + answer[i].ymd
		 + '</td><td>' + answer[i].maxval
		 + '</td><td>' + answer[i].minval
		 + '</td><td>' + answer[i].rate
		 + '</td><td>' + answer[i].comment
		 + '</td><td>'
		 + '<button class="remove btn btn-danger" onclick="deleteData('
		 + answer[i].id
		 + ')">×</button>'
		 + '</td></tr>';
	}
	html += '</table>';

	$("#resultDiv").empty();
	$('#resultDiv').append(html);
	$('#resultText').empty();
	$('#resultText').append('総データ数：'+answer.length);
}

function getAllData(){
	$.ajax({
		type: "POST",
		url: "select.php",
		cache : false,
		data: {},
		success: function(answer){
			reloadTable(answer);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Error : ' + errorThrown);
        }
	});
}

function checkValue(ymd,maxval,minval,rate,comment,password){
	if (String(ymd).length != 8){
		alert("日付を正しく入力してください");
		return false;
	} else if (!$.isNumeric(ymd) || !$.isNumeric(maxval) || !$.isNumeric(minval) || !$.isNumeric(rate)) {
		alert("コメント以外は半角数字で入力してください");
		return false;
	} else if (!$.isNumeric(password) || String(password).length != 8) {
		alert("編集用パスワードが間違っています。ページ最下部に正しく入力してください");
		return false;
	} else {
		return true;
	}
}

function createNewData(){
	var ymd = parseInt($('#ymd').val());
	var maxval = parseInt($('#maxval').val());
	var minval = parseInt($('#minval').val());
	var rate = parseInt($('#rate').val());
	var comment = String($('#comment').val());
	var password = parseInt($('#password').val());
	if ( checkValue(ymd,maxval,minval,rate,comment,password) ){

		$.ajax({
			type: "POST",
			url: "create.php",
			cache : false,
			data: {
			    "ymd":ymd,"maxval":maxval,"minval":minval,"rate":rate,"comment":comment,"password":password
			},
			success: function(){
				getAllData();
				resetForm();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
	            alert('Error : ' + errorThrown);
	        }
		});
	} else {
		return;
	}
}

function deleteData(id){
	var password = parseInt($('#password').val());
	if ( checkValue(10000000,0,0,0,null,password) ){

		$.ajax({
			type: "POST",
			url: "delete.php",
			cache : false,
			data: {
			    "id":id,"password":password
			},
			success: function(){
				console.log("delete success");
				getAllData();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log("delete error");
	            alert('Error : ' + errorThrown);
	        }
		});
	} else {
		return;
	}
}

function reloadChart() {  
	var data = google.visualization.arrayToDataTable(chartArray);
	var chart = new google.visualization.LineChart(document.getElementById('chartDiv'));
	var options = null;
	chart.draw(data,options);
}

function getYMD(){
	var now = new Date();
	return now.getFullYear()+("0"+(now.getMonth()+1)).slice(-2)+("0"+now.getDate()).slice(-2);
}

function resetForm(){
	$('#ymd').val("");
	$('#maxval').val("");
	$('#minval').val("");
	$('#rate').val("");
	$('#comment').val("");
}

(function initialize(){
	$('#ymd').val(getYMD());
	getAllData();
})();
