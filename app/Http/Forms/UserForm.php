<?php

namespace Meritocracy\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('first_name', 'text', [
                'label' => 'Name',
                'rules' => 'required|min:5'
            ])
            ->add('last_name', 'text', [
                'label' => 'Post body',
                'rules' => 'required|min:5'
            ])
            ->add('email', 'email', [
                'label' => 'Post body',
                'rules' => 'required|email'
            ]);
    }
}
