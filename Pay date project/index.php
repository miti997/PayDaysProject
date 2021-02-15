<?php
class PayDays{


  public function __construct(){//constructor for array
    $this->paydates=array();
  }


  public function dateCalculation ($date, $minusdays) {//function to calculate last working day of month
    $datej=new DateTime($date);
    $datej->modify($minusdays);
    $datej=$datej->format('Y-M-d');
    $dayj=date("l",strtotime($datej));
    $monthj=date("F",strtotime($datej));
    $this->paydates[]="Pay date ".$monthj.": ".$datej." ".$dayj."\n";
    //echo "Pay date ".$monthj.": ".$datej." ".$dayj."<br>";
  }


  public function arrayPopulation ($i,$j){//function to find the last day of month
  while ($i < $j) {
    $date = new DateTime('now');
    $i++;
    $date->modify('+'.$i.'month');
    $datei = $date->format('Y-M-t');
    $day=date("l",strtotime($datei));
    $month=date("F",strtotime($datei));

      if( date("l",strtotime($datei))=="Sunday") {//if the last day of the month is Sunday we subtract 2 days from last day
          $this->dateCalculation($datei, "-2 day");
      }
      elseif (date("l",strtotime($datei))=="Saturday"){//if the last day of the month is Sunday we subtract 1 day from last day
        $this->dateCalculation($datei, "-1 day");
      }
      else{//if the last day is a working day we don't change anything
        $this->paydates[]="Pay date ".$month.": ".$datei." ".$day."\n";
        //echo "Pay date ".$month.": ".$datei." ".$day."<br>";
      }
    }
  }


  public function csvCreator(){//function to create csv file
    $out = fopen('paydays.csv', 'w');
    if (count($this->paydates) == 0) {
      echo "Cvs file not created";
    }
    else {
      fputcsv($out, $this->paydates);
      fclose($out);
      echo "Succesfully created the csv file<br><br>";
    }

  }


  public function csvOpener(){//function to display csv file
    $row = 1;
    if (($handle = fopen("paydays.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br/>\n";
        }
    }
    fclose($handle);
}
  }
}


//callin class and functions
$result=new PayDays();
echo $result->arrayPopulation(0,12);
echo $result->csvCreator();
echo $result->csvOpener();
?>
