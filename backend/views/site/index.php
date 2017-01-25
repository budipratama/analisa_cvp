<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">

   <!--  <div class="jumbotron">
        <h1>Dashboard Under Construction</h1>
    </div> -->


    <div class="body-content"> 
    <div class="container">
    	<h4 align="center">Jam Operasional 09:00</h4>
    	<div class="row">
    		<div class="col-md-12">
		    	<table class="table table-striped">
				    <thead>
				      <tr>
				        <th width="10%">No</th>
				        <th width="10%">IAT</th>
				        <th width="10%">ST</th>
				        <th width="10%">TOA</th>
				        <th width="20%">SS</th>
				        <th width="20%">ES</th>
				        <th width="10%">TIE</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php
				    	$serv_time 			= 4;
						$time_of_arrival 	= 0;
						$start_service      = 0;
						$end_service 		= 0;
						$int_arrv_time;
						$time_in_queue 		= 0;
						$i 					= 1;
						$totalTIE 			= 0;
						$jam_buka 			= date('Y-m-d 09:00');
				    	foreach ($data as $key => $value) {
				    		$start_service+=$value;
							$time_of_arrival+=$value; 
							$time_in_queue = $end_service - $time_of_arrival;
							#echo $jam_buka."<br>";
							# jika angka minus maka nilai TIE di jadikan 0
							if ($time_in_queue < 0 )
								$time_in_queue = 0;
							
							# menentukan start service dan end service 
							# cek ES sebelumnya jika lebih besar dari st maka tunggu
							if ($end_service > $time_of_arrival) 
							{
								$start_service = $end_service;
								$end_service = $end_service + $serv_time;
							}
							else{
								$start_service = $time_of_arrival;
								$end_service = $time_of_arrival + $serv_time;
							}
							$jam_melayani = date('Y-m-d H:i',strtotime("+$start_service minutes",strtotime($jam_buka))); 
							$jam_selesai = date('Y-m-d H:i',strtotime("+$end_service minutes",strtotime($jam_buka))); 
				    		#echo "<tr><td>$i</td><td>$value</td><td>$serv_time</td><td>$time_of_arrival</td><td>$start_service</td><td>$end_service</td><td>$time_in_queue</td></tr>";
				    		echo "<tr><td>$i</td><td>$value</td><td>$serv_time</td><td>$time_of_arrival</td><td>$jam_melayani</td><td>$jam_selesai</td><td>$time_in_queue</td></tr>";
				    		#echo $i."\t"."|$value\t|{$this->serv_time}\t|{$this->time_of_arrival}\t|{$this->start_service}\t|{$this->end_service}\t|{$this->time_in_queue}"."\n";
				    		$totalTIE+= $time_in_queue;
				    		#$jam_buka = $jam_selesai;
				    		$i++;
				    	}
				    	$total = ($serv_time*($i-1));
				    	$rata_rata = ($totalTIE/($i-1));
				    	echo "<tr><td>Total</td><td></td><td>$total</td><td></td><td></td><td></td><td>$totalTIE</td></tr>";
				    	echo "<tr><td>Rata - rata</td><td></td><td></td><td></td><td></td><td></td><td>$rata_rata</td></tr>";
				    	#echo "<tr><td>Rata - rata antrian</td><td>$totalTIE</td></tr>";
				    ?>
				    
				    </tbody>
				  </table>
    		
    		</div>
    	
    	</div>
		
    </div>
		
     	
    </div>
</div>
