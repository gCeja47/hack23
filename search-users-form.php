<?php
    function search_users(){
?>
    <form method="post" action="profiles.php" class="flexform">
        <fieldset class="flexform">
            <legend>Enter info to search for someone:</legend>

            <div>
            <label for="nameinput">Enter a name:</label>
            <input type="text" name="searched_name" id="nameinput" />
            </div>

            <div>
            <label for="ageinput">Enter an age (must be at least 18):</label>
            <input type="number" name="searched_age" id="ageinput" min="18" max="99" step="1" />
            </div>

            <div>
                <label>Enter a sex(es):</label>
                <input type="checkbox" name="searched_female" id="femaleinput" value="female" />
                <label for="femaleinput">Female</label>
                
                <input type="checkbox" name="searched_male" id="maleinput" value="male" />
                <label for="maleinput">Male</label>
                
                <input type="checkbox" name="searched_other" id="otherinput" value="other" />
                <label for="otherinput">Other/Intersex/Not Specified</label>
            </div>

        </fieldset>


        <input type="submit" name="search" value="Search" />
    </form>

<?php
    }
?>