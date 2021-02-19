<?php
include 'session.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../cssLinks.php';?>
    <title>Grafikët</title>
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- Page Header Start-->
    <?php //include '../header.php'?>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon" value=" horizontal-menu">
        <!-- Page Sidebar Start-->
        <?php include '../topMenu.php'?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card-header">
                            <h5 class="text-center">Grafiket ditor/mujor </h5>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 box-col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Grafiku sipas ditëve </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="row">

                                                <div class="col-md-4 col-sm-4">
                                                    <label for="">Data nga</label>
                                                    <input type="text" name="from_date" class="dateInput form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <label for="">Deri në</label>
                                                    <input type="text" name="to_date" class="dateInput form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <br>
                                                    <button type="submit" name="btn_date_chart" id="btn_search"
                                                        class="btn btn-info mt-2">KËRKO</button>
                                                </div>

                                            </div>
                                        </form>
                                        <div id="basic-apex"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-xl-6 box-col-6">
                                <form action="" method="POST">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Grafiku mujor</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">


                                                <div class="col-md-4 col-sm-4">
                                                    <label for="">Zgjidh vitin</label>
                                                    <select class="form-control" name="year_selected">
                                                        <option class="disable"> Zgjidh</option>
                                                        <?php
$last_year = 2050;
for ($i = 2010; $i < $last_year; $i++) {
    echo "<option>$i</option>";
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <br>
                                                    <button type="submit" name="btn_year_search" id="btn_search"
                                                        class="btn btn-info mt-2">KËRKO</button>
                                                </div>

                                            </div>
                                            <div id="basic-bar"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
        </div>
        <?php include '../footer.php'?>
    </div>
    <!-- latest jquery-->
    <?php include '../jsLinks.php'?>
    <!-- <script src="../../assets/js/chart/apex-chart/chart-custom.js"></script> -->
    <script src="../../assets/pages/datepickerInit.js"></script>

    </div>
    <?php global $connection;
if (isset($_POST['btn_date_chart'])) {
    $from_date = $_POST['from_date'];
    $from_date_formated = date('Y-m-d', strtotime($from_date));

    $to_date = $_POST['to_date'];
    $to_date_formated = date('Y-m-d', strtotime($to_date));

    //get all dates between first selected day and last selected day

    $allDates = datePeriod_start_end($from_date_formated, $to_date_formated);
} else {
    //first date of month
    $firstDate = date('Y-m-01');
    $firstDate = date("Y-m-d", strtotime($firstDate));

    //last date of month
    $lastDate = date('Y-m-t');
    $lastDate = date("Y-m-d", strtotime($lastDate));

    //get all dates between first and last day
    $allDates = datePeriod_start_end($firstDate, $lastDate);
}

//count invoice's total amount for each day
    foreach ($allDates as $date) {
        $select_count_amount = "SELECT COALESCE(SUM(totalAmount), 0) AS TOTALall FROM orders WHERE DATE(orderDate)='$date'";

        $result_count = mysqli_query($connection, $select_count_amount);

        while ($row_count = mysqli_fetch_array($result_count)) {
            $orders_amount[] = round($row_count['TOTALall'], 2);
        }
    }


if (isset($_POST['btn_year_search'])) {
    $year = $_POST['year_selected'];
} else {
    $year = date('Y');
}
   $allMonths = monthPeriod_start_end($year, $year);
 $all_amount = array();

    foreach ($allMonths as $month) {
        $select_amout_total = "SELECT COALESCE(SUM(totalAmount),0) AS totalAmount FROM orders WHERE MONTH(orderDate)='$month' AND YEAR(orderDate)='$year'";
        $result_total_amount = mysqli_query($connection, $select_amout_total);
        while ($row_total_amunt = mysqli_fetch_array($result_total_amount)) {
            $all_amount[] = $row_total_amunt['totalAmount'];
        }
    }
    foreach ($allMonths as $key => $monthval) {
        $month_value[] = date("F", mktime(0, 0, 0, $monthval, 10));
    }

?>


</body>
<script type="text/javascript">
var series = {
    "monthDataSeries1": {
        "prices": <?php echo json_encode($orders_amount); ?>,
        "dates": <?php echo json_encode($allDates); ?>
    }
};

var seriesMonths = {
    "monthDataSeries": {
        "prices": <?php echo json_encode($all_amount); ?>,
        "months": <?php echo json_encode($month_value); ?>
    }
};
const {
    months,
    prices
} = seriesMonths.monthDataSeries;
</script>
<script>
$(document).ready(function() {
    // basic area chart
    var options = {
        chart: {
            height: 350,

            type: 'area',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: "Shitjet për këtë datë",
            data: series.monthDataSeries1.prices
        }],

        subtitle: {
            text: 'Kurba e aktivitetit te biznesit',
            align: 'left'
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
            type: 'datetime',

        },
        yaxis: {
            opposite: true

        },
        legend: {
            horizontalAlign: 'left'
        },


    }

    var chart = new ApexCharts(
        document.querySelector("#basic-apex"),
        options
    );

    chart.render();


    var options2 = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                vertical: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            data: prices
        }],
        xaxis: {
            categories: months,
        },

    }

    var chart2 = new ApexCharts(
        document.querySelector("#basic-bar"),
        options2
    );

    chart2.render();
});
</script>

</html>