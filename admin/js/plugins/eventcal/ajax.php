<?php

// This is just an example of reading server side data and sending it to the client.
// It reads a json formatted text file and outputs it.

$arrRes = array(
    'cols' => array(
        '0' => array('label' => 'Month','type' => 'string'),
        '1' => array('label' => 'KPI', 'type' => 'number')
    ),
    'rows' => array(
        '0' => array('c' => array('0' => array('v' => 'Jan'), '1' => array('v' => '3'))),
        '1' => array('c' => array('0' => array('v' => 'Feb'), '1' => array('v' => '15'))),
        '2' => array('c' => array('0' => array('v' => 'Mar'), '1' => array('v' => '6'))),
        '3' => array('c' => array('0' => array('v' => 'Apr'), '1' => array('v' => '17'))),
        '4' => array('c' => array('0' => array('v' => 'May'), '1' => array('v' => '28'))),
        '5' => array('c' => array('0' => array('v' => 'Jun'), '1' => array('v' => '10'))),
        '6' => array('c' => array('0' => array('v' => 'July'), '1' => array('v' => '25'))),
        '7' => array('c' => array('0' => array('v' => 'Aug'), '1' => array('v' => '30'))),
        '8' => array('c' => array('0' => array('v' => 'Sep'), '1' => array('v' => '35'))),
        '9' => array('c' => array('0' => array('v' => 'Oct'), '1' => array('v' => '32'))),
        '10' => array('c' => array('0' => array('v' => 'Nov'), '1' => array('v' => '22'))),
        '11' => array('c' => array('0' => array('v' => 'Dec'), '1' => array('v' => '28')))
    )
);



$string = json_encode($arrRes);


//$string = file_get_contents("sampleData.json");
//echo '<pre>';
//print_r(json_decode($string));


echo $string;

// Instead you can query your database and parse into JSON etc etc
?>