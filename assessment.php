<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//check the form type
//If Form A
if($_GET['form_type'] == 'a'){
//objectives and competencies percentage for form A (PMS formula)
$objectives_distripution_percentage = '60';
$competencies_distripution_percentage = '40';
//check and validate input parameters values (competencies rates)
for($i = 1; $i <= 11; $i++) {
//check if it is a number or not, if not return an error message 
if(!is_numeric($_GET["competency_rate_$i"])) {
$response = array(
"RESPONSE_CODE" => "110",
"RESPONSE_MESSAGE" => "parameter ".$_GET["competency_rate_$i"]." not a number"
);
die(json_encode($response));
}
//the competency rate value should be between 1.00 and 5.00, if not return an error message
if($_GET["competency_rate_$i"] < '1' OR $_GET["competency_rate_$i"] > '5')
{
$response = array(
"RESPONSE_CODE" => "120",
"RESPONSE_MESSAGE" => "parameter ".$_GET["competency_rate_$i"]." is less than 1.00 or greater than 5.00"
);
die(json_encode($response));
}
}
//check and validate input parameters values (objectives rates)
for($i = 1; $i <= 10; $i++) {
//check if it is a number or not, if not return an error message 
if(!is_numeric($_GET["objective_rate_$i"])) {
$response = array(
"RESPONSE_CODE" => "130",
"RESPONSE_MESSAGE" => "parameter ".$_GET["objective_rate_$i"]." not a number"
);
die(json_encode($response));
}
//the objective rate value should be between 0 and 5.00, if not return an error message
if($_GET["objective_rate_$i"] < '0' OR $_GET["objective_rate_$i"] > '5')
{
$response = array(
"RESPONSE_CODE" => "140",
"RESPONSE_MESSAGE" => "parameter ".$_GET["objective_rate_$i"]." is less than 0 or greater than 5.00"
);
die(json_encode($response));
}
}
//get the competencies rates from the URL and store them in an array
for($i = 1; $i <= 11; $i++) {
$competencies_rates_array[] = $_GET["competency_rate_$i"];
}
//calculate the summation of the competency rates 
$competencies_rates_sum = array_sum($competencies_rates_array);
//calculate the average of the competency rates 
$competencies_rates_avg = $competencies_rates_sum/11;
//calculate the overall of the competencies rates (PMS formula)
$overall_competencies_rates = $competencies_rates_avg * ($competencies_distripution_percentage/100);
//get the objectives rates from the URL and store them in an array
for($i = 1; $i <= 10; $i++) {
$objectives_rates_array[] = $_GET["objective_rate_$i"];
}
//get the weights of the objectives from the URL and store them in an array
for($i = 1; $i <= 10; $i++) {
$objectives_weights_array[] = $_GET["objective_weight_$i"];
}
//the summation of the objective’s weights should be 1.00 (PMS constraint) 
$objectives_weights_sum = array_sum($objectives_weights_array);
//if the summation of the objective’s weights is 1.00 don’t do anything
if (round($objectives_weights_sum, 2) == '1.00') {/* it is OK, do nothing! */}
else
{
//if the summation of the objective’s weights is not 1.00 return an error message
$response = array(
"RESPONSE_CODE" => "150",
"RESPONSE_MESSAGE" => "objectives_weights_sum <> 1.00"
);
die(json_encode($response));
}
//multiply objectives rates by objectives weights to get the objectives scores
for($i = 0; $i <= 9; $i++) {
$objectives_scores_array[] = $objectives_rates_array["$i"] * $objectives_weights_array["$i"];
}
//calculate the summation of the objectives scores
$objectives_scores_sum = array_sum($objectives_scores_array);
//calculate the overall objectives rate (PMS formula)
$overall_objectives_rate = $objectives_scores_sum * ($objectives_distripution_percentage/100);
//calculate the overall assessment rate (PMS formula)
$overall_rounded_rate = round($overall_competencies_rates + $overall_objectives_rate, 0);
//translate the overall assessment rate to a descriptor
if($overall_rounded_rate == '5') { $overall_rate_descriptor = 'Significantly Exceed Expectation'; }
elseif($overall_rounded_rate == '4') { $overall_rate_descriptor = 'Exceed Expectation'; }
elseif($overall_rounded_rate == '3') { $overall_rate_descriptor = 'Meets Expectation'; }
elseif($overall_rounded_rate == '2') { $overall_rate_descriptor = 'Below Expectation'; }
elseif($overall_rounded_rate == '1') { $overall_rate_descriptor = 'Significantly Below Expectation'; }
else { $overall_rate_descriptor = "NOT DEFINED"; }
//prepare the response and store it in an array
$response_code = "100";
$response_message = "successful";
$response = array(
"RESPONSE_CODE" => "".$response_code."",
"RESPONSE_MESSAGE" => "".$response_message."",
"OVERALL_RATE" => "".$overall_rounded_rate."",
"OVERALL_RATE_DESCRIPTOR" => "".$overall_rate_descriptor.""
);
echo json_encode($response);
}
//If Form B
elseif($_GET['form_type'] == 'b'){
//objectives and competencies percentage for form B (PMS formula)
$objectives_distripution_percentage = '70';
$competencies_distripution_percentage = '30';
//check and validate input parameters values (competencies rates)
for($i = 1; $i <= 7; $i++) {
//check if it is a number or not, if not return an error message 
if(!is_numeric($_GET["competency_rate_$i"])) {
$response = array(
"RESPONSE_CODE" => "110",
"RESPONSE_MESSAGE" => "parameter ".$_GET["competency_rate_$i"]." not a number"
);
die(json_encode($response));
}
//the competency rate value should be between 1.00 and 5.00, if not return an error message
if($_GET["competency_rate_$i"] < '1' OR $_GET["competency_rate_$i"] > '5')
{
$response = array(
"RESPONSE_CODE" => "120",
"RESPONSE_MESSAGE" => "parameter ".$_GET["competency_rate_$i"]." is less than 1.00 or greater than 5.00"
);

die(json_encode($response));
}
}
//check and validate input parameters values (objectives rates)
for($i = 1; $i <= 10; $i++) {
//check if it is a number or not, if not return an error message 
if(!is_numeric($_GET["objective_rate_$i"])) {
$response = array(
"RESPONSE_CODE" => "130",
"RESPONSE_MESSAGE" => "parameter ".$_GET["objective_rate_$i"]." not a number"
);

die(json_encode($response));
}
//the objective rate value should be between 0 and 5.00, if not return an error message
if($_GET["objective_rate_$i"] < '0' OR $_GET["objective_rate_$i"] > '5')
{
$response = array(
"RESPONSE_CODE" => "140",
"RESPONSE_MESSAGE" => "parameter ".$_GET["objective_rate_$i"]." is less than 0 or greater than 5.00"
);

die(json_encode($response));
}
}
//get the competencies rates from the URL and store them in an array
for($i = 1; $i <= 7; $i++) {
$competencies_rates_array[] = $_GET["competency_rate_$i"];
}
//calculate the summation of the competency rates
$competencies_rates_sum = array_sum($competencies_rates_array);
//calculate the average of the competency rates
$competencies_rates_avg = $competencies_rates_sum/7;
//calculate the overall of the competencies rates (PMS formula)
$overall_competencies_rates = $competencies_rates_avg * ($competencies_distripution_percentage/100);
//get the objectives rates from the URL and store them in an array
for($i = 1; $i <= 10; $i++) {
$objectives_rates_array[] = $_GET["objective_rate_$i"];
}
//get the weights of the objectives from the URL and store them in an array
for($i = 1; $i <= 10; $i++) {
$objectives_weights_array[] = $_GET["objective_weight_$i"];
}
//check the objectives weights summation (should be 1.00)
$objectives_weights_sum = array_sum($objectives_weights_array);
//if the bjectives weights summation equal 1.00 then do nothing
if (round($objectives_weights_sum, 2) == '1.00') {/* it is OK, do nothing! */}
else
{
//the summation of the objective’s weights should equal 1.00 (PMS constraint), if not return an error message
$response = array(
"RESPONSE_CODE" => "150",
"RESPONSE_MESSAGE" => "objectives_weights_sum <> 1.00"
);

die(json_encode($response));
}
//multiply objectives rates by objectives weights to get the objectives scores
for($i = 0; $i <= 9; $i++) {
$objectives_scores_array[] = $objectives_rates_array["$i"] * $objectives_weights_array["$i"];
}
//calculate the summation of the objectives scores
$objectives_scores_sum = array_sum($objectives_scores_array);
//calculate the overall objectives rate (PMS formula)
$overall_objectives_rate = $objectives_scores_sum * ($objectives_distripution_percentage/100);
//calculate the overall assessment rate (PMS formula)
$overall_rounded_rate = round($overall_competencies_rates + $overall_objectives_rate, 0);
//translate the overall assessment rate to a descriptor
if($overall_rounded_rate == '5') { $overall_rate_descriptor = 'Significantly Exceed Expectation'; }
elseif($overall_rounded_rate == '4') { $overall_rate_descriptor = 'Exceed Expectation'; }
elseif($overall_rounded_rate == '3') { $overall_rate_descriptor = 'Meets Expectation'; }
elseif($overall_rounded_rate == '2') { $overall_rate_descriptor = 'Below Expectation'; }
elseif($overall_rounded_rate == '1') { $overall_rate_descriptor = 'Significantly Below Expectation'; }
else { $overall_rate_descriptor = "NOT DEFINED"; }
//prepare the response and store it in an array
$response_code = "100";
$response_message = "successful";
$response = array(
"RESPONSE_CODE" => "".$response_code."",
"RESPONSE_MESSAGE" => "".$response_message."",
"OVERALL_RATE" => "".$overall_rounded_rate."",
"OVERALL_RATE_DESCRIPTOR" => "".$overall_rate_descriptor.""
);
//include content-type header for JSON

header("Access-Control-Allow-Methods: POST");
//print the JSON encoded response
echo json_encode($response);
}
elseif($_GET['form_type'] == 'c'){
//check and validate input parameters values (work dimensions rates)
for($i = 1; $i <= 12; $i++) {
//check if it is a number or not, if not return an error message 
if(!is_numeric($_GET["work_dimension_rate_$i"])) {
$response = array(
"RESPONSE_CODE" => "110",
"RESPONSE_MESSAGE" => "parameter ".$_GET["work_dimension_rate_$i"]." not a number"
);
die(json_encode($response));
}
//the work dimension rate value should be between 1.00 and 5.00, if not return an error message
if($_GET["work_dimension_rate_$i"] < '1' OR $_GET["work_dimension_rate_$i"] > '5')
{
$response = array(
"RESPONSE_CODE" => "120",
"RESPONSE_MESSAGE" => "parameter ".$_GET["work_dimension_rate_$i"]." is less than 1.00 or greater than 5.00"
);

die(json_encode($response));
}
}
//get the work dimensions rates from the URL and store them in an array
for($i = 1; $i <= 12; $i++) {
$work_dimensions_rates_array[] = $_GET["work_dimension_rate_$i"];
}
//calculate the summation of the work dimensions rates
$work_dimensions_rates_sum = array_sum($work_dimensions_rates_array);
//calculate the average of the work dimensions rates
$work_dimensions_rates_avg = $work_dimensions_rates_sum/12;
//calculate the overall assessment rate (PMS formula)
$overall_rounded_rate = round($work_dimensions_rates_avg, 0);
//translate the overall assessment rate to a descriptor
if($overall_rounded_rate == '5') { $overall_rate_descriptor = 'Significantly Exceed Expectation'; }
elseif($overall_rounded_rate == '4') { $overall_rate_descriptor = 'Exceed Expectation'; }
elseif($overall_rounded_rate == '3') { $overall_rate_descriptor = 'Meets Expectation'; }
elseif($overall_rounded_rate == '2') { $overall_rate_descriptor = 'Below Expectation'; }
elseif($overall_rounded_rate == '1') { $overall_rate_descriptor = 'Significantly Below Expectation'; }
else { $overall_rate_descriptor = "NOT DEFINED"; }
//prepare the response and store it in an array
$response_code = "100";
$response_message = "successful";
$response = array(
"RESPONSE_CODE" => "".$response_code."",
"RESPONSE_MESSAGE" => "".$response_message."",
"OVERALL_RATE" => "".$overall_rounded_rate."",
"OVERALL_RATE_DESCRIPTOR" => "".$overall_rate_descriptor.""
);
echo json_encode($response);
}
else {
//if the value of the parameter form_type not a or b or c (not valid value), then return an error message
$response = array(
"RESPONSE_CODE" => "160",
"RESPONSE_MESSAGE" => "invalid value for parameter form_type"
);
die(json_encode($response));
}
?>