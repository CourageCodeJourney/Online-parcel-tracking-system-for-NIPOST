<!DOCTYPE html>
<html>
<head>
  <title>NIPOST ONLINE PARCEL TRACKING</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #FFFFFF;
    margin: 0;
    padding: 0;
    color: #000000;
    background-image: url('ship.jpg');
    background-repeat: no-repeat;
    background-position-y: 200px; /* Add this line to set the desired distance from the top */
    background-size: 50%; 
     }

    .header {
      background-color: #007BFF;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .header-logo {
      display: flex;
      align-items: center;
    }

    .header-logo img {
      height: 80px;
      margin-right: 10px;
    }

    .header-title {
      font-size: 24px;
      margin: 0;
      color: #FFFFFF;
    }

    .header-links {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .header-links li {
      margin-left: 20px;
    }

    .header-links a {
      text-decoration: none;
      color: #FFFFFF;
      font-size: 16px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .input-group label {
      margin-right: 10px;
    }

    .input-field {
      flex: 1;
      height: 40px;
      padding: 5px;
      font-size: 16px;
    }

    .track-btn {
      background-color: #007BFF;
      color: white;
      border: none;
      padding: 5px 10px;
      font-size: 16px;
      cursor: pointer;
    }

    .track-btn:hover {
      background-color: #0056b3;
    }

    .timeline-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: #FFFFFF;
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .timeline-item {
      margin-bottom: 10px;
    }

    .timeline-item .time {
      font-weight: bold;
    }

    .timeline-item .timeline-body {
      margin-top: 5px;
    }

    .loader {
      border: 6px solid #f3f3f3; /* Light grey */
      border-top: 6px solid #007BFF; /* Blue */
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 2s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .footer {
      border: 1px solid #DEE2E6;
      background-color: white;
      color: gray;
      padding: 18px;
      text-align: center;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 98%;
      display: flex;
      justify-content: space-between; /* Aligns items to the left and right */
      align-items: center;
    }

    .footer-left {
      text-align: left;
    }

    .footer-right {
      text-align: right;
    }
  </style>
</head>
<body>
<div class="header">
    <div class="header-logo">
      <img src="nipost logo.png" alt="Nipost Logo">
      <h1 class="header-title">NIPOST ONLINE PARCEL TRACKING SYSTEM</h1>
    </div>
    <ul class="header-links">
      <li><a href="login.php">LOGIN AS ADMIN</a></li>
      <li><a href="ABOUT US.html">ABOUT US</a></li>
      <li><a href="CONTACT US.html">CONTACT US</a></li>
    </ul>
  </div>
  <div class="container">
    <div class="input-group">
      <label for="ref_no">Enter Tracking Number</label>
      <div>
        <input type="search" id="ref_no" class="input-field" placeholder="Type the tracking number here">
        <button type="button" id="track-btn" class="track-btn">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>

    <div class="timeline-container">
      <div id="parcel_history">
        <!-- Timeline items will be dynamically added here -->
      </div>

      <div id="loading-indicator" style="display: none;">
        <div class="loader"></div>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="footer-left">
     <strong>&copy; 2023 PAUL LABHANI COURAGE</strong>      
    </div>
    <div class="footer-right">
      <strong>NIPOST ONLINE PARCEL TRACKING SYSTEM</strong> 
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    function start_load() {
      $('#loading-indicator').show();
      $('#parcel_history').html('');
    }

    function end_load() {
      $('#loading-indicator').hide();
    }

    function track_now() {
      start_load();
      var tracking_num = $('#ref_no').val();
      if (tracking_num == '') {
        end_load();
        return;
      }

      $.ajax({
        url: 'ajax.php?action=get_parcel_heistory',
        method: 'POST',
        data: { ref_no: tracking_num },
        error: function(err) {
          console.log(err);
          alert("An error occurred");
          end_load();
        },
        success: function(resp) {
          if (typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object') {
            resp = JSON.parse(resp);
            if (Object.keys(resp).length > 0) {
              Object.keys(resp).forEach(function(k) {
                var timelineItem = $('<div class="timeline-item">');
                var time = $('<span class="time">').html('<i class="fas fa-clock"></i> <span class="dtime">' + resp[k].date_created + '</span>');
                var timelineBody = $('<div class="timeline-body">').text(resp[k].status);
                timelineItem.append(time, timelineBody);
                $('#parcel_history').append(timelineItem);
              });
            }
          } else if (resp == 2) {
            alert('Unknown Tracking Number.');
          }
        },
        complete: function() {
          end_load();
        }
      });
    }

    $(document).ready(function() {
      $('#track-btn').click(function() {
        track_now();
      });

      $('#ref_no').on('search', function() {
        track_now();
      });
    });
  </script>
</body>
</html>
