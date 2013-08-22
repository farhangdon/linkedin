
<?php

include('simple_html_dom.php');

// Hi added This line !!!

/*

Helping Link Is ==> http://www.jacobward.co.uk/working-with-the-scraped-data-part-2/
UseFul Functions  

curl($url); // to grasp the whole webpage in a single variable as a string.
stristr($data, $start); // Stripping all data from before $start
stripos($data, $end);   // Getting the position of the $end of the data to scrape
substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape

With these above functions You can scrape any Webside.
*/


    // Defining the basic cURL function
    function curl($url) {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
        );
         
        $ch = curl_init();  // Initialising cURL 
        curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL 
        return $data;   // Returning the data from the function 
    }



    // Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }


?>


<?php


ini_set('max_execution_time', 600);
/*
   $url = "http://www.imdb.com/search/title?genres=action";    // Assigning the URL we want to scrape to the variable $url
    $results_page = curl($url); // Downloading the results page using our curl() funtion
     
    $results_page = scrape_between($results_page, "<div id=\"main\">", "<div id=\"sidebar\">"); 

echo $results_page ;
*/


//      $url = "http://www.cars.com/for-sale/new/_/N-ma8Zm5d?sf1Dir=DESC&rd=30&zc=11021&PMmt=0-0-0&stkTypId=28880&sf2Dir=ASC&sf1Nm=price&sf2Nm=location&rpp=50&feedSegId=28705&searchSource=UTILITY&crSrtFlds=stkTypId-feedSegId&pgId=2102&rn=100";    // Assigning the URL we want to scrape to the variable $url
//      $url="http://www.cars.com/for-sale/used/dealer/_/N-ma9Zma6Zm5d?prMx=6000&sf1Dir=DESC&prMn=0&rd=100000&zc=11021&PMmt=0-0-0&stkTypId=28881&sf2Dir=ASC&sf1Nm=price&sf2Nm=miles&rpp=50&feedSegId=28705&searchSource=GN_REFINEMENT&crSrtFlds=stkTypId-feedSegId-pseudoPrice-slrTypeId&pgId=2102&slrTypeId=28878";
  

         $url="http://www.cars.com/for-sale/used/dealer/_/N-ma9Zma6Zm5d?prMx=6000&sf1Dir=DESC&prMn=0&rd=100000&zc=11021&PMmt=0-0-0&stkTypId=28881&slrTypeId=28878&sf2Dir=ASC&sf1Nm=price&sf2Nm=miles&rpp=50&feedSegId=28705&searchSource=UTILITY&crSrtFlds=stkTypId-feedSegId-pseudoPrice-slrTypeId&pgId=2102&rn=50";

  $results_page = curl($url); // Downloading the results page using our curl() funtion


$start = stripos($results_page, "resultswrapper");
$stop  = stripos($results_page, "skyscraperRail");


echo $start . "<br>";
echo $stop  . "<br>"; 
echo "changed";


$results_page = stristr($results_page, "<div class=\"col38 no-padding\" id=\"resultswrapper\">");  // level //

$results_page = substr($results_page, 0, stripos($results_page, "skyscraperRail"));

$separate_results = explode("<h4 class=\"secondary\">", $results_page);



$file = fopen("output.txt","w");


    foreach ($separate_results as $separate_result) {
        if ($separate_result != "") {
          

        $results_urls[] = "http://www.cars.com" . scrape_between($separate_result, "<a name=\"&lid=md-ymmt\" rel=\"nofollow\" href=\"", "\""); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
      


        

 }
    }
     
    print_r($results_urls); // Printing out our array of URLs we've just scraped




fclose($file);





echo "********************************************************************************";

echo "<br> <br> List of IDs";

for($lpc=1;$lpc<51;$lpc++){

$sp=$results_urls[$lpc];
$p= stripos($results_urls[$lpc], "listingId=");

echo " <br> <br> <br> The index is " . $p . "<br> <br> <br>";

$cid="";

for($u=96;$u<105;$u++){

$cid.=$sp[$u];
echo $sp[$u];


}
$results_ids[]=$cid;
echo "<br>";

}

echo "<br> <br> <br>";


print_r($results_ids);

echo $cid;
//************************************** Using URLS and Retriving Data **********************************************


for ($h=0;$h<50;$h++){

echo "The car Number # " . $h+1 . "<br>";

$ss="http://www.cars.com/go/search/detail.jsp?tracktype=usedcc&csDlId=&csDgId=&listingId={$results_ids[$h]}&listingRecNum=101&criteria=prMx%3D6000%26sf1Dir%3DDESC%26prMn%3D0%26stkTyp%3DU%26rd%3D100000%26crSrtFlds%3DstkTypId-feedSegId-pseudoPrice-slrTypeId%26zc%3D11021%26rn%3D100%26PMmt%3D0-0-0%26stkTypId%3D28881%26slrTypeId%3D28878%26sf2Dir%3DASC%26sf1Nm%3Dprice%26sf2Nm%3Dmiles%26isDealerGrouping%3Dfalse%26rpp%3D50%26feedSegId%3D28705&aff=national&listType=1";


echo "<br>" . $ss . "<br>";

$html = file_get_html($ss);


echo "******************************** Car Detail Starts From Here ************************************* <br>";

foreach($html->find('title') as $e)
    echo $e->innertext . '<br>';



foreach($html->find('h2#aboutThisH2') as $e)
    echo $e->innertext . '<br>';

$s=1;

foreach($html->find('span.label') as $e)    {

if($s==12){

}
else{
    echo $e->innertext . '<br>';
}

$s++;
                                          }
echo " <br> ------------------- <br>";

$i=1;
foreach($html->find('span.data') as $e){

if($i<3){
}
else{

if($i==12){ echo " <br> About The Dealer <br> ";}
    echo $e->innertext . '<br>';
}

$i++;
                     
              }



echo "<br> Photo Links Below <br> ------------------- <br>";



foreach($html->find('img') as $e){

$cls = $e->class;

if($cls == "photo"){
    echo $e->src . '<br>';
}

}


echo "******************************** Car Detail Ends Here ************************************* <br>";

}
// ***********************************************************************************************

   // echo $results_page;




   
/*
 
       $separate_results = explode("<td class=\"image\">", $results_page); 

            foreach ($separate_results as $separate_result) {
            if ($separate_result != "") {
                $results_urls[] = "http://www.imdb.com" . scrape_between($separate_result, "data-tconst=\"", "\" data-size="); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
            }

            
}

print_r($results_urls);

echo "flag";

*/

//******************************  UseFul Code Below **************************************//

/*

ini_set('max_execution_time', 600);

      $url = "http://www.imdb.com/search/title?genres=action";    // Assigning the URL we want to scrape to the variable $url
    $results_page = curl($url); // Downloading the results page using our curl() funtion
     
    $results_page = scrape_between($results_page, "<div id=\"main\">", "<div id=\"sidebar\">");  // Scraping out only the middle section of the results page that contains our results
     
       $separate_results = explode("<td class=\"image\">", $results_page); 

            foreach ($separate_results as $separate_result) {
            if ($separate_result != "") {
                $results_urls[] = "http://www.imdb.com" . scrape_between($separate_result, "data-tconst=\"", "\" data-size="); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
            }

            
}

print_r($results_urls);

echo "flag";
*/
//***************************************************************************************//

 /*   $url = "http://www.cars.com/for-sale/searchresults.action?prMx=6000&sf1Dir=DESC&prMn=0&bsId=20214&bsId=20202&bsId=20203&bsId=20218&bsId=20209&bsId=20206&bsId=20220&bsId=20212&bsId=20210&bsId=20211&bsId=20217&bsId=20216&rd=100000&zc=11021&PMmt=0-0-0&stkTypId=28881&slrTypeId=28878&sf2Dir=ASC&sf1Nm=price&sf2Nm=miles&rpp=50&feedSegId=28705&searchSource=UTILITY&crSrtFlds=stkTypId-feedSegId-pseudoPrice-slrTypeId-bsId&pgId=2102&rn=100";    // Assigning the URL we want to scrape to the variable $url
    $results_page = curl($url); // Downloading the results page using our curl() funtion


	
 
    $results_page = scrape_between($results_page, "<div id=\"page\">", "<div class=\"row disclaimer\">"); // Scraping out only the middle section of the results page that contains our results
     
    $separate_results = explode("<span class=\"credit\">", $results_page);   // Expploding the results into separate parts into an array
         


    // For each separate result, scrape the URL
    foreach ($separate_results as $separate_result) {
        if ($separate_result != "") {
            $results_urls[] = "http://www.cars.com" . scrape_between($separate_result, "<a>\"", "\" <a>"); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
        }
    }
     
    print_r($results_urls); // Printing out our array of URLs we've just scraped

*/


?>