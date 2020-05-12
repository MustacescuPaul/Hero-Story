<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="container">
<!-- Name inputs and start button-->
<div class="text-center">
    <form action="" method="POST">
        <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup">Hero</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Hero's Name:</div>
                </div>
                <input type="text" name="hero" class="form-control" id="inlineFormInputGroup"
                       value="<?php echo isset($_POST['hero']) ? $_POST['hero'] : '' ?>" placeholder="Hero">
            </div>
        </div>
        <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup">Villain</label>
            <div class="input-group mb-2">
                <input type="text" name="villain" class="form-control" id="inlineFormInputGroup"
                       value="<?php echo isset($_POST['villain']) ? $_POST['villain'] : '' ?>" placeholder="Villain">
                <div class="input-group-prepend">
                    <div class="input-group-text">:Villain's Name</div>
                </div>
            </div>
        </div>
        <button type="submit" name="fight" class="btn btn-primary">Fight !</button>
    </form>
</div>
<div class="text-center">
    <?php

    require_once 'Characters/Hero.php';
    require_once 'Characters/Villain.php';


    if (isset($_POST['fight']) && (isset($_POST['hero']) && strlen($_POST['hero']) > 0) && (isset($_POST['villain']) && strlen($_POST['villain']) > 0)) {
        $stanhope = new Hero($_POST['hero'], 70, 100, 70, 80, 45, 55, 40, 50, 10, 30);
        $wildBeas = new Villain($_POST['villain'], 60, 90, 60, 90, 40, 60, 40, 60, 25, 40);
        //get the first attacker
        if ($stanhope->getSpeed() > $wildBeas->getSpeed()) {
            $turns = 19;
            $end = 0;
        } elseif ($stanhope->getSpeed() < $wildBeas->getSpeed()) {
            $turns = 20;
            $end = 1;
        } else {
            if ($stanhope->getLuck() > $wildBeas->getLuck()) {
                $turns = 19;
                $end = 0;
            } else {
                $turns = 20;
                $end = 1;
            }
        }

        while ($stanhope->checkHealth() > 0 && $wildBeas->checkHealth() > 0 && $turns >= $end) {
            //each turn display fighters healt
            echo '<div class="alert alert-light" role="alert">
                    ' . $_POST['hero'] . ' has ' . $stanhope->checkHealth() . ' health left <br>
                  </div>';
            echo '<div class="alert alert-light" role="alert">
                    ' . $_POST['villain'] . ' has ' . $wildBeas->checkHealth() . ' health left <br>
                  </div>';
            //our villain's turn to attack
            if ($turns % 2 == 0) {
                $attack = $wildBeas->attack();
                echo '<div class="alert alert-danger" role="alert">
                        ' . $_POST['villain'] . ' attacked for ' . $attack . ' damage<br>
                      </div>';
                if ($stanhope->hasLuckThisTurn()) {
                    echo '<div class="alert alert-success" role="alert">
                        ' . $_POST['hero'] . ' was LUCKY THIS TIME!<br>
                      </div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                        ' . $_POST['hero'] . ' has taken ' . $stanhope->defend($attack) . ' damage<br>
                      </div>';
                }
            }

            //our hero's turn to attack
            if ($turns % 2 != 0) {
                $attack = $stanhope->attack();
                //check for critlike effects
                //if he crits with Rapid Strike he attacks twice with same damage ( one or both of the attacks can be blocked if vs a player with magic shield
                if (is_array($attack)) {
                    $effect = $attack[1];
                    $attack = $attack[0];
                    if ($effect == 'crit') {
                        echo '<div class="alert alert-success" role="alert">
                                ' . $_POST['hero'] . ' attacked for ' . $attack . ' damage<br>
                              </div>';

                        if ($stanhope->hasLuckThisTurn()) {
                            echo '<div class="alert alert-danger" role="alert">
                                    ' . $_POST['villain'] . ' was LUCKY THIS TIME!<br>
                                  </div>';
                        } else {
                            echo '<div class="alert alert-primary" role="alert">
                                   ' . $_POST['villain'] . ' has taken ' . $wildBeas->defend($attack) . ' damage<br>
                                  </div>';
                        }
                    }
                }

                echo '<div class="alert alert-success" role="alert">
                        ' . $_POST['hero'] . ' attacked for ' . $attack . ' damage<br>
                      </div>';
                echo '<div class="alert alert-primary" role="alert">
                        ' . $_POST['villain'] . ' has taken ' . $wildBeas->defend($attack) . ' damage<br>
                      </div>';
            }
            $turns -= 1;
            if ($stanhope->checkHealth() <= 0) {
                echo '<div class="alert alert-dark" role="alert">
                        ' . $_POST['villain'] . ' won!!!
                     </div>';
                break;
            } elseif ($wildBeas->checkHealth() <= 0) {
                echo '<div class="alert alert-primary" role="alert">
                        ' . $_POST['hero'] . ' won!!!
                      </div>';
                break;
            }
        }
        if ($stanhope->checkHealth() > 0 && $wildBeas->checkHealth() > 0) {
            echo '<div class="alert alert-primary" role="alert">
                   TIE !!!
                  </div>';
        }
    } else {
        //intro page
        echo '<div class="alert alert-success text-left" role="alert">
                  <h4 class="alert-heading">Hello!</h4>
                  <p>You need to insert two names for our two fighters. Choose wisely because some heroes are more powerful than others!</p>
                  <p>(Stanhope has two special abilities)</p>
             </div>';
    } ?>
</div>
</body>
</html>
