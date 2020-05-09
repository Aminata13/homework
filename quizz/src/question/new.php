<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Questions</title>
</head>
<body>
<?php
    $question = '';
    $score = '';
    $type = '';
    $simpleAnswers = '';
    $multipleAnswers = '';
    $successMsg = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $question = test_input($_POST['question']);
        $score = (int)test_input($_POST['score']);
        $type = test_input($_POST['type']);
        $errors = validate_form_questions($_POST);
        $simpleAnswers = is_string_inside($_POST, 'label');
        $multipleAnswers = is_string_inside($_POST, 'text');
        if (empty($errors)) {
            create_questions($question, $score, $type, $_POST, $simpleAnswers, $multipleAnswers);
            $successMsg = true;
        }
        if ($successMsg) {
            $question = '';
            $score = '';
            $type = '';
        }
    }

?>
    <div class="create-questions-header">PARAMETRER VOTRE QUESTION</div>
    <div class="create-questions-container" id="create-questions-container">
        <form id="create-questions-form" class="form" action="" method="POST">
            <div class="form-content-questions">
                <label for="">Question</label>
                <input type="text" name="question" error="question-error" value="<?= $question ?>">
            </div>
            <div class="create-questions-error" id="question-error"><?php if(!empty($errors['question'])){echo $errors['question'];} ?></div>
            <div class="form-content-score">
                <label for="">Nombre de points</label>
                <input type="number" name="score" min=1 error="score-error" value="<?= $score ?>">
            </div>
            <div class="create-questions-error score-error" id="score-error"><?php if(!empty($errors['score'])){echo $errors['score'];} ?></div>
            <div class="form-content-type">
                <label for="">Type de réponse</label>
                <select name="type" id="question-type">
                    <option value="">Donnez le type de réponse</option>
                    <option <?php if ($type=='text') {echo 'selected';} ?> value="text">Texte</option>
                    <option <?php if ($type=='simple') {echo 'selected';} ?> value="simple">Simple</option>
                    <option <?php if ($type=='multiple') {echo 'selected';} ?> value="multiple">Multiple</option>
                </select>
                <img id="add-fields-img" src="public/icones/ic-ajout-réponse.png" alt="">
            </div>
            <div class="create-questions-error type-error" id="type-error"><?php if(!empty($errors['type'])){echo $errors['type'];} ?></div>
            <div class="answers-container" id="answers-container">
                <div class="text-answer">
                    <div class="text">Réponse</div>
                    <textarea id="textarea-answer" name="textarea" cols="80" rows="6"></textarea>
                </div>
                <div class="create-questions-error text-answer-error" id="text-answer-error"><?php if(!empty($errors['text-answer'])){echo $errors['text-answer'];} ?></div>
                <div class="simple-answer" id="id_1">
                    <div class="text">Réponse 1</div>
                    <input type="text" name="label1" error="simple-answer-error1">
                    <input type="radio" name="simple-answer" error="type-error" value="label1">
                    <img src="public/icones/ic-supprimer.png" alt="">
                </div>
                <div class="create-questions-error simple-answer-error" id="simple-answer-error1"><?php if(!empty($errors['simple-answer'])){echo $errors['simple-answer'];} ?></div>
                <div class="multiple-answer" id="id_1">
                    <div class="text">Réponse 1</div>
                    <input type="text" name="text1" error="multiple-answer-error1">
                    <input type="checkbox" name="answer1" error="type-error" value="text1">
                    <img src="public/icones/ic-supprimer.png" alt="">
                </div>
                <div class="create-questions-error multiple-answer-error" id="multiple-answer-error1"><?php if(!empty($errors['multiple-answer'])){echo $errors['multiple-answer'];} ?></div>
                <div id="new-fields-container" class="new-fields-container">
                    <?php 
                        if ($successMsg) {
                            echo '<div class="alert-msg success-msg"><i class="fa fa-check"></i> Question enregistrée avec succès!</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="btn-create">
                <input id="btn-submit" class="btn-next" type="submit" value="Enregistrer">
            </div>
        </form>
    </div>

    <script>
        document.getElementById("create-questions-form").addEventListener('mouseover', function() {
            const inputs = document.getElementsByTagName('input');
            for (input of inputs) {
                input.addEventListener('keyup', function(e){
                    if (e.target.hasAttribute('error')) {
                        var idDivError = e.target.getAttribute('error');
                        document.getElementById(idDivError).innerText = "";
                    }
                })
                if (input.type == "radio" || input.type == "checkbox") {
                    input.addEventListener('click', function() {
                        document.getElementById('type-error').innerText = "";
                    });
                }
                if (input.type == "number") {
                    input.addEventListener('click', function() {
                        document.getElementById('score-error').innerText = "";
                    });
                }
            }
            document.getElementById('textarea-answer').addEventListener('keyup', function(e) {
                document.getElementById('text-answer-error').innerText = "";
            });
        });

        document.getElementById('btn-submit').addEventListener('click', function(e){
            const inputs = document.getElementsByTagName('input');
            var error = false;
            for (input of inputs) {
                if (input.parentElement.style.display != "none" && input.hasAttribute('error')){
                    var idDivError = input.getAttribute('error');
                    if(!input.value) {
                        error = true;
                        document.getElementById(idDivError).innerText = "*Ce champ est obligatoire";
                    }
                }
            }
            const select = document.getElementById('question-type');
            const selectedValue = select.options[select.selectedIndex].value;
            if(selectedValue ==""){
                error = true;
                document.getElementById('type-error').innerText = "*Ce champ est obligatoire";
            }

            const text = document.getElementById('textarea-answer');
            if (text.parentElement.style.display != "none" && !text.value){
                error = true;
                document.getElementById('text-answer-error').innerText = "*Ce champ est obligatoire";
            }

            const checkedRadio = document.querySelectorAll('input[type="radio"]:checked');
            if (selectedValue == "simple" && checkedRadio.length == 0) {
                error = true;
                document.getElementById('type-error').innerText = "*Veuillez cocher la bonne réponse";
            }
            const radios = document.querySelectorAll('input[type="radio"]');
            if (selectedValue == "simple" && radios.length < 2) {
                error = true;
                document.getElementById('type-error').innerText = "*Veuillez remplir au moins deux champs réponses";
            }

            const checkbox = document.querySelectorAll('input[type="checkbox"]:checked');
            if (selectedValue == "multiple" && checkbox.length < 2) {
                error = true;
                document.getElementById('type-error').innerText = "*Veuillez cocher 2 réponses au moins";
            }
            if (error) {
                e.preventDefault();
                return false;
            }
        });
        document.getElementById("create-questions-form").addEventListener('click', function(e) {
            if (e.target.hasAttribute('id')) {    
                const elementId = e.srcElement.id;
                const element = document.getElementById(elementId);
                if(element.classList.contains("remove-fields-img")) {
                    const child = element.parentElement;
                    const input = child.children[1];
                    const idDivError = input.getAttribute('error');
                    const error = document.getElementById(idDivError);
                    document.getElementById("new-fields-container").removeChild(child);
                    document.getElementById("new-fields-container").removeChild(error);
                }
            }
        });

        document.getElementById("question-type").addEventListener('change', function() {
            document.getElementById('type-error').innerText = "";
            const selectedValue = this.options[this.selectedIndex].value;
            if (selectedValue == "text") {
                document.getElementById("create-questions-container").style.overflow = "visible";
                document.getElementById("new-fields-container").innerHTML = "";
                document.querySelector(".text-answer").style.display = "block";
                document.querySelector(".simple-answer").style.display = "none";
                document.querySelector(".multiple-answer").style.display = "none";

                document.querySelector(".text-answer-error").style.display = "block";
                document.querySelector(".simple-answer-error").style.display = "none";
                document.querySelector(".multiple-answer-error").style.display = "none";

                document.getElementById('text-answer-error').innerText = "";
            } else {
                if (selectedValue == "simple") {
                    document.getElementById("new-fields-container").innerHTML = "";
                    document.querySelector(".text-answer").style.display = "none";
                    document.querySelector(".simple-answer").style.display = "block";
                    document.querySelector(".multiple-answer").style.display = "none";

                    document.querySelector(".text-answer-error").style.display = "none";
                    document.querySelector(".simple-answer-error").style.display = "block";
                    document.querySelector(".multiple-answer-error").style.display = "none";

                    document.getElementById('simple-answer-error1').innerText = "";
                } else {
                    if (selectedValue == "multiple") {
                        document.getElementById("new-fields-container").innerHTML = "";
                        document.querySelector(".text-answer").style.display = "none";
                        document.querySelector(".simple-answer").style.display = "none";
                        document.querySelector(".multiple-answer").style.display = "block";

                        document.querySelector(".text-answer-error").style.display = "none";
                        document.querySelector(".simple-answer-error").style.display = "none";
                        document.querySelector(".multiple-answer-error").style.display = "block";

                        document.getElementById('multiple-answer-error1').innerText = "";
                    }
                }
            }
        });
        var i = 2; // Global Variable for simple answer
        var j = 2; // Global Variable for multiple answer
        document.getElementById("add-fields-img").addEventListener('click', function() {
            const select = document.getElementById("question-type");
            const selectedValue = select.options[select.selectedIndex].value;
            if (selectedValue == "simple") {
                const container = document.createElement('div');
                container.setAttribute("class", "simple-answer");
                container.setAttribute("id", "id_" + i);

                const div = document.createElement('div');
                div.setAttribute("class", "text");
                div.innerHTML = "Réponse " + i;

                const text = document.createElement('input');
                text.setAttribute("type", "text");
                text.setAttribute("name", "label" + i);
                text.setAttribute("error", "simple-answer-error" + i);

                const input = document.createElement('input');
                input.setAttribute("type", "radio");
                input.setAttribute("name", "simple-answer");
                input.setAttribute("value", "label" + i);

                const img = document.createElement('img');
                img.setAttribute("src", "public/icones/ic-supprimer.png");
                img.setAttribute("class", "remove-fields-img");
                img.setAttribute("id", "remove-img" + i);

                container.appendChild(div);
                container.appendChild(text);
                container.appendChild(input);
                container.appendChild(img);
                container.style.display = "block";

                document.getElementById("new-fields-container").appendChild(container);

                const error = document.createElement('div');
                error.setAttribute("class", "create-questions-error simple-answer-error");
                error.setAttribute("id", "simple-answer-error" + i);
                error.style.display = "block";

                document.getElementById("new-fields-container").appendChild(error);

                i++;
            } else {
                if (selectedValue == "multiple") {
                    const container = document.createElement('div');
                    container.setAttribute("class", "multiple-answer");
                    container.setAttribute("id", "id_" + j);

                    const div = document.createElement('div');
                    div.setAttribute("class", "text");
                    div.innerHTML = "Réponse " + j;

                    const text = document.createElement('input');
                    text.setAttribute("type", "text");
                    text.setAttribute("name", "text" + j);
                    text.setAttribute("error", "multiple-answer-error" + j);

                    const input = document.createElement('input');
                    input.setAttribute("type", "checkbox");
                    input.setAttribute("name", "answer" + j);
                    input.setAttribute("value", "text" + j);

                    const img = document.createElement('img');
                    img.setAttribute("src", "public/icones/ic-supprimer.png");
                    img.setAttribute("class", "remove-fields-img");
                    img.setAttribute("id", "remove-img" + j);

                    container.appendChild(div);
                    container.appendChild(text);
                    container.appendChild(input);
                    container.appendChild(img);
                    container.style.display = "block";

                    document.getElementById("new-fields-container").appendChild(container);

                    const error = document.createElement('div');
                    error.setAttribute("class", "create-questions-error multiple-answer-error");
                    error.setAttribute("id", "multiple-answer-error" + j);
                    error.style.display = "block";

                    document.getElementById("new-fields-container").appendChild(error);

                    j++;
                }
            }
            if (i>3 || j>3) {
                document.getElementById("create-questions-container").style.overflow = "auto";
            } 
        });
    </script>        
</body>
</html>