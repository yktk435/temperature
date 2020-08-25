window.onload = function() {
  view();
  let sl = document.querySelector("select.date")
  sl.value = today();
}

function view(date,from=0,to=0) {
  if (!date) date = today();
  console.log(date)
  let room_temp = [];
  let room_hum = [];
  let cpu = [];
  let labels = []
  let range = {
    from:from ,
    to:to
  }
  let discom=[]

  fetch('http://192.168.3.2/temperature/getData.php?date=' + date)
    .then(function(response) {
      return response.text();
    })
    .then(function(myJson) {
      // console.log(myJson)
      myJson = JSON.parse(myJson);
      // console.log(myJson)
      myJson.forEach((e) => {
        room_temp.push(parseFloat(e.room_temp));
        room_hum.push(parseFloat(e.room_hum));
        cpu.push(parseFloat(e.cpu));
        labels.push(getDatetime(new Date(Number(e.time * 1000))))
        discom.push(Math.ceil(0.81*e.room_temp+0.01*e.room_hum*(0.99*e.room_temp-14.3)+46.4))
      })
      graf(labels, room_temp, room_hum, cpu, date,range,discom)
    });
}

function change() {
  let sl = document.querySelector("select.date")
  view(sl.value);
}

function getDatetime(now) {
  let Hour = ("0" + now.getHours()).slice(-2);
  let Min = ("0" + now.getMinutes()).slice(-2);
  let Sec = ("0" + now.getSeconds()).slice(-2);
  return Hour + ":" + Min;
}

function today(date) {
  let now = new Date();
  let Y = now.getFullYear();
  let M = ("0" + (Number(now.getMonth()) + 1)).slice(-2);
  let D = ("0" + now.getDate()).slice(-2);
  return date = Y + '_' + M + '_' + D;
}

function graf(labels, room_temp, room_hum, cpu, date,range,discom) {
console.log(labels)
  let ctx = document.getElementById('myChart').getContext('2d');

  let myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "室温",
        data: room_temp,
        borderColor: "rgb(255, 99, 132)",
        backgroundColor: "rgba(255, 99, 132, 0)"
      }, {
        label: "湿度",
        data: room_hum,
        borderColor: "rgb(54, 162, 235)",
        backgroundColor: "rgba(54, 162, 235, 0)"
      }, {
        label: "CPU",
        data: cpu,
        borderColor: "rgb(120, 120, 120)",
        backgroundColor: "rgba(54, 162, 235, 0)"
      },
      {
        label: "不快指数",
        data: discom,
        borderColor: "rgb(17, 184, 18)",
        backgroundColor: "rgba(54, 162, 235, 0)"
      }]
    },
    options: {
      tooltips: {
        callbacks: {}
      },
      title: {
        display: true,
        text: '温湿度とラズパイ温度 ' + date
      },
      elements: {
        line: {
          tension: 0
        }
      },
      scales: {
        xAxes: [{
          type: 'time',
          time: {
            parser: "mm:ss", //<- use 'parser'
            unit: 'minute',
            unitStepSize: 1,
            displayFormats: {
              'minute': 'mm',
            },
          },
          
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true
          },

        }]
      }
    }
  });
}


function setRange() {
  let from = document.querySelector('.range-from').value
  let to = document.querySelector('.range-to').value
  console.log(from, to)
  if (from - to > 0) {

  }

}