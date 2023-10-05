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

        <p>Based on your answers, we think the <span id="catBreed"></span> would be a great fit for your lifestyle!</p>
        <img id="catImage" src="/assets/placeholder.png"></img>
    
        <h2 id="catName"></h2>
        <p id="catAbout"></p>

        <div class="traits" id="catAffection">Affection Level
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catKids">Child Friendly
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catDogs">Dog Friendly
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catEnergy">Energy Level
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catGroom">Grooming Needs
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catShedding">Shedding Level
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catSocial">Social Needs
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

        <div class="traits" id="catTalkative">Vocalisation
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
            <span class="fa fa-star-o"></span>
        </div>

    </main>


<script>

// Store all answers in an array, then use this array
// in calcAnswer
var quizAnswers = [];
var breeds = [];
var selected_breed;
const url = 'https://api.thecatapi.com/v1/breeds';
const api_key = 'live_lUlnGGWyLHZwKDRycoHwC6BnE1cInxjgXNPHpKO9JjwiTA32jf7tcOd0qOyNEE93';
var catScores = new Array(67).fill(0);
var json = [];
var targetArr = [];

quizAnswers.push("<?php echo"$energy"?>");
quizAnswers.push("<?php echo"$affection"?>");
quizAnswers.push("<?php echo"$social"?>");
quizAnswers.push("<?php echo"$talkative"?>");
quizAnswers.push("<?php echo"$groom"?>");
quizAnswers.push("<?php echo"$shedding"?>");
quizAnswers.push("<?php echo"$kids"?>");
quizAnswers.push("<?php echo"$dogs"?>");

calcQuiz();

async function calcQuiz() {
    
    const response = await fetch(url);
    json = await response.json();
    
    console.log("Calculating scores");

    // Iterate through every trait and add points to cats
    // that fit the traits
    for (i = 0; i < 8; i++)
    {
        // Either answers don't affect points
        if (quizAnswers[i] == "Either")
        {
            continue;
        }

        targetArr = [];
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
            if (matchesLevel(i, j))
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
    
    this.selected_breed = json[bestIndex];
    document.getElementById("catBreed").innerHTML = this.selected_breed.name;
    if (this.selected_breed.reference_image_id)
    {
        const responseImage = await fetch("https://api.thecatapi.com/v1/images/" + this.selected_breed.reference_image_id);
        const jsonImage = await responseImage.json();
        document.getElementById("catImage").src = jsonImage.url;
    }
    
    document.getElementById("catName").innerHTML = this.selected_breed.name;
    document.getElementById("catAbout").innerHTML = this.selected_breed.description;
    
    showTraits();

}

function matchesLevel(i, j) {
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
    

    if (this.targetArr.includes(trait)) {
        return true;
    }
    else {
        return false;
    }
    
}

function showTraits() {
    var trait, score;
    trait = "catAffection";
    score = this.selected_breed.affection_level;
    scoreTrait(trait, score);
    
    trait = "catKids";
    score = this.selected_breed.child_friendly;
    scoreTrait(trait, score);
    
    trait = "catDogs";
    score = this.selected_breed.dog_friendly;
    scoreTrait(trait, score);
    
    trait = "catEnergy";
    score = this.selected_breed.energy_level;
    scoreTrait(trait, score);
    
    trait = "catGroom";
    score = this.selected_breed.grooming;
    scoreTrait(trait, score);
    
    trait = "catShedding";
    score = this.selected_breed.shedding_level;
    scoreTrait(trait, score);
    
    trait = "catSocial";
    score = this.selected_breed.social_needs;
    scoreTrait(trait, score);
    
    trait = "catTalkative";
    score = this.selected_breed.vocalisation;
    scoreTrait(trait, score);
    
}

// 1 <= n <= 5
// Fills in n stars out of 5 for trait
function scoreTrait(trait, n) {
  var i, x = document.getElementById(trait).childNodes;
  for (i = 1; i < 2*n; i += 2) {
  	x[i].className = "fa fa-star";
  }
}

async function showBengal() {
    const response = await fetch(url);
    json = await response.json();

    this.selected_breed = json[10];
    document.getElementById("catBreed").innerHTML = this.selected_breed.name;
}

</script>

</body>
</html>