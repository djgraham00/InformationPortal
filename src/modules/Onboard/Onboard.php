<?php

class Onboard extends MPModule {

    public $rts = array();

    protected function init() {
        $this->Parent->Modules['_AdminPanel']->registerPage("New Employee Onboarding", "./OnboardAdmin");
    }

    public function __initModels() {
        /* Init any models here */

    }

}
