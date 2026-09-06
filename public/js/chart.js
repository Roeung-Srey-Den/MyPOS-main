
    // -----------------Chart

document.addEventListener('DOMContentLoaded',function(){   
const ctx = document.getElementById('monthlyChart').getContext('2d');
    const verticalBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Nov','Dec'],
        datasets: [{
          label: 'Sales ($)',
          data: window.monthSales,
          backgroundColor: 'rgba(13, 110, 253, 0.7)', 
          borderColor: 'rgba(13, 110, 253, 1)',
          borderWidth: 1,
          borderRadius: 4,  
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => '$' + value 
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top',
          },
          tooltip: {
            enabled: true,
            callbacks: {
              label: context => '$' + context.parsed.y
            }
          }
        },
        animation: {
          duration: 500,
          easing: 'easeOut'
        },
        responsive: true,
        maintainAspectRatio: false,
      }
    });

    // Weekly Chart
    const weekChart = document.getElementById("weeklyChart").getContext("2d");
    const newChart = new Chart(weekChart,{
      type:'bar',
      data:{
        labels : ['Week 01','Week 02','Week 03','Week 04'],
        datasets:[{
          label : 'Sale ($)',
          data : weekSales,
          backgroundColor:'#03de03ff',
          borderWidth: 1,
          borderRadius: 4,
        }]
      }
    });

    //Daily Chart
    const dailyCharts = document.getElementById("dailyChart").getContext("2d");
    const newChart2 = new Chart(dailyCharts,{
      type:'bar',
      data:{
        labels:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
        datasets:[{
          label:"Sale ($)",
          data: dailySales,
          backgroundColor:'rgba(233, 195, 25, 1)',
          borderWidth:1,
          borderRadius:4,   
        }]
      }
    });


    });
