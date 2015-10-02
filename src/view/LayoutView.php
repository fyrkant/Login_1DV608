<?php

namespace view;


class LayoutView
{

    public function render($isLoggedIn, LoginView $loginView, RegisterView $registerView, DateTimeView $dateTimeView)
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . ($loginView->userWantsToRegister() ? '<a href="?">Back to login</a>' : '<a href="?register">Register a new user</a>') .'
          ' . ($isLoggedIn ? '<h2>Logged in</h2>' : '<h2>Not logged in</h2>') . '
          
          <div class="container">
              ' .($loginView->userWantsToRegister() ? $registerView->generateRegisterFormHTML("") : $loginView->response($isLoggedIn)) . '
              
              ' . $dateTimeView->getHTML() . '
          </div>
         </body>
      </html>
    ';
    }
}
