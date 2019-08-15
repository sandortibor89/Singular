<?php
namespace app\controllers;

final class ExampleController extends Controller {

    public function index($request, $response) {
        $user_data = $request->getAttribute('user_data');

        $welcome_message = $this->ExampleModel->getWelcomeMessage($user_data['username']);

        $data = [
            'welcome' => $welcome_message
        ];

        return $this->view->render($response, 'home/index.twig', $data);
    }

}

?>