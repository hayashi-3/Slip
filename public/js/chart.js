var ctx = document.getElementById("pieChart");

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: subject_names,
    datasets: [{
        backgroundColor: [
            "#0000cd",
            "#1e90ff",
            "#6495ed",
            "#add8e6"
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