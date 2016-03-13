<?php

$person = 'Henrique';

if(isset($_GET['person'])) {
    $person = $_GET['person'];
}

function getDb() {
    return new SQLite3('weight.db');
}

function getData($yearMonth, $person) {
    $db = getDb();
    $sql =<<<EOS
    select strftime("%Y%m%d", date) as date,
        avg(weight) as weight
    from
        measurements
    where
        person = :person
        and strftime("%Y%m", date) = :date
    group by
        strftime("%Y%m%d",date)
    order by
        date
EOS;

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':person', $person);
    $stmt->bindValue(':date', $yearMonth);

    $results = $stmt->execute();

    $dataPoints = array();
    while($row = $results->fetchArray()) {
        $d = array();
        $d['label'] = substr($row['date'], 6,2);
        $d['y'] = $row['weight'];

        array_push($dataPoints, $d);
        
    }

    $db->close();
    return json_encode($dataPoints);
}

getData('201509', $person);
$results = getDb()->query('select distinct(strftime("%Y%m")) from measurements order by 1 desc');

$periods = array();
while($row = $results->fetchArray()) {
    array_push($periods, $row[0]);
}

?>
<!DOCTYPE HTML>
<html>

<head>  
    <script type="text/javascript">
    window.onload = function () {

<?php
    foreach($periods as $p) {
?>
        var chart = new CanvasJS.Chart("chart<?=$p?>",
        {
            title:{
            text: "Daily weight measurement for <?= htmlentities($person) ?> : <?= $p ?>"
            },   
            animationEnabled: true,  
            axisY:{ 
                title: "Weight (Kg)",
                includeZero: false                    
            },
            axisX: {
                title: "Day",
                interval: 1
            },
            data: [
            {        
                type: "spline",
                dataPoints: <?= getData($p, $person) ?>
            }]
        });

        chart.render();

<?php
    }
?>

}
</script>
<script type="text/javascript" src="/weight/js/canvasjs.min.js"></script>
</head>
<body>
    <?php
        foreach($periods as $p) {
            $height = '300px';
            if($p == date('Ym')) {
                $height = '500px';
            }
            echo '<div id="chart'.$p.'" style="height: '.$height.'; width: 100%;">';
        }
    ?>
    </div>
</body>

</html>

