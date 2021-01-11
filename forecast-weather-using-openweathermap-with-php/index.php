<?php
$cache_file = 'data.json';
if(file_exists($cache_file)){
    unlink($cache_file);
}
$api_url = 'https://content.api.nytimes.com/svc/weather/v2/current-and-seven-day-forecast.json';
$data = file_get_contents($api_url);
file_put_contents($cache_file, $data);
$data = json_decode($data);

$current = $data->results->current[0];
$forecast = $data->results->seven_day_forecast;

$string = $current->updated;
$date = substr($string,0,-9);
$time = substr($string,11,19);

$dayOfWeek = date("l", strtotime($date));

?>

<?php

  function convert2cen($value,$unit){
    if($unit=='C'){
      return $value;
    }else if($unit=='F'){
      $cen = ($value - 32) / 1.8;
      	return round($cen,2);
      }
  }
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />

<body style="height: 247px; background-color:transparent; ">
<div class="container">
    <div class="row">
        <div class="card shadow col-md-6 mx-auto mt-5" style="border-radius: 25px;">
            <div class="m-5">
                <h2 class="text-left"> <?php echo $current->city.', '.$current->country.'';?> Weather</h3>
                <p class="mb-0 text-muted">as of <span><?php echo $time?> WAT on</span> <span><?php echo $dayOfWeek ?></span> 22nd,</p>
                <span style="font-size: 70px; font-weight: 500" class="text-left mb-0"><?php echo convert2cen($current->temp,$current->temp_unit);?>°</span>
                <img style="height: 55px; " class="text-right" src="<?php echo $current->image;?>">
                <p style="font-size: 15px font-weight: 200"><?php echo $current->description;?></p>
            </div>
        </div>
    </div>
</div>
            
           
</div>

</body>


<?php 






?>