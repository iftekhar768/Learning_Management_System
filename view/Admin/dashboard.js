const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['FST', 'FEE', 'FBA'],
        datasets: [{
          label: 'Courses',
          data: [],
          backgroundColor: '#3498db'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } }
      }
    });
 