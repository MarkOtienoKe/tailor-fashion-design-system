(function () {
  $.typeahead({
    input: '.weather-station-search',
    minLength: 0,
    maxItem: 15,
    order: "asc",
    hint: true,
    accent: true,
    searchOnFocus: true,
    backdrop: {
      "background-color": "#3879d9",
      "opacity": "0.1",
      "filter": "alpha(opacity=10)"
    },
    display: ["weather_point_name"],
    source: {
      users: {
        ajax: {
          url: '/data/weather_stations',
          data: 'response'
        }
      }
    },
    emptyTemplate: "no result found",
    callback: {
      onEnter: function (node, query, result, resultCount, resultCountPerGroup) {

        $('#selected-single-latitude').attr('value', result.latitude);
        $('#selected-single-longitude').attr('value', result.longitude);
        $('#weather_point_id').attr('value', result.weather_point_id);
        $('#selected_data').show();
        $('#selected_point_name').html(result.weather_point_name);
        $('#selected_lat').html(result.latitude);
        $('#selected_long').html(result.longitude);
        $('#closecancel').attr('value', 'Cancel').removeClass("btn-default").addClass("btn-danger").on('click', function () {

        });
        $('#donesave').attr('value', 'Done').removeClass("btn-primary").addClass("btn-success").on('click', function () {
          $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            // Display the selected locations in the form
            $('#selected-location-wrapper').removeClass('hide');
            $('#selected-location-wrapper .single').removeClass('hide');
            if (!$('.selected-weather-station').hasClass('hide')) $('.selected-weather-station').removeClass('hide');
            $('#selected-location-wrapper .selected-latitude').text($("#selected-single-latitude").val());
            $('#selected-location-wrapper .selected-longitude').text($("#selected-single-longitude").val());
            $('#selected-location-wrapper .weather_point').text($("#weather_point_id").val());

            if (!$('#selected-location-wrapper .multiple').hasClass('hide')) {
              $('#selected-location-wrapper .multiple').addClass('hide')
            }

          });
        });
      }
    },
    debug: true
  })
})();
(function () {
  $.typeahead({
    input: '.school-search',
    minLength: 0,
    maxItem: 15,
    order: "asc",
    hint: true,
    accent: true,
    searchOnFocus: true,
    backdrop: {
      "background-color": "#3879d9",
      "opacity": "0.1",
      "filter": "alpha(opacity=10)"
    },
    display: ["weather_point_name"],
    source: {
      users: {
        ajax: {
          url: '/data/schools',
          data: 'response'
        }
      }
    },
    emptyTemplate: "No result found",
    callback: {
      onEnter: function (node, query, result, resultCount, resultCountPerGroup) {

        $('#selected-single-latitude').attr('value', result.latitude);
        $('#selected-single-longitude').attr('value', result.longitude);
        $('#weather_point_id').attr('value', result.weather_point_id);
        $('#school_selected_data').show();
        $('#school_selected_point_name').html(result.weather_point_name);
        $('#school_selected_lat').html(result.latitude);
        $('#school_selected_long').html(result.longitude);
        $('#closecancel2').attr('value', 'Cancel').removeClass("btn-default").addClass("btn-danger").on('click', function () {

        });
        $('#donesave2').attr('value', 'Done').removeClass("btn-primary").addClass("btn-success").on('click', function () {
          $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            // Display the selected locations in the form
            $('#selected-location-wrapper').removeClass('hide');
            $('#selected-location-wrapper .single').removeClass('hide');
            if (!$('.selected-weather-station').hasClass('hide')) $('.selected-weather-station').removeClass('hide');
            $('#selected-location-wrapper .selected-latitude').text($("#selected-single-latitude").val());
            $('#selected-location-wrapper .selected-longitude').text($("#selected-single-longitude").val());
            $('#selected-location-wrapper .weather_point').text($("#weather_point_id").val());

            if (!$('#selected-location-wrapper .multiple').hasClass('hide')) {
              $('#selected-location-wrapper .multiple').addClass('hide')
            }

          });
        });
      }
    },
    debug: true,
  })
})()