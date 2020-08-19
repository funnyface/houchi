<?php date_default_timezone_set('Asia/Tokyo'); ?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>レベルアップまでどれくらい？ - 放置少女</title>
</head>
<body>
<p>
今日は<span id="day-of-week"><?php echo ["日", "月", "火", "水", "木", "金", "土"][date("w")]; ?></span>曜日
(経験値<span id="disp-rate">1</span>倍)
</p>

[戦役画面の表示]<br>
LvUPまで：
<input type="number" name="day" id="input-day" min="0" style="width:3em; height:1.5em;">日
<input type="number" name="hour" id="input-hour" min="0" max="23" style="width:3em; height:1.5em;">時間

<p>
[実質]<br>
LvUPまで約<span id="output" style="font-weight:bold;font-size:1.5em;"></span>
</p>
<script>
	const dow_rate = [2.5, 1.5, 1, 1, 2.5, 1.5, 1];

	const d = 0;
	const h = 1;
	const inputs = document.querySelectorAll('input');
	const output = document.getElementById('output');

	const current_dow = new Date().getDay();

	document.getElementById('disp-rate').textContent = dow_rate[current_dow];


	inputs.forEach(function(item){
		item.addEventListener('input', function(){
			var data = getData();

			var hours = parseInt(data[d])*24 + parseInt(data[h]);
			// 経験値倍率がかかっている曜日の場合は等倍に戻す
			hours = hours * dow_rate[current_dow];

			var rest_days = 0;
			var rest_hours = 0;

			while(true){
				var dd = dow_rate[(current_dow + rest_days) % 7];
				var dh = dd*24;
				if(hours >= dh){
					hours = hours - dh;
				} else {
					rest_hours = hours / dd;
					break;
				}
				rest_days++;
			}

			output.textContent = rest_days + "日" + Math.round(rest_hours) + "時間";
		});
	});

	function getData(){
		var data = [];
		var input_day = document.getElementById("input-day");
		var input_hour = document.getElementById("input-hour");

		data[0] = parseInt(input_day.value) || 0;
		data[1] = parseInt(input_hour.value )|| 0;

		if(data[0] < 0) {
			data[0] = 0;
		}

		if(data[1] < 0) {
			data[1] = 0;
		}else if(data[1] >= 24) {
			data[1] = 23;
		}

		input_day.value = data[0] || '';
		input_hour.value = data[1] || '';

		return data;
	}
</script>
</body>
</html>