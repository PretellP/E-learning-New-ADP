Chart.defaults.global.defaultFontSize = 10;
Chart.defaults.global.defaultFontColor = 'black';

(function(){

    $('.course-progress-results').each(function(e){

      var id = $(this).attr('id');
      var data_approved = $(this).data('approved');
      var data_suspended = $(this).data('suspended')

      const ctx = $('#progress-'+id);

      var progressDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: [
            'Aprobado',
            'Desaprobado'
          ],
          datasets: [{
            label: 'Evaluation Progress',
            data: [data_approved, data_suspended],
            backgroundColor: [
              'rgb(83, 175, 190)',
              'rgb(254, 92, 54)'
            ],
            responsive: true,
          }]
        },
        options: {
          cutoutPercentage: 65,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          tooltip: {
            position: 'average',
          }
        },
      });

    })

})(jQuery);







