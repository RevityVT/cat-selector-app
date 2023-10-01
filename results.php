<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- favicon -->
  <link rel="shortcut icon" href="./assets/icons8-cat-96.png" type="image/x-icon">
  <!-- google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Indie+Flower%26family=Roboto:wght@300;400%26display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Roboto:wght@300;400&display=swap" rel="stylesheet"> 
  <!-- styles -->
  <link rel="stylesheet" href="style.css">
  <title>Cat Selector App | Cat Quiz</title>
</head>


<body>

    <main class="quizResults">

    <h1>Quiz Results</h1>

        <?php $energy = $_POST['energy-level']; ?>
        <?php $affection =  $_POST['affection']; ?>
        <?php $social = $_POST['social-needs']; ?>
        <?php $talkative = $_POST['talkative']; ?>
        <?php $groom = $_POST['groom-needs']; ?>
        <?php $shedding = $_POST['shedding']; ?>
        <?php $kids = $_POST['kids']; ?>
        <?php $dogs = $_POST['dogs']; ?>

    <p>Testing cat breed: This should show a Bengal.</p>
    <p>The name of the breed is: </p><span id="catBreed"></span>

    </main>


<script>

// Store all answers in an array, then use this array
// in calcAnswer
var quizAnswers = [];
var breeds = [];
var selected_breed = {};
const url = 'https://api.thecatapi.com/v1/breeds';
const api_key = 'live_lUlnGGWyLHZwKDRycoHwC6BnE1cInxjgXNPHpKO9JjwiTA32jf7tcOd0qOyNEE93';
var catScores = new Array(67).fill(0);
var json = [];

quizAnswers.push("<?php echo"$energy"?>");
quizAnswers.push("<?php echo"$affection"?>");
quizAnswers.push("<?php echo"$social"?>");
quizAnswers.push("<?php echo"$talkative"?>");
quizAnswers.push("<?php echo"$groom"?>");
quizAnswers.push("<?php echo"$shedding"?>");
quizAnswers.push("<?php echo"$kids"?>");
quizAnswers.push("<?php echo"$dogs"?>");

showBengal();
calcQuiz();

async function calcQuiz() {

    const response = await fetch(url);
    json = await response.json();

    // Iterate through every trait and add points to cats
    // that fit the traits
    for (i = 0; i < 8; i++)
    {
        // Either answers don't affect points
        if (quizAnswers[i] == "Either")
        {
            continue;
        }

        var targetArr = [];
        if (quizAnswers[i] == "Low") {
            targetArr = [1, 2];
        }
        else if (quizAnswers[i] == "Mid") {
            targetArr = [3];
        }
        else {
            targetArr = [4, 5];
        }
        if (i == 1 || i == 2) {
            if (quizAnswers[i] != "High") {
                targetArr= [];
                targetArr.push(3);
            }
        }

        // Iterate through all cat breeds and see which ones have matching traits
        for (j = 0; j < json.length; j++)
        {
            if (matchesLevel(i, j, targetArr))
            {
                catScores[j]++;
            }
        }
    }

    var bestIndex = 0;
    for (i = 0; i < catScores.length; i++)
    {
        if (catScores[i] > catScores[bestIndex]) {
            bestIndex = i;
        }
    }

    selected_breed = bestIndex;
    this.selected_breed = json[bestIndex];
    document.getElementById("catBreed").innerHTML = this.selected_breed.name;

    
}

function matchesLevel(i, j, target) {
    var trait;
    switch(i) {
        case 0:
            trait = json[j].energy_level;
            break;
        case 1:
            trait = json[j].affection_level;
            break;
        case 2:
            trait = json[j].social_needs;
            break;
        case 3:
            trait = json[j].vocalisation;
            break;
        case 4:
            trait = json[j].grooming;
            break;
        case 5:
            trait = json[j].shedding_level;
            break;
        case 6:
            trait = json[j].child_friendly;
            break;
        case 7:
            trait = json[j].dog_friendly;
            break;
        default:
            trait = json[j].dog_friendly;
        
    }
    

    if (target.includes(trait)) {
        return true;
    }
    else {
        return false;
    }
    
}

// Given n (position of a trait in quizAnswers)
// return the trait quizAnswers[n] corresponds to
// and the ideal number(s) the person wants for the trait
function bestLevel(n) {
    var trait;
    var target = [];
    if (quizAnswers[n] == "Low")
    {
        target.push(1);
        target.push(2);
    }
    else if (quizAnswers[n] == "Mid")
    {
        target.push(3);
    }
    else
    {
        target.push(4);
        target.push(5);
    }
    switch(n) {
        case 0:
            trait = "energy_level";
            break;
        case 1:
            trait = "affection_level";
            if (quizAnswers[n] == "Mid" || quizAnswers[n] == "Low")
            {
                target = [];
                target.push(3);
            }
            break;
        case 2:
            trait = "social_needs";
            if (quizAnswers[n] == "Low")
            {
                target = [];
                target.push(3);
            }
            break;
        case 3:
            trait = "vocalisation";
            break;
        case 4:
            trait = "grooming";
            break;
        case 5:
            trait = "shedding_level";
            break;
        case 6:
            trait = "child_friendly";
            break;
        case 7:
            trait = "dog_friendly";
            break;
        default:
            trait = "dog_friendly";
    }

    return [trait, target];
}

async function showBengal() {
    const response = await fetch(url);
    json = await response.json().parse();
    this.selected_breed = json[10];
    document.getElementById("catBreed").innerHTML = this.selected_breed.name;
}

</script>

</body>
</html>