<?php
namespace app\models;

final class ExampleModel extends Model {

    public function getWelcomeMessage($username) {
        return "Welcome $username to Singular micro framework!";
    }

}

?>