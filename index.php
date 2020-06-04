<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imam-kuham</title>

    <!-- Style link-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Boostrap 4 link-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <form method="POST" action="index.php" method="POST" class="formaZaUnos" name="unosPodatakaForma">
            <br/><h3 style="text-align:center">Recipe form</h3>
            <div class="form-group">
                <label for="imeRecepta">Recipe name:</label>
                <input class="form-control" type="text" id="imeRecepta" placeholder="Recipe name:" name="imeRecepta" required autofocus>
            </div>
            <div class="form-group">
                <label for="vjestina">Recipe complexity (1-5):</label>
                <input class="form-control" type="number" id="vjestina" placeholder="Recipe complexity:" name="vjestina" min="1" max="5" value="1" required>
            </div>
            <div class="form-group">
                <label for="sastojci">Ingredients list (split with a comma):</label>
                <input class="form-control" type="text" id="sastojci" placeholder="Ingredients:" name="sastojci" required autofocus>
            </div>
            <div class="form-group">
                <label for="koraci">Recipe steps (split with a comma):</label>
                <textarea class="form-control" id="koraci" rows="15" name="kratkiSazetak" placeholder="Recipe steps:" required></textarea>
            </div>
            <div class="form-group">
                <label for="vrijeme">Time needed to prepare (in minutes, max: 600):</label>
                <input class="form-control" type="number" id="vrijeme" placeholder="Vrijeme" name="vrijeme" min="1" max="600" value="1" required>
            </div>
            <div class="form-group">
                <label for="volumeOfPeople">For how many people is the recipe made for:</label>
                <input type="range" class="custom-range" min="1" max="12" step="1" id="volumeOfPeople" value="0" name="ljudi">
                <span>Volume: <span id="volumeOfPeopleValue"></span></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="vegan" value="yes">
                <label class="form-check-label" for="inlineCheckbox1">Vegan friendly</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="glukoza" value="yes">
                <label class="form-check-label" for="inlineCheckbox2">Glucose</label>
            </div>
            <div class="form-group">
                <br/><button type="submit" class="btn btn-primary" name="posalji" id="gumbZaSlanje">Turn to XML</button>
            </div>
            <br/>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $('#volumeOfPeople').on('change', function(e) {
            var id = e.target.value;
            document.getElementById("volumeOfPeopleValue").innerHTML = id;
        });
        $('#volumeOfPeople').change();
    </script>
</body>

</html>

<?php
if (isset($_POST['posalji'])) {
    $imeRecepta = $_POST['imeRecepta'];
    $vjestina = $_POST['vjestina'];
    $sastojci = $_POST['sastojci'];
    $koraci = $_POST['kratkiSazetak'];
    $vrijeme = $_POST['vrijeme'];
    $ljudi = $_POST['ljudi'];

    $sastojciArray = explode(", ", $sastojci);
    $koraciArray = explode(", ", $koraci);

    if (isset($_POST['vegan']) && $_POST['vegan'] == 'yes') {
        $vegan = 'Yes';
    } else {
        $vegan = 'No';
    }
    if (isset($_POST['glukoza']) && $_POST['glukoza'] == 'yes') {
        $glucose = 'Yes';
    } else {
        $glucose = 'No';
    }

    $result = '<?xml version="1.0" encoding="UTF-8"?>';

    $result .= "\n";

    $result .= "<Recipe>\n";

    //recipe name
    $result .= '<RecipeName>' . $imeRecepta . "</RecipeName>\n";

    //recipe complexity
    $result .= '<RecipeComplexity>' . $vjestina . "</RecipeComplexity>\n";

    //ingredients
    $result .= "<Ingredients>\n";
    foreach ($sastojciArray as &$value) {
        $result .= '<Ingredient>' . $value . "</Ingredient>\n";
    }
    $result .= "</Ingredients>\n";

    //steps of making the actual recipe
    $result .= "<Steps>\n";
    foreach ($koraciArray as &$step) {
        $result .= '<Step>' . $step . "</Step>\n";
    }
    $result .= "</Steps>\n";

    //time needed to prepare
    $result .= '<Time>' . $vrijeme . "</Time>\n";

    //ammount of people the recipe is made for
    $result .= '<PeopleAmount>' . $ljudi . "</PeopleAmount>\n";

    //check if vegan friendly
    $result .= '<Vegan>' . $vegan . "</Vegan>\n";

    //check if glucose friendly
    $result .= '<Glucose>' . $glucose . "</Glucose>\n";

    $result .= "</Recipe>";

    //Generating XML
    $filename = 'recipes/recipe' . date('Y_m_d_h_i_s') . '.xml';
    file_put_contents($filename, $result);
    die('XML generated!');
}


?>