const chartCanvas = document.getElementById('chart').getContext('2d');

const data = {
  labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio'],
  datasets: [
    {
      label: 'Vendas',
      data: [120, 150, 180, 90, 200],
      backgroundColor: 'rgba(75, 192, 192, 0.6)', 
      borderWidth: 1, 
    },
  ],
};

const options = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true,
    },
  },
};

const chart = new Chart(chartCanvas, {
  type: 'bar',
  data: data,
  options: options,
});