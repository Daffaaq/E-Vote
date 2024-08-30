var optionsProfileVisit = {
  annotations: {
    position: "back",
  },
  dataLabels: {
    enabled: false,
  },
  chart: {
    type: "bar",
    height: 300,
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {},
  series: [
    {
      name: "sales",
      data: [9, 20, 30, 20, 10, 20, 30, 20, 10, 20, 30, 20],
    },
  ],
  colors: "#435ebe",
  xaxis: {
    categories: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
  },
}
let optionsVisitorsProfile = {
  series: [totalstudent, totalvoter],
  labels: ["Total Siswa", "Total Pemilih"],
  colors: ["#435ebe", "#55c6e8"],
  chart: {
    type: "donut",
    width: "100%",
    height: "350px",
  },
  legend: {
    position: "bottom",
  },
  plotOptions: {
    pie: {
      donut: {
        size: "30%",
      },
    },
  },
}

let warna = [
  "#435ebe", // Warna untuk kandidat pertama
  "#55c6e8", // Warna untuk kandidat kedua
  "#F44336", // Merah
  "#E91E63", // Merah Muda
  "#9C27B0", // Ungu
  "#673AB7", // Ungu Tua
  "#3F51B5", // Biru Indigo
  "#2196F3", // Biru Muda
  "#03A9F4", // Biru Langit
  "#00BCD4", // Biru Cyan
  "#009688", // Hijau Tosca
  "#4CAF50", // Hijau
  "#8BC34A", // Hijau Muda
  "#CDDC39", // Kuning
  "#FFEB3B", // Kuning Muda
  "#FFC107", // Jingga
  "#FF9800", // Oranye
  "#FF5722", // Merah Oranye
  "#795548", // Coklat
  "#9E9E9E", // Abu-abu
  "#607D8B", // Abu-abu Biru
  "#000000", // Hitam
  "#FFFFFF", // Putih
  // Tambahkan lebih banyak warna jika diperlukan
];

// Pastikan jumlah warna sama dengan jumlah kandidat
if (warna.length < datanjumlahvote.length) {
  // Jika tidak cukup warna, tambahkan warna default atau loop kembali
  let defaultColor = "#cccccc"; // Warna default jika kurang
  while (warna.length < datanjumlahvote.length) {
    warna.push(defaultColor);
  }
}
let optionsCandidate = {
  series: datanjumlahvote,
  labels: datanamacandidate,
  colors: warna,
  chart: {
    type: "donut",
    width: "100%",
    height: "350px",
  },
  legend: {
    position: "bottom",
  },
  plotOptions: {
    pie: {
      donut: {
        size: "30%",
      },
      dataLabels: {
        formatter: function (t) {
          return t.toFixed(1) + "%"
        },
        style: {
          colors: ["#fff"]
        },
        background: {
          enabled: !1
        },
        dropShadow: {
          enabled: !0
        }
      },
    },
  },
}

var optionsEurope = {
  series: [
    {
      name: "series1",
      data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605],
    },
  ],
  chart: {
    height: 80,
    type: "area",
    toolbar: {
      show: false,
    },
  },
  colors: ["#5350e9"],
  stroke: {
    width: 2,
  },
  grid: {
    show: false,
  },
  dataLabels: {
    enabled: false,
  },
  xaxis: {
    type: "datetime",
    categories: [
      "2018-09-19T00:00:00.000Z",
      "2018-09-19T01:30:00.000Z",
      "2018-09-19T02:30:00.000Z",
      "2018-09-19T03:30:00.000Z",
      "2018-09-19T04:30:00.000Z",
      "2018-09-19T05:30:00.000Z",
      "2018-09-19T06:30:00.000Z",
      "2018-09-19T07:30:00.000Z",
      "2018-09-19T08:30:00.000Z",
      "2018-09-19T09:30:00.000Z",
      "2018-09-19T10:30:00.000Z",
      "2018-09-19T11:30:00.000Z",
    ],
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
    },
  },
  show: false,
  yaxis: {
    labels: {
      show: false,
    },
  },
  tooltip: {
    x: {
      format: "dd/MM/yy HH:mm",
    },
  },
}

let optionsAmerica = {
  ...optionsEurope,
  colors: ["#008b75"],
}
let optionsIndonesia = {
  ...optionsEurope,
  colors: ["#dc3545"],
}

var chartProfileVisit = new ApexCharts(
  document.querySelector("#chart-profile-visit"),
  optionsProfileVisit
)
var chartVisitorsProfile = new ApexCharts(
  document.getElementById("chart-visitors-profile"),
  optionsVisitorsProfile
)
var chartcandidate = new ApexCharts(
  document.getElementById("chart-candidate"),
  optionsCandidate
)
var chartEurope = new ApexCharts(
  document.querySelector("#chart-europe"),
  optionsEurope
)
var chartAmerica = new ApexCharts(
  document.querySelector("#chart-america"),
  optionsAmerica
)
var chartIndonesia = new ApexCharts(
  document.querySelector("#chart-indonesia"),
  optionsIndonesia
)

chartIndonesia.render()
chartAmerica.render()
chartEurope.render()
chartProfileVisit.render()
chartVisitorsProfile.render()
chartcandidate.render()

document.getElementById('download-chart').addEventListener('click', function () {
  chartcandidate.dataURI().then((uri) => {
    // Buat elemen <a> untuk mengunduh gambar
    let a = document.createElement('a');
    a.href = uri.imgURI;
    a.download = 'chart-perbandingan-kandidat-persen.png';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });
});

