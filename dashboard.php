<?php include "config.php"; ?>
<?php include "fetch.php"; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="dashboard.css">

    <!-- Leaflet Map Api -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        #maps {
            /* position: static;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0; */

            /* border: 1px solid red; */
            /* margin: 10px;
            width: 70%; */
            height: 90%;
            width: 100%;
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>

    <!-- Line chart script -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Time', 'Soil Moisture'],

                // PHP CODE
                <?php
                $query = "select * FROM data ORDER BY rollno DESC LIMIT 5";
                $res = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($res)) {
                    $time = $data['time'];
                    $soil_moisture = $data['soil_moisture'];
                ?>['<?php echo $time; ?>', <?php echo $soil_moisture; ?>],
                <?php
                }
                ?>

            ]);

            var options = {
                title: 'Farm Soil Moiture Monitory',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
                width: 500,
                height: 300,
            };

            var chart = new google.visualization.LineChart(document.getElementById('one-panel'));

            chart.draw(data, options);
        }

    </script>

    <!-- Guage Script -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['gauge']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],

                <?php
                $query = "select * FROM data ORDER BY rollno DESC LIMIT 1";
                $res = mysqli_query($conn, $query);
                $data = mysqli_fetch_array($res);
                $soil_moisture = $data['soil_moisture'];

                ?>['Soil Moisture', <?php echo $soil_moisture; ?>]

                // ['Memory', 80],
            ]);

            var options = {
                width: 600,
                height: 300,
                redFrom: 700,
                redTo: 1024,
                yellowFrom: 300,
                yellowTo: 699,
                greenFrom: 0,
                greenTo: 299,
                minorTicks: 5,
                max: 1024
            };

            var chart = new google.visualization.Gauge(document.getElementById('two-panel'));

            chart.draw(data, options);

            // setInterval(drawChart(data, options), 13000);

            // setInterval(function() {
            //     data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
            //     chart.draw(data, options);
            // }, 13000);
            // setInterval(function() {
            //     data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
            //     chart.draw(data, options);
            // }, 5000);
            // setInterval(function() {
            //     data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
            //     chart.draw(data, options);
            // }, 26000);
        }
    </script>

    <!-- Google Map Script -->
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['geochart'],
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Popularity'],
                ['Germany', 200],
                ['United States', 300],
                ['Brazil', 400],
                ['Canada', 500],
                ['France', 600],
                ['RU', 700]
            ]);

            var options = {
                height: 350,
                // width: 500
            };

            var chart = new google.visualization.GeoChart(document.getElementById('map'));

            chart.draw(data, options);
        }
    </script> -->

</head>

<body onload="irragationTrigger()">
    <!-- Sidebar Section Begin -->
    <div class="sidebar">
        <div class="logo-details">
            <!-- <i class='bx bxl-c-plus-plus'></i> -->

            <span class="logo_name">Smart Agriculture</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="https://watchitgroup.org/" target="_blank">
                    <i class='bx bx-box'></i>
                    <span class="links_name">Trainer</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Project Details</span>
                </a>
            </li>
            <li>
                <a href="Report.pdf" target="_blank">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">Documentation</span>
                </a>
            </li>
            <!-- <li>
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Reset Password</span>
                </a>
            </li> -->
            <!-- <li class="log_out">
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li> -->
        </ul>
    </div>
    <!-- Sidebar Section End -->

    <!-- Home Section Begin -->
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard</span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Temperature</div>
                        <div class="number"><?php echo $temp; ?></div>
                    </div>
                    <img src="https://img.icons8.com/nolan/64/temperature.png" />
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Humidity</div>
                        <div class="number"><?php echo $hum; ?></div>
                    </div>
                    <img src="https://img.icons8.com/external-justicon-flat-justicon/64/000000/external-humidity-weather-justicon-flat-justicon.png" />
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Soil Moisture</div>
                        <div class="number"><?php echo $soil_moisture; ?></div>
                    </div>
                    <img src="https://img.icons8.com/color/64/000000/moisture.png" />
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Irrigation Status</div>
                        <div id="trigger" class="number"><?php echo $_trigger_status ?></div>
                    </div>
                    <img src="https://img.icons8.com/fluency/48/000000/plant-under-rain.png" />
                </div>
            </div>

            <div class="guage-row">
                <!-- Guarge / Line Chart Session (column 1) -->
                <div class="charts-container">

                    <input class="radio" id="one" name="group" type="radio" checked>
                    <input class="radio" id="two" name="group" type="radio">

                    <div class="tabs">
                        <label class="tab" id="one-tab" for="one">Line Chart</label>
                        <label class="tab" id="two-tab" for="two">Gauge</label>
                    </div>

                    <!-- Tab Contents -->
                    <div class="panels">
                        <div class="panel" id="one-panel">

                        </div>
                        <div class="panel" id="two-panel">

                        </div>
                    </div>

                </div>

                <!-- Map Session (column2)-->
                <div class="map-container">
                    <div class="header">
                        <span class="title">Irrigation Control</span>
                        <input type="checkbox" name="switch" id="switch" onclick="irragationTrigger()">
                        <label for="switch"></label>
                    </div>

                    <div id="maps">
                    </div>

                </div>

            </div>
        </div>

        <!-- Footer -->
        <!-- <div class="footer">
            <p>THIS IS MY FOOTER DIV</p>
        </div> -->
    </section>

    <script>
        // openChart Function 
        function openChart(evt, cityName) {
            var i, panels, tablinks;
            panels = document.getElementsByClassName("panels");
            //make all elements with class name "panels" display none.
            for (i = 0; i < panels.legth; i++) {
                panels[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace("active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += "active";
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

    <!-- Leaflet Script for Map -->
    <script>
        var map = L.map('maps').setView([-1.9825298037598733, 30.10838771068302], 13);
        const location1 = L.icon({
            iconUrl: 'img2.png',
            iconSize: [20, 30],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        L.tileLayer('https://api.maptiler.com/maps/streets/256/{z}/{x}/{y}.png?key=liZ4ivyptWj496pHoS4p', {
            // attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);
        var marker = L.marker([-1.9825298037598733, 30.10838771068302], {
            icon: location1
        }).addTo(map);

        var marker1 = L.marker([-1.9651870679143397, 30.098481588762752], {
            icon: location1
        }).addTo(map);

        //Adding popups to marker
        marker.bindPopup("<b>Farm1</b>").openPopup();
        marker1.bindPopup("<b>Farm2</b>");
    </script>
</body>

</html>