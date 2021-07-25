var ctx = document.getElementById("pieChart");

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: subject_names,
    datasets: [{
        backgroundColor: [
            "#87cefa",
            "#87ceeb",
            "#add8e6",
            "#afeeee"
        ],
        data: subtotal
    }]
  },
  options: {
    title: {
      display: true,
      text: '支出 割合'
    }
  }
});