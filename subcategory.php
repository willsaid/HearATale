<?php
require_once ('functions2.php');

$category = $_GET['cat'];

if($category == "Children") header( 'Location: children.php' ) ;
if($category == "Children/Stories/Classic Stories by Appeal") header('Location: subcategory_appeal.php');

$data = getAllInCategory($category);

$categoryExploded = explode("/", $category);
$categoryName = $categoryExploded[sizeof($categoryExploded) - 1];
$thumbnailCat = "images/section_icons/" . str_replace(" ", "_", str_replace("/", "!", $category)) . ".png";

$superCat = NULL;
$thumbnailSuperCat;
if(sizeof($categoryExploded) === 3){
	$superCat = $categoryExploded[1];
	$thumbnailSuperCat = "images/section_icons/Children!" . str_replace(" ", "_", str_replace("/", "!", $superCat)) . ".png";
}


?>

<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
	<!--<![endif]-->
	<head>

		<?php
		if(count($data) != 0) echo "<title>" . $categoryName . " - Hear a Tale</title>";
		else echo "<title>Not found - Hear a Tale</title>";
		include ($_SERVER['DOCUMENT_ROOT'] . '/globalHeader.php');
		?>

	</head>

	<body>

		<?php
		include ($_SERVER['DOCUMENT_ROOT'] . '/globalBody.php');
		?>


		<div class="span9" style="margin-left:5px; margin-right:5px;">
			<div style="clear: both;"></div>

			<?php
			if(count($data) == 0){
				error404('category');
			}else{
			?>

			<h1><strong><i>
				<?php
					if($superCat != NULL){
						echo "<a href='category.php?cat=Children/" . $superCat . "'><div>";
						if(file_exists($thumbnailSuperCat)) echo "<img style='padding-right:5px' src= ". $thumbnailSuperCat . ">";
						echo $superCat . ": </a>";
					}
					echo $categoryName;
					if(file_exists($thumbnailCat)) echo "<img style='padding-right:5px;' src= ". $thumbnailCat . ">";
				?>
			</i></strong></h1></br>

			<?php

			foreach($data as $work){
				if(!categoryEqual($work['Category'], $category)) continue;
				echo "<div style='padding-left: 105px; padding-bottom: 5px;'>";
				echo "<div style='float:left;'>";
                                if($work['FileLocation'] === ".txt") echo "<a href='writtentext.php?url=" . $work['FileLocation'] . "&cat=" . $work['Category'] . "'>";
                                else if($superCat === "World Languages" || $superCat == "Spanish") echo "<a href='writtenvideo.php?url=" . $work['FileLocation'] . "&cat=" . $work['Category'] . "&youtubeurl=" . $work['URL'] . "'>";
				else if($work['FileLocation'] != "") echo "<a href='video.php?url=" . $work['FileLocation'] . "&cat=" . $work['Category'] . "&youtubeurl=" . $work['URL'] . "'>";
				echo '<img style="height: 135px; width: auto; padding-right: 5px;" src="Thumbnails/' . str_replace("\\", "/", $work['ThumbnailImage']) . '">';
				echo "</div>";
				echo "<div style='width:600px; height: 135px; display: table-cell; vertical-align: middle;'>";
				echo "<h3 style='margin-bottom:0px; padding-top:0px; margin-top:-10px; float:left;'>" . $work['Title'] . "</p></h3>";
				if($work['FileLocation'] != "") echo "</a>";
				if($work["Length"] != "" || $work["Target"] != ""){
					echo "<div style='clear:both; padding-left: 5px; display: table-cell;'>";
					if($work["Target"] != ""){
						echo "<a title='Click for more info' href='ABOUT_storyAppeal.php'>";
						echo "<img style='width:15px' src='images/target_audience/" . $work["Target"] . ".png'></a>";
					}
					if($work["Length"] != "") echo " <b>[</b>" . $work['Length'] . "<b>]</b> ";
                                        if(strpos($categoryName, "Classic Stories") !== false){
                                        $textFileName = "work_text/" . $work['Title'] . ".txt";
                                        if($work['Experiences'] !== ""){
                                           echo "<a href='HomeExperiences.php?url=" . $work['Experiences'] . "'>?</a>";}}
                                       
					echo "</div>";
                                        
				}
				echo "<div style='clear:both; padding-left: 15px; text-align:justify; width:90%; max-width:450px;'>";
				echo ($work['FileLocation'] == "" && strpos($work['Title'], "Brier Patch") != 20 ? "<i>(Not Available)</i> " : "") . $work['Description'];
				if($work["Words"] != ""  && strpos($work['Title'], "Brier Patch") != 20) echo " " . $work["Words"] . " words.";
				echo "</div></div></div>";
			}

			?>


		<?php
		}
		include ($_SERVER['DOCUMENT_ROOT'] . '/globalFooter.php');
		?>