<?php
session_start();


$dir = "pages";
$dirArray = array(); # array-ul cu directoarele profesorilor

$allFiles = scandir($dir);
$unNume ="ana";
#print_r($allFiles);

	foreach ($allFiles as $fileinfo) {
		if($fileinfo[0] == ".")
			continue;
		if($fileinfo[0].$fileinfo[1] == "u-")
        {
			# fiecare director u- este pus in vector (full path)
			$dirArray[] = $dir."/".$fileinfo;
		}
	}

	for($i = 0; $i < sizeof($dirArray); $i++)
	{
		#echo $dirArray[$i]."<br>";
		
		$imgDir = scandir($dirArray[$i]);
		
		for($j = 2; $j < sizeof($imgDir); $j++) # incep de dupa . si ..
		{
			$unNume =$dirArray[$i]."/";
			$unNume = $unNume.$imgDir[$j];
			#echo "Scanez $unNume"."<br>";
			echo '<img src="'.$unNume.'" />'; 
		}
	}
	
	# se descinde in fiecare fisier si se afiseaza poza
?>